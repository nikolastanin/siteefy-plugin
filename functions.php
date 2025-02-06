<?php

function get_siteefy_header(){
    $data = ['data'=>'header_data_123'];
    require_once WP_PLUGIN_DIR . '/siteefy/templates/header.php';
}
add_action('get_siteefy_header', 'get_siteefy_header');

function get_siteefy_header_small(){
    $data = ['data'=>'header_data_123'];
    require_once WP_PLUGIN_DIR . '/siteefy/templates/header-small.php';
}
add_action('get_siteefy_header_small', 'get_siteefy_header_small');


function get_siteefy_footer(){
    $data = ['data'=>'data123'];
    require_once  WP_PLUGIN_DIR . '/siteefy/templates/footer.php';
}
add_action('get_siteefy_footer', 'get_siteefy_footer');

function get_siteefy_search(){
    $data = ['data'=>'data123'];
    require_once  WP_PLUGIN_DIR . '/siteefy/templates/search.php';
    wp_enqueue_script('siteefy_main_script');
    wp_localize_script('siteefy_main_script', 'siteefy_settings_main',array('useCache'=>0));
}
add_action('get_siteefy_search', 'get_siteefy_search');

function get_siteefy_nav(){
    wp_enqueue_script('siteefy_main_script');
    require_once  WP_PLUGIN_DIR . '/siteefy/templates/nav.php';
}
add_action('get_siteefy_nav', 'get_siteefy_nav');

function get_siteefy_home_url(){
    return get_home_url('/'). '/';
}

function siteefy_define_globals(){
  define('PLUGIN_IMAGE_URL', plugins_url( '/assets/' , __FILE__ ));
}
add_action('init', 'siteefy_define_globals');

function siteefy_register_scripts(){
    wp_register_script('siteefy_main_script', plugins_url( '/scripts/main_script.js' , __FILE__ ), ['jquery'], time());
    wp_localize_script( 'siteefy_main_script', 'my_ajax_object', array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );
    wp_enqueue_style('main-siteefy-style', plugins_url( '/stylesheets/main.css' , __FILE__ ), [], time());
    $search_term = array_key_exists('s', $_GET)?  $_GET['s']: '';
    echo('<script>let searchTermOld = "' . htmlspecialchars($search_term, ENT_QUOTES, 'UTF-8') . '";</script>');
}
add_action('wp_enqueue_scripts', 'siteefy_register_scripts');

function siteefy_add_google_fonts() {
    echo '<link rel="preconnect" href="https://fonts.googleapis.com">';
    echo '<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>';
    echo '<link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">';
    echo '<link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet">';
}
add_action('wp_head', 'siteefy_add_google_fonts');

// on page load search
function get_tools_by_search_term(){
    $search_term = $_GET['s'];
    // Normalize search term by converting to lowercase and replacing underscores, hyphens, and spaces
    $search_term_normalized = strtolower(str_replace(array(' ', '_', '-'), '', $search_term));

    // Get all tools
    $all_tools = get_posts(array(
        'post_type' => 'tool',
        'posts_per_page' => -1,
    ));

    $tasks_per_tool = array();
    $filtered_tools = array();

    // Loop through each tool and get the selected tasks
    foreach ($all_tools as $single_tool) {
        $post_id = $single_tool->ID;
        $selected_tasks_ids_for_post = get_field('tool_assigned_tasks', $post_id);

        if (!empty($selected_tasks_ids_for_post)) {
            $selected_tasks = array();
            foreach ($selected_tasks_ids_for_post as $task_id) {
                $task = get_post($task_id);
                $selected_tasks[] = $task->post_title;
            }
            // Join the selected tasks into a comma-separated string
            $tasks_per_tool[$post_id] = implode(',', $selected_tasks);
        }

        // Normalize the post title by converting to lowercase and replacing underscores, hyphens, and spaces
        $post_title_normalized = strtolower(str_replace(array(' ', '_', '-'), '', $single_tool->post_title));

        // Check if search term matches in the normalized post title
        if (str_contains($post_title_normalized, $search_term_normalized)) {
            $filtered_tools[] = $single_tool;
            continue; // If matched in title, skip other checks for this tool
        }

        // Retrieve the assigned category for the tool
        $assigned_category = get_field('tool_category', $post_id);
        $assigned_category = get_post($assigned_category);
        if ($assigned_category && !empty($assigned_category)) {
            $category_name_normalized = strtolower(str_replace([' ', '_', '-'], '', $assigned_category->post_title));

            // Check if the search term matches the category name
            if (str_contains($category_name_normalized, $search_term_normalized)) {
                $filtered_tools[] = $single_tool;
                continue;
            }
        }

        // Retrieve the assigned solution for the tool
        $assigned_solution = get_field('tool_solution', $post_id);
        // Loop through each assigned solution
        foreach ($assigned_solution as $solution) {
            $solution_post = get_post($solution);

            if ($solution_post && !empty($solution_post)) {
                $solution_name_normalized = strtolower(str_replace([' ', '_', '-'], '', $solution_post->post_title));

                // Check if the search term matches the category name
                if (str_contains($solution_name_normalized, $search_term_normalized)) {
                    $filtered_tools[] = $single_tool;
                    break; // Exit the loop as we found a match
                }
            }
        }

        // Check if search term matches in the tasks (also normalize tasks)
        if (!empty($tasks_per_tool[$post_id]) && str_contains(strtolower(str_replace(array(' ', '_', '-'), '', $tasks_per_tool[$post_id])), $search_term_normalized)) {
            $filtered_tools[] = $single_tool;
        }
    }
    return $filtered_tools;
}

