<?php
function get_task_assigned_category($task){
    $category_id = get_field('task_category', $task->ID);
    echo get_post($category_id)->post_title ?? '';
}

//cat-fixed
function get_all_categories($limit=5) {
    if($limit===-1){
        $limit=0;
    }
    // Get all terms from the 'task_category' taxonomy
    $terms = get_terms(array(
        'taxonomy'   => 'category', // Replace with your taxonomy name
        'hide_empty' => false, // Include terms even if they have no posts
        'number'     => $limit, // Limit the number of terms returned
    ));
    if (!is_wp_error($terms) && !empty($terms)) {
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