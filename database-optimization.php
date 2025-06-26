<?php

/**
 * Siteefy Database Optimization
 * 
 * This file contains functions to optimize the WordPress database
 * for better performance with large numbers of custom post types.
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Add database indexes for better performance
 */
function siteefy_add_database_indexes() {
    global $wpdb;
    
    // Check if indexes already exist to avoid duplicates
    $indexes = $wpdb->get_results("SHOW INDEX FROM {$wpdb->posts}");
    $existing_indexes = array();
    
    foreach ($indexes as $index) {
        $existing_indexes[] = $index->Key_name;
    }
    
    // Add composite index for post_type and post_status
    if (!in_array('idx_post_type_status', $existing_indexes)) {
        $wpdb->query("CREATE INDEX idx_post_type_status ON {$wpdb->posts} (post_type, post_status)");
    }
    
    // Add index for post_date
    if (!in_array('idx_post_date', $existing_indexes)) {
        $wpdb->query("CREATE INDEX idx_post_date ON {$wpdb->posts} (post_date)");
    }
    
    // Add composite index for post_type, post_status, and post_date
    if (!in_array('idx_type_status_date', $existing_indexes)) {
        $wpdb->query("CREATE INDEX idx_type_status_date ON {$wpdb->posts} (post_type, post_status, post_date)");
    }
    
    // Add index for post_title (for search optimization)
    if (!in_array('idx_post_title', $existing_indexes)) {
        $wpdb->query("CREATE INDEX idx_post_title ON {$wpdb->posts} (post_title(50))");
    }
    
    // Add index for post_name (for permalink optimization)
    if (!in_array('idx_post_name', $existing_indexes)) {
        $wpdb->query("CREATE INDEX idx_post_name ON {$wpdb->posts} (post_name)");
    }
    
    // Add composite index for post_type and post_name
    if (!in_array('idx_type_name', $existing_indexes)) {
        $wpdb->query("CREATE INDEX idx_type_name ON {$wpdb->posts} (post_type, post_name)");
    }
}

/**
 * Optimize posts table
 */
function siteefy_optimize_posts_table() {
    global $wpdb;
    
    // Optimize the posts table
    $wpdb->query("OPTIMIZE TABLE {$wpdb->posts}");
    
    // Analyze the table for better query planning
    $wpdb->query("ANALYZE TABLE {$wpdb->posts}");
    
    return true;
}

/**
 * Clean up orphaned post meta
 */