function get_featured_and_non_featured_tools_from_tools_list($tools_list){
    $tools = new stdClass();

    $tools->featured_tools = array();
    $tools->non_featured_tools = array();
    if(!$tools_list){
        return $tools;
    }
    foreach ($tools_list as $tool){
        if(is_tool_featured($tool->ID)){
           $tools->featured_tools[] = $tool;
        }else{
            $tools->non_featured_tools[] = $tool;
        }
    }
    return $tools;
}

function is_tool_featured($id){
    return get_field('tool_is_featured', $id) === true;
}

function get_tools_by_task_id($task_id) {
    // Validate the task ID
    if (!is_numeric($task_id)) {
        return array('error' => 'Invalid task ID.');
    }

    // Generate a cache key to avoid querying on every request
    $cache_key = 'tools_by_task_id_' . $task_id;
    $data = get_transient($cache_key);

    if (!$data) {
        // Get all tools
        $all_tools = get_posts(array(
            'post_type' => 'tool',
            'posts_per_page' => -1,
        ));

        $filtered_tools = array();

        // Loop through each tool and check if it is assigned to the specific task ID
        foreach ($all_tools as $single_tool) {
            $post_id = $single_tool->ID;
            $assigned_tasks = get_field('tool_assigned_tasks', $post_id); // Assume this is an ACF field
            if (!empty($assigned_tasks) && in_array($task_id, $assigned_tasks)) {
                // If the task ID is found in the assigned tasks, add the tool to the filtered list
                $filtered_tools[] = $single_tool;
            }
        }

        // Store the result in a transient for future requests
        $data = $filtered_tools;
        set_transient($cache_key, $data, 1); // Cache for 1 hour
    }

    // Return the filtered tools
    return $data;
}

function get_tools_grouped_by_solution_name_by_using_task_id($task_id) {
    $tools = get_tools_by_task_id($task_id);
    $grouped_solutions = array();
    $used_tool_ids = array(); // Track tool IDs that have already been assigned to a solution

    foreach ($tools as $tool) {
        // Get the assigned solutions for the current tool
        $assigned_solutions = get_field('tool_solution', $tool->ID);

        if (is_array($assigned_solutions)) {
            foreach ($assigned_solutions as $solution_id) {
                // Skip the tool if it has already been assigned to a solution
                if (in_array($tool->ID, $used_tool_ids)) {
                    continue;
                }

                $solution_post = get_post($solution_id); // Get the full solution post object

                // Initialize the solution group if it doesn't exist
                if (!isset($grouped_solutions[$solution_id])) {
                    $grouped_solutions[$solution_id] = array(
                        'solution' => $solution_post, // Store the full solution object
                        'tools' => array(),          // Initialize an array to hold tools
                    );
                }

                // Add the tool to the current solution
                $grouped_solutions[$solution_id]['tools'][] = $tool; // Add the whole tool object
                $used_tool_ids[] = $tool->ID; // Mark the tool as used
            }
        }
    }
    return $grouped_solutions;
}



