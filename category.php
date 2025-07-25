<?php
function get_task_assigned_category_name($task){
    $category_id = get_category_for_task($task->ID);
    echo get_term($category_id)->name ?? '';
}

//cat-fixed
function get_all_categories($limit = 5, $exclude_term = '', $order='DESC') {
    if ($limit === -1) {
        $limit = 0;
    }

    // Get all terms from the 'category' taxonomy
    $terms = get_terms(array(
        'taxonomy'   => 'category',
        'hide_empty' => true,
        'number'     => $limit,
        'orderby'    => 'id',
        'order'      => 'DESC', // Newest first
    ));

    if (!is_wp_error($terms) && !empty($terms)) {
        if (!empty($exclude_term)) {
            $terms = array_filter($terms, function ($term) use ($exclude_term) {
                return $term->slug !== $exclude_term;
            });

            // Reset array keys
            $terms = array_values($terms);
        }
        return $terms;
    }

    return array();
}


function get_count_of_tools_for_single_category($category_id) {
    $query = new WP_Query(array(
        'post_type'      => array('tool', 'task'),  // CPT name
        'posts_per_page' => -1,      // Get all posts
        'fields'         => 'ids',   // Only fetch post IDs (improves performance)
        'tax_query'      => array(
            array(
                'taxonomy' => 'category', // Change this to your actual taxonomy
                'field'    => 'term_id',      // Match by term ID
                'terms'    => $category_id,   // Category to check
            ),
        ),
    ));

    return $query->found_posts; // Return the count of matching posts
}

function get_category_for_task($task_id){
    $terms = wp_get_post_terms($task_id, 'category', array('fields' => 'ids'));

    if (!is_wp_error($terms) && is_array($terms)) {
        return $terms[0]; // Returns an array of term IDs
    }

    return array(); // Return an empty array if no terms are found
}

function get_category_for_tool($tool_id) {
    if (!$tool_id) {
        return array();
    }

    $terms = wp_get_post_terms($tool_id, 'category', array('fields' => 'ids'));

    if (!is_wp_error($terms) && is_array($terms) && !empty($terms)) {
        return $terms[0]; // Returns the first category ID
    }

    return array(); // Return an empty array if no terms are found
}
