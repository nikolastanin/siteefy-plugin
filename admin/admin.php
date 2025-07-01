<?php

/**
 * Siteefy Admin Settings
 * 
 * This file handles the admin interface for Siteefy plugin settings,
 * including cache management and preload URL configuration.
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}


/**
 * Main Siteefy admin page
 */
function siteefy_admin_page() {
    ?>
    <div class="wrap">
        <h1>Siteefy Settings</h1>
        <p>Welcome to Siteefy plugin administration. Use the submenu to manage different aspects of the plugin.</p>
        
        <div class="siteefy-admin-overview">
            <h2>Plugin Overview</h2>
            <?php
            $status = siteefy_get_cache_preload_status();
            ?>
            <table class="form-table">
                <tr>
                    <th>Object Cache Pro</th>
                    <td><?php echo $status['object_cache_pro'] ? '<span style="color: green;">✓ Active</span>' : '<span style="color: red;">✗ Inactive</span>'; ?></td>
                </tr>
                <tr>
                    <th>WP Rocket</th>
                    <td><?php echo $status['wp_rocket'] ? '<span style="color: green;">✓ Active</span>' : '<span style="color: red;">✗ Inactive</span>'; ?></td>
                </tr>
                <tr>
                    <th>Cache Enabled</th>
                    <td><?php echo $status['cache_enabled'] ? '<span style="color: green;">✓ Enabled</span>' : '<span style="color: orange;">⚠ Disabled (Development Mode)</span>'; ?></td>
                </tr>
                <tr>
                    <th>Recent Tools</th>
                    <td><?php echo $status['recent_tools_count']; ?> tools</td>
                </tr>
                <tr>
                    <th>Recent Tasks</th>
                    <td><?php echo $status['recent_tasks_count']; ?> tasks</td>
                </tr>
                <tr>
                    <th>Solutions</th>
                    <td><?php echo $status['solutions_count']; ?> solutions</td>
                </tr>
                <tr>
                    <th>Categories</th>
                    <td><?php echo $status['categories_count']; ?> categories</td>
                </tr>
            </table>
        </div>
    </div>
    <?php
}

/**
 * Combined Cache Management and Preload URLs admin page
 */
