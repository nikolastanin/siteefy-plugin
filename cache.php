<?php

/**
 * Siteefy Cache Management System
 * 
 * This file contains all cache-related functions for the Siteefy plugin,
 * including Object Cache Pro integration, WP Rocket integration, and cache preloading.
 */

/**
 * Helper function to get cache with Object Cache Pro support
 */
function siteefy_get_cache($key) {
    // Check if Object Cache Pro is active
    if (function_exists('wp_cache_get')) {
        return wp_cache_get($key, 'siteefy');
    }
    
    // Fallback to transients
    return get_transient($key);
}

/**
 * Helper function to set cache with Object Cache Pro support
 */
function siteefy_set_cache($key, $data, $expiration = 86400) {
    // Check if Object Cache Pro is active
    if (function_exists('wp_cache_set')) {
        return wp_cache_set($key, $data, 'siteefy', $expiration);
    }
    
    // Fallback to transients
    return set_transient($key, $data, $expiration);
}

/**
 * Helper function to delete cache with Object Cache Pro support
 */
function siteefy_delete_cache($key) {
    // Check if Object Cache Pro is active
    if (function_exists('wp_cache_delete')) {
        return wp_cache_delete($key, 'siteefy');
    }
    
    // Fallback to transients
    return delete_transient($key);
}

/**
 * Helper function to flush all Siteefy cache from Object Cache Pro
 */
function siteefy_flush_cache_group() {
    // Check if Object Cache Pro is active and supports group flushing
    if (function_exists('wp_cache_flush_group')) {
        return wp_cache_flush_group('siteefy');
    }
    
    // Alternative method for Object Cache Pro
    if (function_exists('wp_cache_flush_runtime')) {
        return wp_cache_flush_runtime();
    }
    
    return false;
}

/**
 * Preload important URLs after cache purge
 */
function siteefy_preload_cache() {
    // List of important URLs to preload
    $urls_to_preload = [
        home_url('/'), // Homepage
        home_url('/?s='), // Search page
        home_url('/tools/'), // Tool archive
        home_url('/tasks/'), // Task archive
        home_url('/solutions/'), // Solution archive
        home_url('/categories/'), // Category archive
    ];
    
    // Get recent tools and tasks for preloading
    $recent_tools = get_all_tools(5, 'DESC');
    $recent_tasks = get_all_tasks(5, 'DESC');
    
    // Add recent tool single pages
    foreach ($recent_tools as $tool) {
        $urls_to_preload[] = get_permalink($tool->ID);
    }
    
    // Add recent task single pages
    foreach ($recent_tasks as $task) {
        $urls_to_preload[] = get_permalink($task->ID);
    }
    
    // Get popular solutions and categories
    $solutions = get_all_solutions(10);
    $categories = get_all_categories(10);
    
    // Add solution archive pages
    foreach ($solutions as $solution) {
        $urls_to_preload[] = get_term_link($solution);
    }
    
    // Add category archive pages
    foreach ($categories as $category) {
        $urls_to_preload[] = get_term_link($category);
    }
    
    // Preload URLs using wp_remote_get
    foreach ($urls_to_preload as $url) {
        if (is_string($url) && !is_wp_error($url)) {
            wp_remote_get($url, [
                'timeout' => 5,
                'blocking' => false, // Non-blocking requests
                'user-agent' => 'Siteefy Cache Preloader'
            ]);
        }
    }
    
    // Also preload WP Rocket cache if available
    if (function_exists('rocket_preload_domain')) {
        rocket_preload_domain();
    }
}

/**
 * Preload cache for specific post after it's updated
 */
function siteefy_preload_post_cache($post_id, $post = null) {
    if (!$post || !in_array($post->post_type, ['tool', 'task'])) {
        return;
    }
    
    $urls_to_preload = [
        get_permalink($post_id), // The post itself
        home_url('/'), // Homepage (might show this post)
    ];
    
    // If it's a tool, also preload related task pages
    if ($post->post_type === 'tool') {
        $assigned_tasks = get_tasks_for_tool_from_its_solution($post_id);
        foreach ($assigned_tasks as $task_id) {
            $urls_to_preload[] = get_permalink($task_id);
        }
    }
    
    // If it's a task, also preload related tool pages
    if ($post->post_type === 'task') {
        $tools = get_tools_by_task_id($post_id);
        foreach ($tools as $tool) {
            $urls_to_preload[] = get_permalink($tool->ID);
        }
    }
    
    // Preload URLs
    foreach ($urls_to_preload as $url) {
        if (is_string($url) && !is_wp_error($url)) {
            wp_remote_get($url, [
                'timeout' => 5,
                'blocking' => false,
                'user-agent' => 'Siteefy Post Cache Preloader'
            ]);
        }
    }
}