function siteefy_cleanup_orphaned_meta() {
    global $wpdb;
    
    // Delete orphaned post meta
    $wpdb->query("
        DELETE pm FROM {$wpdb->postmeta} pm 
        LEFT JOIN {$wpdb->posts} p ON pm.post_id = p.ID 
        WHERE p.ID IS NULL
    ");
    
    return true;
}

/**
 * Clean up orphaned term relationships
 */
function siteefy_cleanup_orphaned_term_relationships() {
    global $wpdb;
    
    // Delete orphaned term relationships
    $wpdb->query("
        DELETE tr FROM {$wpdb->term_relationships} tr 
        LEFT JOIN {$wpdb->posts} p ON tr.object_id = p.ID 
        WHERE p.ID IS NULL
    ");
    
    return true;
}

/**
 * Get database statistics
 */
function siteefy_get_database_stats() {
    global $wpdb;
    
    $stats = array();
    
    // Get total posts count
    $stats['total_posts'] = $wpdb->get_var("SELECT COUNT(*) FROM {$wpdb->posts}");
    
    // Get posts by type
    $stats['posts_by_type'] = $wpdb->get_results("
        SELECT post_type, COUNT(*) as count 
        FROM {$wpdb->posts} 
        GROUP BY post_type
    ");
    
    // Get table size
    $table_size = $wpdb->get_row("
        SELECT 
            ROUND(((data_length + index_length) / 1024 / 1024), 2) AS 'size_mb'
        FROM information_schema.tables 
        WHERE table_schema = DATABASE() 
        AND table_name = '{$wpdb->posts}'
    ");
    $stats['table_size_mb'] = $table_size ? $table_size->size_mb : 0;
    
    // Get index information
    $stats['indexes'] = $wpdb->get_results("SHOW INDEX FROM {$wpdb->posts}");
    
    return $stats;
}

/**
 * Optimize queries for custom post types
 */
function siteefy_optimize_cpt_queries($query) {
    // Only optimize on frontend
    if (is_admin()) {
        return $query;
    }
    
    // Optimize queries for tool and task post types
    if ($query->is_main_query() && 
        ($query->is_post_type_archive('tool') || 
         $query->is_post_type_archive('task') || 
         $query->is_tax('solution') || 
         $query->is_tax('category'))) {
        
        // Set posts per page to a reasonable limit
        if (!$query->get('posts_per_page')) {
            $query->set('posts_per_page', 12);
        }
        
        // Add orderby for better performance
        if (!$query->get('orderby')) {
            $query->set('orderby', 'date');
            $query->set('order', 'DESC');
        }
        
        // Disable unnecessary queries
        $query->set('no_found_rows', true);
        $query->set('update_post_meta_cache', false);
        $query->set('update_post_term_cache', false);
    }
    
    return $query;
}
add_action('pre_get_posts', 'siteefy_optimize_cpt_queries');

/**
 * Optimize get_posts queries
 */
function siteefy_optimize_get_posts_args($args, $post_type) {
    // Add performance optimizations for tool and task queries
    if (in_array($post_type, ['tool', 'task'])) {
        $args['no_found_rows'] = true;
        $args['update_post_meta_cache'] = false;
        $args['update_post_term_cache'] = false;
        
        // Add orderby if not set
        if (!isset($args['orderby'])) {
            $args['orderby'] = 'date';
            $args['order'] = 'DESC';
        }
    }
    
    return $args;
}
add_filter('siteefy_get_posts_args', 'siteefy_optimize_get_posts_args', 10, 2);

/**
 * Add database optimization to admin
 */
function siteefy_add_database_optimization_admin() {
    // Handle optimization actions
    if (isset($_POST['siteefy_optimize_database']) && wp_verify_nonce($_POST['siteefy_db_nonce'], 'siteefy_optimize_database')) {
        siteefy_add_database_indexes();
        siteefy_optimize_posts_table();
        siteefy_cleanup_orphaned_meta();
        siteefy_cleanup_orphaned_term_relationships();
        echo '<div class="notice notice-success"><p>Database optimized successfully!</p></div>';
    }
    
    // Get database statistics
    $stats = siteefy_get_database_stats();
    
    ?>
    <div class="wrap">
        <h1>Siteefy Database Optimization</h1>
        
        <div class="siteefy-db-stats">
            <h2>Database Statistics</h2>
            <table class="form-table">
                <tr>
                    <th>Total Posts</th>
                    <td><?php echo number_format($stats['total_posts']); ?></td>
                </tr>
                <tr>
                    <th>Posts Table Size</th>
                    <td><?php echo $stats['table_size_mb']; ?> MB</td>
                </tr>
                <tr>
                    <th>Posts by Type</th>
                    <td>
                        <?php foreach ($stats['posts_by_type'] as $type): ?>
                            <strong><?php echo $type->post_type; ?>:</strong> <?php echo number_format($type->count); ?><br>
                        <?php endforeach; ?>
                    </td>
                </tr>
            </table>
        </div>
        
        <div class="siteefy-db-optimization">
            <h2>Database Optimization</h2>
            <form method="post" action="">
                <?php wp_nonce_field('siteefy_optimize_database', 'siteefy_db_nonce'); ?>
                <p>This will:</p>
                <ul>
                    <li>Add database indexes for better performance</li>
                    <li>Optimize the posts table</li>
                    <li>Clean up orphaned post meta</li>
                    <li>Clean up orphaned term relationships</li>
                </ul>
                <input type="submit" name="siteefy_optimize_database" class="button button-primary" value="Optimize Database">
            </form>
        </div>
        
        <div class="siteefy-db-indexes">
            <h2>Database Indexes</h2>
            <table class="wp-list-table widefat fixed striped">
                <thead>
                    <tr>
                        <th>Index Name</th>
                        <th>Columns</th>
                        <th>Cardinality</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($stats['indexes'] as $index): ?>
                        <tr>
                            <td><?php echo $index->Key_name; ?></td>
                            <td><?php echo $index->Column_name; ?></td>
                            <td><?php echo number_format($index->Cardinality); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
    <?php
}

/**
 * Add database optimization to admin menu
 */
function siteefy_add_db_optimization_menu() {
    add_submenu_page(
        'siteefy-options',
        'Database Optimization',
        'Database Optimization',
        'manage_options',
        'siteefy-database',
        'siteefy_add_database_optimization_admin'
    );
}
add_action('admin_menu', 'siteefy_add_db_optimization_menu', 15);

/**
 * Run database optimization on plugin activation
 */
function siteefy_activate_database_optimization() {
    // Add indexes
    siteefy_add_database_indexes();
    
    // Optimize table
    siteefy_optimize_posts_table();
}
register_activation_hook(__FILE__, 'siteefy_activate_database_optimization');

/**
 * Monitor query performance
 */
function siteefy_monitor_query_performance($query, $query_time) {
    // Only log slow queries (over 1 second)
    if ($query_time > 1.0) {
        error_log("Siteefy Slow Query: {$query_time}s - {$query}");
    }
    
    // Store performance data in cache
    $performance_data = siteefy_get_cache('siteefy_query_performance') ?: array();
    $performance_data[] = array(
        'query' => $query,
        'time' => $query_time,
        'timestamp' => current_time('timestamp')
    );
    
    // Keep only last 100 queries
    if (count($performance_data) > 100) {
        $performance_data = array_slice($performance_data, -100);
    }
    
    siteefy_set_cache('siteefy_query_performance', $performance_data, 3600);
}

/**
 * Get query performance statistics
 */
function siteefy_get_query_performance_stats() {
    $performance_data = siteefy_get_cache('siteefy_query_performance') ?: array();
    
    if (empty($performance_data)) {
        return array();
    }
    
    $total_queries = count($performance_data);
    $total_time = array_sum(array_column($performance_data, 'time'));
    $avg_time = $total_time / $total_queries;
    $slow_queries = array_filter($performance_data, function($query) {
        return $query['time'] > 1.0;
    });
    
    return array(
        'total_queries' => $total_queries,
        'total_time' => $total_time,
        'avg_time' => $avg_time,
        'slow_queries' => count($slow_queries),
        'performance_data' => $performance_data
    );
} 