function siteefy_cache_admin_page() {
    // Handle cache purge action
    if (isset($_POST['siteefy_purge_cache']) && wp_verify_nonce($_POST['siteefy_cache_nonce'], 'siteefy_purge_cache')) {
        siteefy_manual_purge_cache();
        echo '<div class="notice notice-success"><p>Cache purged successfully!</p></div>';
    }
    
    // Handle preload URLs form submission
    if (isset($_POST['siteefy_save_preload_urls']) && wp_verify_nonce($_POST['siteefy_preload_nonce'], 'siteefy_save_preload_urls')) {
        $preload_urls = array();
        
        // Get URLs from textarea
        $urls_text = sanitize_textarea_field($_POST['siteefy_preload_urls']);
        $urls_lines = explode("\n", $urls_text);
        
        foreach ($urls_lines as $line) {
            $url = trim($line);
            if (!empty($url)) {
                // Validate URL
                if (filter_var($url, FILTER_VALIDATE_URL) || strpos($url, '/') === 0) {
                    $preload_urls[] = $url;
                }
            }
        }
        
        // Save to WordPress options
        update_option('siteefy_preload_urls', $preload_urls);
        echo '<div class="notice notice-success"><p>Preload URLs saved successfully!</p></div>';
    }
    
    // Handle preload cache action with results
    $preload_results = array();
    if (isset($_POST['siteefy_preload_cache']) && wp_verify_nonce($_POST['siteefy_cache_nonce'], 'siteefy_purge_cache')) {
        if (function_exists('siteefy_preload_cache')) {
            $preload_results = siteefy_preload_cache(true); // Pass true for test mode
            echo '<div class="notice notice-success"><p>Cache preload completed! Results are shown below.</p></div>';
        } else {
            echo '<div class="notice notice-error"><p>Error: siteefy_preload_cache function not found!</p></div>';
        }
    }
    
    // Get current preload URLs
    $current_urls = get_option('siteefy_preload_urls', array());
    $urls_text = implode("\n", $current_urls);
    
    ?>
    <div class="wrap">
        <h1>Siteefy Cache Management & Preload Configuration</h1>
        
        <div class="siteefy-cache-actions">
            <h2>Cache Actions</h2>
            <form method="post" action="">
                <?php wp_nonce_field('siteefy_purge_cache', 'siteefy_cache_nonce'); ?>
                <table class="form-table">
                    <tr>
                        <th>Purge All Cache</th>
                        <td>
                            <input type="submit" name="siteefy_purge_cache" class="button button-primary" value="Purge All Cache">
                            <p class="description">This will clear all Siteefy cache, Object Cache Pro cache, and WP Rocket cache.</p>
                        </td>
                    </tr>
                    <tr>
                        <th>Preload Cache</th>
                        <td>
                            <input type="submit" name="siteefy_preload_cache" class="button button-secondary" value="Preload Cache">
                            <p class="description">This will preload all configured URLs to warm up the cache and show detailed results below.</p>
                        </td>
                    </tr>
                </table>
            </form>
        </div>
        
        <div class="siteefy-cache-status">
            <h2>Cache Status</h2>
            <?php
            $status = siteefy_get_cache_preload_status();
            ?>
            <table class="form-table">
                <tr>
                    <th>Object Cache Pro</th>
                    <td><?php echo $status['object_cache_pro'] ? '<span style="color: green;">✓ Active</span>' : '<span style="color: red;">✗ Inactive</span>'; ?></td>
                </tr>
                <tr>
                    <th>WP Rocket</th>
                    <td><?php echo $status['wp_rocket'] ? '<span style="color: green;">✓ Active</span>' : '<span style="color: red;">✗ Inactive</span>'; ?></td>
                </tr>
                <tr>
                    <th>Cache Enabled</th>
                    <td><?php echo $status['cache_enabled'] ? '<span style="color: green;">✓ Enabled</span>' : '<span style="color: orange;">⚠ Disabled (Development Mode)</span>'; ?></td>
                </tr>
            </table>
        </div>
        
        <div class="siteefy-preload-config">
            <h2>Preload URL Configuration</h2>
            <p>Configure URLs that should be preloaded after cache purging. Each URL should be on a separate line.</p>
            <p>Cache is preloaded on every new post creation/update. You can also manually preload the cache by clicking the "Preload Cache" button above.</p>
            <p><strong>Examples:</strong></p>
            <ul>
                <li><code><?php echo home_url('/'); ?></code> - Homepage</li>
                <li><code><?php echo home_url('/tools/'); ?></code> - Tools archive</li>
                <li><code>/about/</code> - Relative URL</li>
                <li><code>https://example.com/page</code> - Absolute URL</li>
            </ul>
            
            <form method="post" action="">
                <?php wp_nonce_field('siteefy_save_preload_urls', 'siteefy_preload_nonce'); ?>
                <table class="form-table">
                    <tr>
                        <th scope="row">
                            <label for="siteefy_preload_urls">Preload URLs</label>
                        </th>
                        <td>
                            <textarea 
                                name="siteefy_preload_urls" 
                                id="siteefy_preload_urls" 
                                rows="10" 
                                cols="80" 
                                class="large-text code"
                                placeholder="<?php echo home_url('/'); ?>&#10;<?php echo home_url('/tools/'); ?>&#10;<?php echo home_url('/tasks/'); ?>&#10;<?php echo home_url('/solutions/'); ?>&#10;<?php echo home_url('/categories/'); ?>"
                            ><?php echo esc_textarea($urls_text); ?></textarea>
                            <p class="description">
                                Enter one URL per line. These URLs will be preloaded after cache purging to ensure fast page loads.
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row">Default URLs</th>
                        <td>
                            <p>The following URLs are automatically preloaded (in addition to your custom URLs):</p>
                            <ul>
                                <li><code><?php echo home_url('/'); ?></code> - Homepage</li>
                                <li><code><?php echo home_url('/?s='); ?></code> - Search page</li>
                                <li><code><?php echo home_url('/tools/'); ?></code> - Tools archive</li>
                                <li><code><?php echo home_url('/tasks/'); ?></code> - Tasks archive</li>
                                <li><code><?php echo home_url('/solutions/'); ?></code> - Solutions archive</li>
                                <li><code><?php echo home_url('/categories/'); ?></code> - Categories archive</li>
                                <li>Recent tool and task pages</li>
                                <li>Popular solution and category pages</li>
                            </ul>
                        </td>
                    </tr>
                </table>
                
                <p class="submit">
                    <input type="submit" name="siteefy_save_preload_urls" class="button button-primary" value="Save Preload URLs">
                </p>
            </form>
        </div>
        
        <?php if (!empty($preload_results)): ?>
            <div class="siteefy-preload-results">
                <h2>Preload Results</h2>
                <p><strong>Preload completed at:</strong> <?php echo current_time('Y-m-d H:i:s'); ?></p>
                
                <div class="siteefy-results-summary">
                    <h3>Summary</h3>
                    <table class="form-table">
                        <tr>
                            <th>Total URLs Tested</th>
                            <td><?php echo count($preload_results); ?></td>
                        </tr>
                        <tr>
                            <th>Successful Requests</th>
                            <td><?php echo count(array_filter($preload_results, function($result) { return $result['success']; })); ?></td>
                        </tr>
                        <tr>
                            <th>Failed Requests</th>
                            <td><?php echo count(array_filter($preload_results, function($result) { return !$result['success']; })); ?></td>
                        </tr>
                        <tr>
                            <th>Average Response Time</th>
                            <td><?php 
                                $avg_time = array_sum(array_column($preload_results, 'response_time')) / count($preload_results);
                                echo round($avg_time, 3) . ' seconds';
                            ?></td>
                        </tr>
                    </table>
                </div>
                
                <div class="siteefy-results-details">
                    <h3>Detailed Results</h3>
                    <table class="wp-list-table widefat fixed striped">
                        <thead>
                            <tr>
                                <th>URL</th>
                                <th>Status</th>
                                <th>HTTP Code</th>
                                <th>Response Time</th>
                                <th>Details</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($preload_results as $result): ?>
                                <tr>
                                    <td>
                                        <code><?php echo esc_html($result['url']); ?></code>
                                    </td>
                                    <td>
                                        <?php if ($result['success']): ?>
                                            <span style="color: green;">✓ Success</span>
                                        <?php else: ?>
                                            <span style="color: red;">✗ Failed</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php echo esc_html($result['http_code']); ?>
                                    </td>
                                    <td>
                                        <?php echo esc_html(round($result['response_time'], 3)) . 's'; ?>
                                    </td>
                                    <td>
                                        <?php if ($result['success']): ?>
                                            <span style="color: green;"><?php echo esc_html($result['message']); ?></span>
                                        <?php else: ?>
                                            <span style="color: red;"><?php echo esc_html($result['message']); ?></span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        <?php else: ?>
            <!-- Debug section - only show if no results and we're on the preload page -->
            <?php if (isset($_GET['preload_completed']) && $_GET['preload_completed'] === '1'): ?>
                <div class="siteefy-debug-info">
                    <h2>Debug Information</h2>
                    <p><strong>Function exists:</strong> <?php echo function_exists('siteefy_preload_cache') ? 'Yes' : 'No'; ?></p>
                    <p><strong>Transient exists:</strong> <?php echo get_transient('siteefy_preload_results') !== false ? 'Yes' : 'No'; ?></p>
                    <p><strong>Current URL:</strong> <?php echo esc_html($_SERVER['REQUEST_URI']); ?></p>
                </div>
            <?php endif; ?>
        <?php endif; ?>
    </div>
    <?php
}