function get_tools_by_solution_id($solution_id) {
    // Validate the task ID
    if (!is_numeric($solution_id)) {
        return array('error' => 'Invalid task ID.');
    }

    // Generate a cache key to avoid querying on every request
    $cache_key = 'tools_by_task_id_' . $solution_id;
    $data = get_transient($cache_key);

    if (!$data) {
        // Get all tools
        $all_tools = get_posts(array(
            'post_type' => 'tool',
            'posts_per_page' => -1,
        ));

        $filtered_tools = array();

        // Loop through each tool and check if it is assigned to the specific task ID
        foreach ($all_tools as $single_tool) {
            $post_id = $single_tool->ID;
            $assigned_tasks = get_field('tool_solution', $post_id); // Assume this is an ACF field

            if (!empty($assigned_tasks) && in_array($solution_id, $assigned_tasks)) {
                // If the task ID is found in the assigned tasks, add the tool to the filtered list
                $filtered_tools[] = $single_tool;
            }
        }

        // Store the result in a transient for future requests
        $data = $filtered_tools;
        set_transient($cache_key, $data, 1); // Cache for 1 hour
    }

    // Return the filtered tools
    return $data;
}

function get_tools_by_category_id($category_id){
    // Get all tools
    $all_tools = get_posts(array(
        'post_type' => 'tool',
        'posts_per_page' => -1,
    ));
    $selected_tools=array();
    foreach ($all_tools as $tool){
        $selected_tool_category = get_field('tool_category', $tool->ID);
        if($selected_tool_category == $category_id){
            $selected_tools[] = $tool;
        }
    }
    return $selected_tools;
}


function get_tasks_by_category_id($category_id){
    // Get all tools
    $all_tasks = get_posts(array(
        'post_type' => 'task',
        'posts_per_page' => -1,
    ));
    $selected_tasks=array();
    foreach ($all_tasks as $task){
        $selected_tool_category = get_field('task_category', $task->ID);
        if($selected_tool_category == $category_id){
            $selected_tasks[] = $task;
        }
    }
//    var_dump($selected_tasks);
    return $selected_tasks;
}


//on ajax search
function get_tools_and_tasks_by_search_term($search_term) {
    // Normalize search term by converting to lowercase and removing underscores, hyphens, and spaces
    $search_term_normalized = strtolower(str_replace([' ', '_', '-'], '', $search_term));
    $cache_key = $search_term_normalized . '--cache';
    $data = get_transient($cache_key);

    if (!$data) {
        // Get all tools and tasks
        $all_tools = get_posts(['post_type' => 'tool', 'posts_per_page' => -1]);
        $all_tasks = get_posts(['post_type' => 'task', 'posts_per_page' => -1]);

        $tasks_per_tool = [];
        $filtered_tools = [];
        $filtered_tasks = [];

        // Filter tasks based on the search term
        foreach ($all_tasks as $task) {
            $task_title_normalized = strtolower(str_replace([' ', '_', '-'], '', $task->post_title));

            // Check if the search term matches in the normalized task title
            if (str_contains($task_title_normalized, $search_term_normalized)) {
                $filtered_tasks[] = $task;
            }
        }


        // Filter tools based on title, assigned tasks, or categories
        foreach ($all_tools as $single_tool) {
            $post_id = $single_tool->ID;
            $selected_tasks_ids_for_post = get_field('tool_assigned_tasks', $post_id);

            // Retrieve and format assigned tasks for the tool
            if (!empty($selected_tasks_ids_for_post)) {
                $selected_tasks = [];
                foreach ($selected_tasks_ids_for_post as $task_id) {
                    $task = get_post($task_id);
                    $selected_tasks[] = $task->post_title;
                }
                $tasks_per_tool[$post_id] = implode(',', $selected_tasks);
            }

            // Normalize the tool title
            $post_title_normalized = strtolower(str_replace([' ', '_', '-'], '', $single_tool->post_title));

            // Check if the search term matches the tool title
            if (str_contains($post_title_normalized, $search_term_normalized)) {
                $filtered_tools[] = $single_tool;
                continue;
            }



            // Check if the search term matches in the assigned tasks for the tool
            if (!empty($tasks_per_tool[$post_id]) && str_contains(strtolower(str_replace([' ', '_', '-'], '', $tasks_per_tool[$post_id])), $search_term_normalized)) {
                $filtered_tools[] = $single_tool;
            }

            // Retrieve the assigned solution for the tool
            $assigned_solution = get_field('tool_solution', $post_id);
            // Loop through each assigned solution
            foreach ($assigned_solution as $solution) {
                $solution_post = get_post($solution);

                if ($solution_post && !empty($solution_post)) {
                    $solution_name_normalized = strtolower(str_replace([' ', '_', '-'], '', $solution_post->post_title));

                    // Check if the search term matches the category name
                    if (str_contains($solution_name_normalized, $search_term_normalized)) {
                        $filtered_tools[] = $single_tool;
                        break; // Exit the loop as we found a match
                    }
                }
            }
        }

        // Prepare the data to cache
        $data = [

            'filtered_tools' => $filtered_tools,
            'filtered_tasks' => $filtered_tasks,
        ];

        // Cache the results for 1 hour
        set_transient($cache_key, $data, HOUR_IN_SECONDS);
    }

    return $data;
}

