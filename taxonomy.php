<?php

function register_task_category_taxonomy() {
//    register_taxonomy('test', array('task', 'tool'), array( // Changed from 'category' to 'task_category'
//        'label'             => __('Categories', 'textdomain'),
//        'rewrite'           => array('slug' => 'test'), // Custom slug
//        'hierarchical'      => false,
//        'show_admin_column' => true,
//        'show_ui'          => true,
//        'public'           => true,
//    ));
    register_taxonomy('solution', array('task', 'tool'), array(
        'label'             => __('Solutions', 'textdomain'),
        'rewrite'           => array('slug' => 'solution'), // Uncommented
        'hierarchical'      => false,
        'show_admin_column' => true,
        'show_ui'           => true,
        'public'            => true,
    ));
    flush_rewrite_rules();

}
add_action('init', 'register_task_category_taxonomy');