/**
 * Preload cache for specific term after it's updated
 */
function siteefy_preload_term_cache($term_id, $tt_id, $taxonomy) {
    if (!in_array($taxonomy, ['solution', 'category'])) {
        return;
    }
    
    $term = get_term($term_id, $taxonomy);
    if (!$term || is_wp_error($term)) {
        return;
    }
    
    $urls_to_preload = [
        get_term_link($term), // The term archive page
        home_url('/'), // Homepage
    ];
    
    // If it's a solution, preload related tool pages
    if ($taxonomy === 'solution') {
        $tools = get_cpt_posts_by_tax('tool', $taxonomy, $term_id, 10);
        foreach ($tools as $tool) {
            $urls_to_preload[] = get_permalink($tool->ID);
        }
    }
    
    // If it's a category, preload related tool pages
    if ($taxonomy === 'category') {
        $tools = get_cpt_posts_by_tax('tool', $taxonomy, $term_id, 10);
        foreach ($tools as $tool) {
            $urls_to_preload[] = get_permalink($tool->ID);
        }
    }
    
    // Preload URLs
    foreach ($urls_to_preload as $url) {
        if (is_string($url) && !is_wp_error($url)) {
            wp_remote_get($url, [
                'timeout' => 5,
                'blocking' => false,
                'user-agent' => 'Siteefy Term Cache Preloader'
            ]);
        }
    }
}

/**
 * Enhanced cache purge function with preloading
 */
function siteefy_purge_cache($post_id = null, $post = null, $update = null) {
    // Only proceed if this is a relevant post type
    if ($post && !in_array($post->post_type, ['tool', 'task'])) {
        return;
    }
    
    // First, try to flush the entire Siteefy cache group from Object Cache Pro
    if (siteefy_flush_cache_group()) {
        // If successful, we don't need to manually delete individual keys
    } else {
        // Fallback: Delete all cached transients that start with 'siteefy_'
        global $wpdb;
        
        // Get all transients that start with 'siteefy_'
        $transients = $wpdb->get_col(
            $wpdb->prepare(
                "SELECT option_name FROM {$wpdb->options} WHERE option_name LIKE %s",
                '_transient_siteefy_%'
            )
        );
        
        // Delete each transient
        foreach ($transients as $transient) {
            $transient_name = str_replace('_transient_', '', $transient);
            delete_transient($transient_name);
        }
        
        // Also purge search cache
        $search_transients = $wpdb->get_col(
            $wpdb->prepare(
                "SELECT option_name FROM {$wpdb->options} WHERE option_name LIKE %s",
                '_transient_--cache'
            )
        );
        
        foreach ($search_transients as $transient) {
            $transient_name = str_replace('_transient_', '', $transient);
            delete_transient($transient_name);
        }
        
        // Purge tools by task ID cache
        $task_tools_transients = $wpdb->get_col(
            $wpdb->prepare(
                "SELECT option_name FROM {$wpdb->options} WHERE option_name LIKE %s",
                '_transient_tools_by_task_id_%'
            )
        );
        
        foreach ($task_tools_transients as $transient) {
            $transient_name = str_replace('_transient_', '', $transient);
            delete_transient($transient_name);
        }
        
        // Purge search tools cache (get_tools_by_search_term)
        $search_tools_transients = $wpdb->get_col(
            $wpdb->prepare(
                "SELECT option_name FROM {$wpdb->options} WHERE option_name LIKE %s",
                '_transient_siteefy_search_tools_%'
            )
        );
        
        foreach ($search_tools_transients as $transient) {
            $transient_name = str_replace('_transient_', '', $transient);
            delete_transient($transient_name);
        }
        
        // Purge tools and tasks search cache (get_tools_and_tasks_by_search_term)
        $tools_tasks_search_transients = $wpdb->get_col(
            $wpdb->prepare(
                "SELECT option_name FROM {$wpdb->options} WHERE option_name LIKE %s",
                '_transient_siteefy_tools_tasks_search_%'
            )
        );
        
        foreach ($tools_tasks_search_transients as $transient) {
            $transient_name = str_replace('_transient_', '', $transient);
            delete_transient($transient_name);
        }
    }
    
    // Purge WP Rocket cache if the plugin is active
    if (function_exists('rocket_clean_domain')) {
        rocket_clean_domain();
    }
    
    // Also purge WP Rocket cache for specific URLs if we have a post ID
    if ($post_id && function_exists('rocket_clean_post')) {
        rocket_clean_post($post_id);
    }
    
    // Purge WP Rocket cache for related URLs (homepage, search pages, etc.)
    if (function_exists('rocket_clean_files')) {
        // Get the home URL and search URL to purge
        $home_url = home_url('/');
        $search_url = home_url('/?s=');
        
        // Purge homepage cache
        rocket_clean_files($home_url);
        
        // Purge search page cache (this will clear all search results)
        rocket_clean_files($search_url);
        
        // If we have a specific post, also purge its related pages
        if ($post_id) {
            $post_url = get_permalink($post_id);
            if ($post_url) {
                rocket_clean_files($post_url);
            }
        }
    }
    
    // Preload cache after purging (with a small delay to ensure purge is complete)
    wp_schedule_single_event(time() + 5, 'siteefy_preload_cache_after_purge', [$post_id, $post]);
}

