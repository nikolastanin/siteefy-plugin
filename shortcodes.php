<?php

add_shortcode('most-popular-tasks', function(){
    ob_start(); // Start output buffering to capture output as string
    $tasks = get_all_tasks(3);
                ?>
                <?php foreach ($tasks as $task): ?>
                    <a  href="<?php echo get_permalink($task->ID);  ?>" class="popular-task-item">
                        <div class="popular-task-item__inner">
                            <div class="popular-task-item__category">
                                <?php echo esc_html($task->post_title); // Get category from post meta ?>
                            </div>
                            <span class="task-name">
                               <?php get_task_assigned_category_name($task); ?>
                            </span>
                        </div>
                    </a>
                <?php endforeach;
    return ob_get_clean(); // Return buffered content as shortcode output
});


add_shortcode('popular-categories', function(){
    ob_start(); // Start output buffering to capture output as string
    $categories = get_all_categories(5);
//    var_dump(get_tools_and_tasks_by_search_term('solutiontest'));

    if (!empty($categories)) {
        foreach ($categories as $category) {
            echo '<a href="' . get_term_link($category) . '" class="popular-task-item__category">';
            echo  esc_html($category->name); // Output the term name
            echo '</a>';
        }
    }
    return ob_get_clean(); // Return buffered content as shortcode output
});



add_shortcode('top-rated-tools', function(){
    ob_start(); // Start output buffering to capture output as string

    $top_rated_tools = get_all_top_rated_tools(3); // Assuming this function fetches the top 3 rated tools.

                if (!empty($top_rated_tools)) {
                    foreach ($top_rated_tools as $tool) {
                        ?>
                        <div class="tool-item" data-link="<?php siteefy_get_field('tool_review_link', $tool->ID); ?>">
                            <div class="tool-item__inner">
                                <div class="tool-item__img">
                                    <img src="<?php siteefy_get_field('tool_image', $tool->ID); ?>" alt="<?php siteefy_get_field('tool_name', $tool->ID); ?>">
                                </div>
                                <div class="tool-item__details">
                                    <div class="tool-item__title">
                                        <a href="<?php siteefy_get_field('tool_review_link', $tool->ID); ?>"><?php siteefy_get_field('tool_name', $tool->ID); ?></a>
                                        <img width="24px" height="24px" src="<?php echo get_siteefy_home_url(); ?>wp-content/plugins/siteefy/assets/verified-icon.png" alt="Verified">
                                    </div>
                                    <div class="tool-item__solution-name">
                                        <?php echo get_solution_name_by_tool_id($tool->ID); ?>
                                    </div>
                                </div>
                            </div>
                            <div class="tool-item__bottom">
                                <?php siteefy_get_field('tool_price', $tool->ID); ?>
                                <span class="tool-item__bottom-rating">
                        <svg xmlns="http://www.w3.org/2000/svg" width="15" height="14" viewBox="0 0 15 14" fill="none">
                            <path d="M7.5 0.225955L9.61452 4.51044L9.63779 4.55759L9.68982 4.56515L14.418 5.2522L10.9967 8.5872L10.959 8.6239L10.9679 8.67572L11.7756 13.3848L7.54653 11.1615L7.5 11.137L7.45347 11.1615L3.22442 13.3848L4.0321 8.67572L4.04099 8.6239L4.00334 8.5872L0.581972 5.2522L5.31018 4.56515L5.36221 4.55759L5.38548 4.51044L7.5 0.225955Z" fill="#FFDA10" stroke="#FFCC00" stroke-width="0.2"></path>
                        </svg>
                        <?php siteefy_get_field('tool_rating', $tool->ID); ?>
                    </span>
                            </div>
                        </div>
                        <?php
                    }
                }
    return ob_get_clean(); // Return buffered content as shortcode output


});
add_shortcode('newly-discovered-tools', function(){
    ob_start(); // Start output buffering to capture output as string

    $newly_discovered = get_all_tools(2, 'ASC');
    if (!empty($newly_discovered)) {
        foreach ($newly_discovered as $tool) {
            ?>
            <div class="tool-item" data-link="<?php siteefy_get_field('tool_review_link', $tool->ID); ?>">
                <div class="tool-item__inner">
                    <div class="tool-item__img">
                        <img src="<?php siteefy_get_field('tool_image', $tool->ID); ?>" alt="<?php siteefy_get_field('tool_name', $tool->ID); ?>">
                    </div>
                    <div class="tool-item__details">
                        <div class="tool-item__title">
                            <a href="<?php siteefy_get_field('tool_review_link', $tool->ID); ?>"><?php siteefy_get_field('tool_name', $tool->ID); ?></a>
                            <img width="24px" height="24px" src="<?php echo get_siteefy_home_url(); ?>wp-content/plugins/siteefy/assets/verified-icon.png" alt="Verified">
                        </div>
                        <div class="tool-item__solution-name">
                            <?php echo get_solution_name_by_tool_id($tool->ID); ?>
                        </div>
                    </div>
                </div>
                <div class="tool-item__bottom">
                    <?php siteefy_get_field('tool_price', $tool->ID); ?>
                    <span class="tool-item__bottom-rating">
                            <svg xmlns="http://www.w3.org/2000/svg" width="15" height="14" viewBox="0 0 15 14" fill="none">
                                <path d="M7.5 0.225955L9.61452 4.51044L9.63779 4.55759L9.68982 4.56515L14.418 5.2522L10.9967 8.5872L10.959 8.6239L10.9679 8.67572L11.7756 13.3848L7.54653 11.1615L7.5 11.137L7.45347 11.1615L3.22442 13.3848L4.0321 8.67572L4.04099 8.6239L4.00334 8.5872L0.581972 5.2522L5.31018 4.56515L5.36221 4.55759L5.38548 4.51044L7.5 0.225955Z" fill="#FFDA10" stroke="#FFCC00" stroke-width="0.2"></path>
                            </svg>
                            <?php siteefy_get_field('tool_rating', $tool->ID); ?>
                        </span>
                </div>
            </div>
            <?php
        }
    }
    return ob_get_clean(); // Return buffered content as shortcode output

});


