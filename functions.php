<?php

function get_siteefy_header(){
    $tasks = get_all_tasks(5);
    $solutions = get_all_solutions(5);
    $solutions_collection = array();
    $tools_collection = array();
    $listing_limit = 6;

    foreach ($tasks as $task){
        $task_id = $task->ID;
        $tools_by_task_id = get_tools_by_task_id($task_id);
        $tools_collection[$task_id] = array_slice($tools_by_task_id, 0, $listing_limit);
    }

    foreach ($solutions as $solution){
        $solution_id = $solution->term_id;
        $tools_by_solution_id = get_tools_by_solution_id($solution_id);
        $solutions_collection[$solution_id] = array_slice($tools_by_solution_id, 0, $listing_limit);
    }

    echo Siteefy::blade()->run('header', [
        'tasks' => $tasks,
        'solutions'=>$solutions,
        'tools_collection_by_tasks' =>$tools_collection,
        'tools_collection_by_solutions' =>$solutions_collection,
        'recent_tools' => get_all_tools(3, 'DESC'),
    ]);
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

/**
 * @throws Exception
 */
function get_siteefy_search(){
    $data = ['data'=>'data123'];
    require_once  WP_PLUGIN_DIR . '/siteefy/templates/search.php';
}
add_action('get_siteefy_search', 'get_siteefy_search');

function get_siteefy_nav(){
    wp_enqueue_script('siteefy_main_script');
    require_once  WP_PLUGIN_DIR . '/siteefy/templates/nav.php';
}
add_action('get_siteefy_nav', 'get_siteefy_nav');

function get_siteefy_home_url($page=''){
    return get_home_url('/'). $page. '/';
}

function siteefy_define_globals(){
  define('PLUGIN_IMAGE_URL', plugins_url( '/assets/' , __FILE__ ));
}
add_action('init', 'siteefy_define_globals');

function siteefy_register_scripts(){
    $version_of_plugin = Siteefy::get_plugin_version();
    wp_register_script('siteefy_main_script', plugins_url( '/scripts/main_script.js' , __FILE__ ), ['jquery'], $version_of_plugin );
    wp_localize_script( 'siteefy_main_script', 'my_ajax_object', array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );

    //search scripts
    $use_cache = get_siteefy_settings('use_cache');
    wp_enqueue_script('siteefy_main_script');
    wp_localize_script('siteefy_main_script', 'siteefy_settings_main',array('useCache'=>$use_cache));

    wp_register_style('main-siteefy-style-new', plugins_url( '/stylesheets_new/main.css' , __FILE__ ), [], $version_of_plugin);
    wp_register_style('main-siteefy-nav-override', plugins_url( '/stylesheets_new/nav-override.css' , __FILE__ ), [], $version_of_plugin);
    wp_register_style('main-siteefy-reusable', plugins_url( '/stylesheets_new/reusable.css' , __FILE__ ), [], $version_of_plugin);
    $search_term = array_key_exists('s', $_GET)?  $_GET['s']: '';
    echo('<script>let searchTermOld = "' . htmlspecialchars($search_term, ENT_QUOTES, 'UTF-8') . '";</script>');
}
add_action('wp_enqueue_scripts', 'siteefy_register_scripts');

function remove_customizer_custom_css() {
    if(check_if_is_siteefy_new_pages()===true){
        add_filter('wp_get_custom_css', '__return_empty_string');
    }
}
add_action('wp', 'remove_customizer_custom_css');

function check_if_is_siteefy_new_pages(){
    global $post;
    if (
        is_search() ||
        (is_single() && get_post_type($post) === 'task') ||
        (is_archive() && get_post_type($post) === 'task' && get_queried_object()->taxonomy !== 'solution') ||
        (is_archive() && get_queried_object()->taxonomy === 'solution') ||
        (is_page() && strtolower(get_the_title()) === SOLUTION_PAGE_SLUG) ||
        (is_page() && strtolower(get_the_title()) === CATEGORY_PAGE_SLUG) ||
        (is_archive() && get_queried_object()->taxonomy === 'category') ||
        (is_archive() && get_post_type($post) === 'tool') ||
        (is_front_page())
    ) {
      return true;
    }else{
        return false;
    }
}

function dequeue_generatepress_styles() {
    global $post;
    if (check_if_is_siteefy_new_pages()) {
        // Remove GeneratePress core styles
        wp_dequeue_style('generate-style');
        wp_deregister_style('generate-style');

        // Remove parent theme stylesheet
        wp_dequeue_style('generatepress');
        wp_deregister_style('generatepress');

        // Remove child theme stylesheet (if needed)
        wp_dequeue_style('generatepress-child');
        wp_deregister_style('generatepress-child');
    }else{
        //this is styles that are new, but used on old pages(componenet from homepage, used on ai-tools/tool-xyz
        wp_enqueue_style('main-siteefy-reusable');
        wp_enqueue_style('main-siteefy-nav-override');
    }
}
add_action('wp_enqueue_scripts', 'dequeue_generatepress_styles', 20);

function siteefy_add_google_fonts() {
    echo '<link rel="preconnect" href="https://fonts.googleapis.com">';
    echo '<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>';
    echo '<link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">';
    echo '<link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet">';
}
add_action('wp_head', 'siteefy_add_google_fonts');

function siteefy_get_search_value(){
    $search_value = isset($_GET['s']) ? $_GET['s'] : '';
    echo $search_value;
}

// on page load search
function get_tools_by_search_term(){
    $search_term = array_key_exists('s',$_GET) ? $_GET['s'] : '';
    // Normalize search term by converting to lowercase and replacing underscores, hyphens, and spaces
    $search_term_normalized = strtolower(str_replace(array(' ', '_', '-'), '', $search_term));

    // If search term is empty after normalization, return empty array
    if (empty($search_term_normalized)) {
        return array();
    }

    // Create cache key based on normalized search term
    $cache_key = 'siteefy_search_tools_' . $search_term_normalized;
    
    // Check if caching is enabled
    $use_cache = get_siteefy_settings('use_cache');
    if ($use_cache) {
        $data = siteefy_get_cache($cache_key);
        if ($data !== false) {
            return $data;
        }
    }

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
        $selected_tasks_ids_for_post = get_tasks_for_tool_from_its_solution($post_id);

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
        if (strpos($post_title_normalized, $search_term_normalized) !== false) {
            $filtered_tools[] = $single_tool;
            continue; // If matched in title, skip other checks for this tool
        }

        // Retrieve the assigned category for the tool
        //        todo:check if it works.....!!!!
        $assigned_category = get_category_for_tool($post_id);
        $assigned_category = get_term($assigned_category);
        if ($assigned_category && !empty($assigned_category) && !is_wp_error($assigned_category)) {
            $category_name_normalized = strtolower(str_replace([' ', '_', '-'], '', $assigned_category->name));

            // Check if the search term matches the category name
            if (strpos($category_name_normalized, $search_term_normalized) !== false) {
                $filtered_tools[] = $single_tool;
                continue;
            }
        }

        // Retrieve the assigned solution for the tool
//        todo:get term id by post id by tax = solution
        $assigned_solution = get_solutions_for_tool($post_id);
        // Loop through each assigned solution
        foreach ($assigned_solution as $solution) {
            $solution_post = get_term($solution);

            if ($solution_post && !empty($solution_post)) {
                $solution_name_normalized = strtolower(str_replace([' ', '_', '-'], '', $solution_post->name));

                // Check if the search term matches the solution name
                if (strpos($solution_name_normalized, $search_term_normalized) !== false) {
                    $filtered_tools[] = $single_tool;
                    break; // Exit the loop as we found a match
                }
            }
        }
        // Check if search term matches in the tasks (also normalize tasks)
        if (!empty($tasks_per_tool[$post_id]) && strpos(strtolower(str_replace([' ', '_', '-'], '', $tasks_per_tool[$post_id])), $search_term_normalized) !== false) {
            //        todo: this causes duplicated tools so i commented it out, but maybe it needs to be here?
            //            $filtered_tools[] = $single_tool;
        }
    }
    
    // Cache the results for 24 hours if caching is enabled
    if ($use_cache) {
        siteefy_set_cache($cache_key, $filtered_tools, 86400);
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

function get_tool_description($post_id) {
    $excerpt = get_field('tool_description', $post_id) ?: get_the_excerpt($post_id);

    // If no excerpt, get the post content
    if (!$excerpt) {
        $excerpt = get_post_field('post_content', $post_id);
    }

    // Trim to 95 characters and add "..." if necessary
    return mb_strimwidth(trim(strip_tags($excerpt)), 0, 95, strlen($excerpt) > 95 ? "..." : "");
}

function get_tools_by_task_id($task_id) {
    // Validate the task ID
    if (!is_numeric($task_id)) {
        return array('error' => 'Invalid task ID.');
    }

    // Generate a cache key to avoid querying on every request
    $cache_key = 'tools_by_task_id_' . $task_id;
    $data = siteefy_get_cache($cache_key);

    if (!$data) {
        // Use direct SQL query for better performance with large datasets
        global $wpdb;
        
        $query = $wpdb->prepare("
            SELECT DISTINCT p.* 
            FROM {$wpdb->posts} p
            INNER JOIN {$wpdb->postmeta} pm ON p.ID = pm.post_id
            WHERE p.post_type = 'tool' 
            AND p.post_status = 'publish'
            AND pm.meta_key = 'tool_tasks'
            AND pm.meta_value LIKE %s
            ORDER BY p.post_date DESC
        ", '%' . $wpdb->esc_like($task_id) . '%');
        
        $filtered_tools = $wpdb->get_results($query);

        // Store the result in cache
        $data = $filtered_tools;
        siteefy_set_cache($cache_key, $data, 3600); // Cache for 1 hour
    }

    // Return the filtered tools
    return $data;
}

function get_cpt_posts_by_tax($cpt='',$tax, $category_id, $limit=-1){
    $query = new WP_Query(array(
        'post_type'      => $cpt,
        'posts_per_page' => $limit,
        'tax_query'      => array(
            array(
                'taxonomy' => $tax,
                'field'    => 'term_id',
                'terms'    => (int) $category_id,
            ),
        ),
    ));
    return $query->posts; // Return array of post objects
}

//on ajax search
function get_tools_and_tasks_by_search_term($search_term) {
    // Normalize search term by converting to lowercase and removing underscores, hyphens, and spaces
    $search_term_normalized = strtolower(str_replace([' ', '_', '-'], '', $search_term));
    
    // If search term is empty after normalization, return empty results
    if (empty($search_term_normalized)) {
        return [
            'filtered_tools' => [],
            'filtered_tasks' => [],
        ];
    }
    
    // Create cache key based on normalized search term
    $cache_key = 'siteefy_tools_tasks_search_' . $search_term_normalized;
    
    // Check if caching is enabled
    $use_cache = get_siteefy_settings('use_cache');
    if ($use_cache) {
        $data = siteefy_get_cache($cache_key);
        if ($data !== false) {
            return $data;
        }
    }
    
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
        if (strpos($task_title_normalized, $search_term_normalized) !== false) {
            $filtered_tasks[] = $task;
        }
    }

    // Filter tools based on title, assigned tasks, or categories
    foreach ($all_tools as $single_tool) {
        $post_id = $single_tool->ID;
        $selected_tasks_ids_for_post = get_tasks_for_tool_from_its_solution($post_id);
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
        if (strpos($post_title_normalized, $search_term_normalized) !== false) {
            $filtered_tools[] = $single_tool;
            continue;
        }

//        todo: this causes duplicated tools so i commented it out, but maybe it needs to be here?
        // Check if the search term matches in the assigned tasks for the tool
        if (!empty($tasks_per_tool[$post_id]) && strpos(strtolower(str_replace([' ', '_', '-'], '', $tasks_per_tool[$post_id])), $search_term_normalized) !== false) {
//            $filtered_tools[] = $single_tool;
        }

        // Retrieve the assigned solution for the tool
        //        todo:get term id by post id by tax = solution
        $assigned_solution = get_solutions_for_tool($post_id);
        // Loop through each assigned solution
        foreach ($assigned_solution as $solution) {
            $solution_post = get_term($solution);
//            var_dump($solution_post->name);
            if ($solution_post && !empty($solution_post)) {
                $solution_name_normalized = strtolower(str_replace([' ', '_', '-'], '', $solution_post->name));

                // Check if the search term matches the category name
                if (strpos($solution_name_normalized, $search_term_normalized) !== false) {
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

    // Cache the results for 24 hours if caching is enabled
    if ($use_cache) {
        siteefy_set_cache($cache_key, $data, 86400);
    }

    return $data;
}

function get_all_tasks($count = -1, $exclude_slug = '') {
    // Create cache key based on parameters - use 'all' for -1 to make it more readable
    $count_key = ($count === -1) ? 'all' : $count;
    $cache_key = 'siteefy_all_tasks_' . $count_key . '_' . $exclude_slug;
    
    // Check if caching is enabled
    $use_cache = get_siteefy_settings('use_cache');
    if ($use_cache) {
        $data = siteefy_get_cache($cache_key);
        if ($data !== false) {
            var_dump('cached!');
            siteefy_debug_cache_status('get_all_tasks', $cache_key, $use_cache, true);
            return $data;
        }
    }
    
    siteefy_debug_cache_status('get_all_tasks', $cache_key, $use_cache, false);
    
    $args = array(
        'post_type'      => 'task',
        'numberposts'    => $count,
        'post_status'    => 'publish',
        'no_found_rows'  => true,
        'update_post_meta_cache' => false,
        'update_post_term_cache' => false,
        'orderby'        => 'date',
        'order'          => 'DESC',
    );
    
    // Only add exclude if we have a valid slug
    if (!empty($exclude_slug)) {
        $exclude_post = get_page_by_path($exclude_slug, OBJECT, 'task');
        if ($exclude_post) {
            $args['exclude'] = $exclude_post->ID;
        }
    }
    
    // Apply optimization filter
    $args = apply_filters('siteefy_get_posts_args', $args, 'task');

    $tasks = get_posts($args);
    
    // Cache the results for 24 hours if caching is enabled
    if ($use_cache) {
        siteefy_set_cache($cache_key, $tasks, 86400);
    }
    
    return $tasks;
}

function get_all_tools($count=-1, $sort='ASC'){
    // Create cache key based on parameters - use 'all' for -1 to make it more readable
    $count_key = ($count === -1) ? 'all' : $count;
    $cache_key = 'siteefy_all_tools_' . $count_key . '_' . $sort;
    
    // Check if caching is enabled
    $use_cache = get_siteefy_settings('use_cache');
    if ($use_cache) {
        $data = siteefy_get_cache($cache_key);
        if ($data !== false) {
            siteefy_debug_cache_status('get_all_tools', $cache_key, $use_cache, true);
            return $data;
        }
    }
    
    siteefy_debug_cache_status('get_all_tools', $cache_key, $use_cache, false);
    
    $args=array(
        'post_type'        => 'tool',
        'numberposts'      => $count,
        'orderby'        => 'date',
        'order'          => $sort,
        'no_found_rows'  => true,
        'update_post_meta_cache' => false,
        'update_post_term_cache' => false,
    );
    
    // Apply optimization filter
    $args = apply_filters('siteefy_get_posts_args', $args, 'tool');
    
    $tools = get_posts($args);
    
    // Cache the results for 24 hours if caching is enabled
    if ($use_cache) {
        siteefy_set_cache($cache_key, $tools, 86400);
    }
    
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
        $selected_tasks_ids_for_post = get_tasks_for_tool_from_its_solution($post_id);
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