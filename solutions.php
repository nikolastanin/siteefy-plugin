<?php
//todo:done

function get_all_solutions($limit=-1) {
    if($limit===-1){
        $limit=0;
    }
    $terms = get_terms(array(
        'taxonomy'   => 'solution', // Replace with your taxonomy name
        'hide_empty' => false, // Include terms even if they have no posts
        'number'     => $limit, // Limit the number of terms returned
    ));
    if (!is_wp_error($terms) && !empty($terms)) {
        return $terms;
    }

    return array();
}

function get_count_of_tools_for_single_solution($solution_id) {
    $query = new WP_Query(array(
        'post_type'      => array('tool', 'task'),  // CPT name
        'posts_per_page' => -1,      // Get all posts
        'fields'         => 'ids',   // Only fetch post IDs (improves performance)
        'tax_query'      => array(
            array(
                'taxonomy' => 'solution', // Change this to your actual taxonomy
                'field'    => 'term_id',      // Match by term ID
                'terms'    => $solution_id,   // Category to check
            ),
        ),
    ));

    return $query->found_posts; // Return the count of matching posts
}
function get_solutions_for_tool($tool_id) {
    $terms = wp_get_post_terms($tool_id, 'solution', array('fields' => 'ids'));

    if (!is_wp_error($terms)) {
        return $terms; // Returns an array of term IDs
    }

    return array(); // Return an empty array if no terms are found
}

function get_solutions_terms_for_tool($tool_id) {
    $terms = wp_get_post_terms($tool_id, 'solution');

    if (!is_wp_error($terms)) {
        return $terms; // Returns an array of term IDs
    }

    return array(); // Return an empty array if no terms are found
}

function get_solutions_for_task($task_id){
    $terms = wp_get_post_terms($task_id, 'solution', array('fields' => 'ids'));
    if (!is_wp_error($terms)) {
        return $terms; // Returns an array of term IDs
    }
    return array(); // Return an empty array if no terms are found
}


//todo:check if it works
function get_tasks_for_tool_from_its_solution($tool_id = 0) {
    $solution_ids = get_solutions_for_tool($tool_id);
    if (empty($solution_ids)) {
        return [];
    }

    $tasks = get_all_tasks(); // Returns an array of WP_Post objects
    $matching_tasks = [];

    foreach ($tasks as $task) {
        $task_assigned_solutions = get_solutions_for_task($task->ID);

        if (!empty($task_assigned_solutions) && array_intersect($solution_ids, $task_assigned_solutions)) {
            $matching_tasks[] = $task->ID; // Collect only task IDs
        }
    }

    return $matching_tasks;
}
//var_dump('here biatch');
//var_dump(get_tasks_for_tool_from_its_solution());

function get_tools_grouped_by_solution_name_by_using_task_id($task_id) {
    $tools = get_tools_by_task_id($task_id);
    $grouped_solutions = array();
    $used_tool_ids = array(); // Track tool IDs that have already been assigned to a solution

    foreach ($tools as $tool) {
        // Get the assigned solutions for the current tool
        $assigned_solutions = get_solutions_for_tool($tool->ID);

        if (is_array($assigned_solutions)) {
            foreach ($assigned_solutions as $solution_id) {
                // Skip the tool if it has already been assigned to a solution
                if (in_array($tool->ID, $used_tool_ids)) {
                    continue;
                }

                $solution_post = get_term($solution_id); // Get the full solution post object
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
//    $cache_key = 'tools_by_task_id_' . $solution_id;
    $data = false;

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
            $assigned_tasks = get_solutions_for_tool($post_id);

            if (!empty($assigned_tasks) && in_array($solution_id, $assigned_tasks)) {
                // If the task ID is found in the assigned tasks, add the tool to the filtered list
                $filtered_tools[] = $single_tool;
            }
        }

        // Store the result in a transient for future requests
        $data = $filtered_tools;
//        set_transient($cache_key, $data, 1); // Cache for 1 hour
    }

    // Return the filtered tools
    return $data;
}


function get_solution_name_by_tool_id($tool_id, $shorten=false){
    $solution_id = get_solutions_for_tool($tool_id);
    if(array_key_exists(0, $solution_id)){
        $solution = get_term($solution_id[0]);
        if($solution){
            $name = $solution->name;
            if ($shorten && strlen($name) >= 14) {
                return substr($name, 0, 14) . "...";
            }
            return $name;
        }
    }
    return '';
}