add_shortcode('recent-tools', function(){
    return Siteefy::blade()->run('shortcodes.recent-tools', [
        'recent_tools' => get_all_tools(3, 'DESC')
    ]);
});

add_shortcode('top-tools-by-categories', function(){
    $categories = get_all_categories(3);
    $tools_by_category = array();
    foreach ($categories as $cat){
        $tools_by_category[$cat->term_id] = get_cpt_posts_by_tax('tool',$cat->taxonomy,$cat->term_id);
    }
    return Siteefy::blade()->run('tools-by-categories', [
        'categories'=>$categories,
        'tools_by_category'=>$tools_by_category,
    ]);
});


add_shortcode('tool-of-the-week', function(){
    $tool_of_the_week = get_selected_tool_of_the_week();
    $choosen_tool_text = get_options(array('tool_of_the_week_text'));

    return Siteefy::blade()->run('tool-of-the-week', [
        'tool_of_the_week' =>$tool_of_the_week,
        'choosen_tool_text' => $choosen_tool_text,
        'solutions' => get_solutions_terms_for_tool($tool_of_the_week->ID),
    ]);
});

add_shortcode('tools-by-top-tasks', function(){
    $tasks = get_all_tasks(5);
    $tools_collection = array();
    $listing_limit = 6;

    foreach ($tasks as $task){
        $task_id = $task->ID;
        $tools_by_task_id = get_tools_by_task_id($task_id);
        $tools_collection[$task_id] = array_slice($tools_by_task_id, 0, $listing_limit);
    }
    return Siteefy::blade()->run('shortcodes.tools-by-top-tasks', [
        'tools_collection_by_tasks' =>$tools_collection,
        'tasks' =>$tasks,
    ]);
});

add_shortcode('tools-by-top-solutions', function(){
    $solutions = get_all_solutions(5);
    $solutions_collection = array();
    $listing_limit = 6;
    foreach ($solutions as $solution){
        $solution_id = $solution->term_id;
        $tools_by_solution_id = get_tools_by_solution_id($solution_id);
        $solutions_collection[$solution_id] = array_slice($tools_by_solution_id, 0, $listing_limit);
    }
    return Siteefy::blade()->run('shortcodes.tools-by-top-solutions', [
        'solutions'=>$solutions,
        'tools_collection_by_solutions' =>$solutions_collection,
    ]);
});

add_shortcode('link', function($atts){
    return get_siteefy_home_url($atts['path']);
});