/**
 * Purge cache when terms are created/updated/deleted
 */
function siteefy_purge_cache_on_term_change($term_id, $tt_id, $taxonomy) {
    // Only proceed if this is a relevant taxonomy
    if (!in_array($taxonomy, ['solution', 'category'])) {
        return;
    }
    
    siteefy_purge_cache();
}

/**
 * Manual cache purge function with preloading
 */
function siteefy_manual_purge_cache() {
    siteefy_purge_cache();
    
    // Additional Object Cache Pro cache clearing for manual purge
    if (siteefy_flush_cache_group()) {
        // Successfully flushed Object Cache Pro cache
    }
    
    // Additional WP Rocket cache clearing for manual purge
    if (function_exists('rocket_clean_domain')) {
        rocket_clean_domain();
    }
    
    // Clear all WP Rocket cache files
    if (function_exists('rocket_clean_files')) {
        // Clear homepage
        rocket_clean_files(home_url('/'));
        
        // Clear search pages
        rocket_clean_files(home_url('/?s='));
        
        // Clear archive pages for tools and tasks
        rocket_clean_files(home_url('/tools/'));
        rocket_clean_files(home_url('/tasks/'));
        
        // Clear solution and category archive pages
        rocket_clean_files(home_url('/solutions/'));
        rocket_clean_files(home_url('/categories/'));
    }
    
    // Preload cache after manual purge
    wp_schedule_single_event(time() + 5, 'siteefy_preload_cache_after_purge');
    
    return true;
}

/**
 * Manual cache preload function (can be called from admin)
 */
function siteefy_manual_preload_cache() {
    // Preload all important URLs
    siteefy_preload_cache();
    
    // Also trigger WP Rocket preload if available
    if (function_exists('rocket_preload_domain')) {
        rocket_preload_domain();
    }
    
    return true;
}

/**
 * Get cache preload status and statistics
 */
function siteefy_get_cache_preload_status() {
    $status = [
        'object_cache_pro' => function_exists('wp_cache_get'),
        'wp_rocket' => function_exists('rocket_clean_domain'),
        'cache_enabled' => get_siteefy_settings('use_cache'),
        'recent_tools_count' => count(get_all_tools(5, 'DESC')),
        'recent_tasks_count' => count(get_all_tasks(5, 'DESC')),
        'solutions_count' => count(get_all_solutions(10)),
        'categories_count' => count(get_all_categories(10)),
    ];
    
    return $status;
}

// Hook for scheduled preloading
add_action('siteefy_preload_cache_after_purge', 'siteefy_preload_cache');
add_action('siteefy_preload_cache_after_purge', 'siteefy_preload_post_cache', 10, 2);

// Hook into WordPress actions to purge cache and preload
add_action('save_post', 'siteefy_purge_cache', 10, 3);
add_action('delete_post', 'siteefy_purge_cache', 10, 1);
add_action('wp_trash_post', 'siteefy_purge_cache', 10, 1);
add_action('create_term', 'siteefy_purge_cache_on_term_change', 10, 3);
add_action('edit_term', 'siteefy_purge_cache_on_term_change', 10, 3);
add_action('delete_term', 'siteefy_purge_cache_on_term_change', 10, 3);

// Hook for term-specific preloading
add_action('create_term', 'siteefy_preload_term_cache', 20, 3);
add_action('edit_term', 'siteefy_preload_term_cache', 20, 3); 