/**
 * Enhanced get_siteefy_settings function to include preload URLs
 */
function get_siteefy_settings($array_key) {
    if (Siteefy::get_env() === 'dev') {
        $use_cache = false;
    } else {
        $use_cache = true;
    }
    
    $array = array(
        'use_cache' => $use_cache,
        'preload_urls' => get_option('siteefy_preload_urls', array()),
    );
    
    if (array_key_exists($array_key, $array)) {
        return $array[$array_key];
    } else {
        throw new Exception('error - no siteefy settings set.');
    }
}

/**
 * Add admin styles
 */
function siteefy_admin_styles() {
    $screen = get_current_screen();
    if (strpos($screen->id, 'siteefy') !== false) {
        wp_enqueue_style('siteefy-admin-style', plugins_url('admin/style.css', __FILE__));
    }
}
add_action('admin_enqueue_scripts', 'siteefy_admin_styles'); 

function siteefy_get_page_content($post_id){
    $content = get_the_content($post_id);
    $separator = '<!--list-->';
    $parts = explode($separator, $content);
    
    $result = array();
    $result['above'] = isset($parts[0]) ? $parts[0] : '';
    $result['below'] = isset($parts[1]) ? $parts[1] : '';
    return $result;
}

// Add the custom button to TinyMCE
function siteefy_register_list_separator_button($buttons) {
    array_push($buttons, "siteefy_list_separator");
    return $buttons;
}
add_filter("mce_buttons", "siteefy_register_list_separator_button");

// Register the TinyMCE plugin for the button
function siteefy_add_tinymce_plugin($plugin_array) {
    $plugin_array["siteefy_list_separator"] = plugins_url('/list-separator.js', __FILE__);
    return $plugin_array;
}
add_filter("mce_external_plugins", "siteefy_add_tinymce_plugin");
