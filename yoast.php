<?php


// define the action for register yoast_variable replacments
function register_custom_yoast_variables() {
    wpseo_register_var_replacement( '%%count%%', 'get_count_of_items_for_yoast', 'advanced', 'Get count of items for tools, tasks, solutions, etc.' );
    wpseo_register_var_replacement( '%%countminus%%', 'get_count_of_items_for_yoast_minus_one', 'advanced', 'Get count of items for tools, tasks, solutions, etc.' );

}

// Add action
add_action('wpseo_register_extra_replacements', 'register_custom_yoast_variables', 1);



add_filter('wpseo_title', function($title) {
    $title = str_replace('{{count}}', get_count_of_items_for_yoast(), $title);
    $title = str_replace('{{countminus}}', get_count_of_items_for_yoast_minus_one(), $title);
    return $title;
});

add_filter('wpseo_metadesc', function($desc) {
    $desc = str_replace('{{count}}', get_count_of_items_for_yoast(), $desc);
    $desc = str_replace('{{countminus}}', get_count_of_items_for_yoast_minus_one(), $desc);
    return $desc;
});


function get_count_of_items_for_yoast_minus_one() {
    $count = get_count_of_items_for_yoast();
    return $count - 1;
}

function get_count_of_items_for_yoast() {
    // Check for cached count
    $cache_key = 'siteefy_count_items_' . md5(serialize($_SERVER['REQUEST_URI']));
    $cached_count = siteefy_get_cache($cache_key);
    
    if ($cached_count !== false) {
        return $cached_count;
    }
    global $post;

    // Search page
    if (is_search()) {
        $tools = get_tools_by_search_term();
        return count($tools);
    }
    // Single task page
    elseif (is_single() && get_post_type($post) === 'task') {
        $tools = get_tools_by_task_id($post->ID);
        return count($tools);
    }
    // Task archive (not solution)
    elseif (is_archive() && get_post_type($post) === 'task' && get_queried_object()->taxonomy !== 'solution') {
        $tasks = get_all_tasks();
        return count($tasks);
    }
    // Solution archive
    elseif (is_archive() && get_queried_object()->taxonomy === 'solution') {
        $term = get_queried_object();
        $tools = get_cpt_posts_by_tax('tool', $term->taxonomy, $term->term_id);
        return count($tools);
    }
    // Solution page
    elseif (is_page() && strtolower(get_the_title()) === SOLUTION_PAGE_SLUG) {
        $tools = get_all_tools();
        return count($tools);
    }
    // Category page (tasks page)
    elseif (is_page() && strtolower(get_the_title()) === CATEGORY_PAGE_SLUG) {
        $counted = get_all_categories(-1);
        return count($counted);
    }
    // Category archive
    elseif (is_archive() && get_queried_object()->taxonomy === 'category') {
        $term = get_queried_object();
        $tools = get_cpt_posts_by_tax('tool', $term->taxonomy, $term->term_id);
        return count($tools);
    }
    // Tool archive
    elseif (is_archive() && get_post_type($post) === 'tool') {
        $tools = get_all_tools();
        return count($tools);
    }
    // Front page
    elseif (is_front_page()) {
        $tools = get_all_tools();
        return count($tools);
    }
    // Default fallback
    else {
        return 0;
    }
}
