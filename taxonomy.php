<?php

return;
function register_task_category_taxonomy() {
    register_taxonomy('category', array('task', 'tool'), array(
        'label'             => __('Categories', 'textdomain'),
        'rewrite'           => array('slug' => 'category'), // Enable pretty URLs
        'hierarchical'      => true, // Like post categories (true) or tags (false)
        'show_admin_column' => true,
        'show_ui'           => true,
        'public'            => true,
    ));
    register_taxonomy('solution', array('task', 'tool'), array(
        'label'             => __('Solutions', 'textdomain'),
        'rewrite'           => array('slug' => 'solution'), // Enable pretty URLs
        'hierarchical'      => true, // Like post categories (true) or tags (false)
        'show_admin_column' => true,
        'show_ui'           => true,
        'public'            => true,
    ));
}
add_action('init', 'register_task_category_taxonomy');