function get_all_tasks($count=-1){
    $args=array(
        'post_type'        => 'task',
        'numberposts'      => $count,
    );
    $tasks = get_posts($args);
    return $tasks;
}

function get_all_solutions($count=-1){
    $args=array(
        'post_type'        => 'solution',
        'numberposts'      => $count,
    );
    $solutions = get_posts($args);
    return $solutions;
}

function get_all_tools($count=-1, $sort='ASC'){
    $args=array(
        'post_type'        => 'tool',
        'numberposts'      => $count,
        'orderby'        => 'date',
        'order'          => $sort,
    );
    $tools = get_posts($args);
    return $tools;
}

function get_all_top_rated_tools($count=3){
    $count=0;
    $tools = get_all_tools(-1);
    $selected_tools = array();
    foreach ($tools as $tool){
        if($count===3){
            break;
        }
        $rating = get_field('tool_rating', $tool->ID);
        if($rating>4.3){
            $selected_tools[] = $tool;
            $count++;
        }
    }
    if(is_array($selected_tools) && count($selected_tools)<3){
        return get_all_tools(3);;
    }
    return $selected_tools;
}

function get_count_of_tools_for_single_task($task_id_passed){
    // Get all tools
    $all_tools = get_posts(array(
        'post_type' => 'tool',
        'posts_per_page' => -1,
    ));
    $count = 0;
    // Loop through each tool and get the selected tasks
    foreach ($all_tools as $single_tool) {
        $post_id = $single_tool->ID;
        $selected_tasks_ids_for_post = get_field('tool_assigned_tasks', $post_id);
        if (!empty($selected_tasks_ids_for_post)) {
            foreach ($selected_tasks_ids_for_post as $task_id) {
                if($task_id == $task_id_passed){
                    $count++;
                }
            }
        }
    }
    return $count;
}

function get_count_of_tools_for_single_solution($solution_id_passed){
    // Get all tools
    $all_tools = get_posts(array(
        'post_type' => 'tool',
        'posts_per_page' => -1,
    ));
    $count = 0;
    // Loop through each tool and get the selected tasks
    foreach ($all_tools as $single_tool) {
        $post_id = $single_tool->ID;
        $selected_solutions_ids_for_post = get_field('tool_solution', $post_id);
        if (!empty($selected_solutions_ids_for_post)) {
            foreach ($selected_solutions_ids_for_post as $solution_id) {
                if($solution_id == $solution_id_passed){
                    $count++;
                }
            }
        }
    }
    return $count;
}

function get_count_of_tools_for_single_category($category_id){
    // Get all tools
    $all_tools = get_posts(array(
        'post_type' => 'tool',
        'posts_per_page' => -1,
    ));
    $count=0;
    foreach ($all_tools as $tool){
        $selected_tool_category = get_field('tool_category', $tool->ID);
        if($selected_tool_category == $category_id){
            $count++;
        }
    }
    return $count;
}

function disable_attachment_pages() {
    if (is_attachment()) {
        global $post;
        if ($post && strpos($post->post_mime_type, 'image/') === 0) {
            wp_redirect(get_permalink($post->post_parent), 301);
            exit;
        }
    }
}
add_action('template_redirect', 'disable_attachment_pages');


function siteefy_get_search_value(){
    $search_value = isset($_GET['s']) ? $_GET['s'] : '';
    echo $search_value;
}

function get_solution_name_by_tool_id($tool_id){
    $solution_id = get_field('tool_solution', $tool_id);
    $solution = get_post($solution_id[0]);
    if($solution){
        return $solution->post_title;
    }
}