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
                               <?php get_task_assigned_category($task); ?>
                            </span>
                        </div>
                    </a>
                <?php endforeach;
    return ob_get_clean(); // Return buffered content as shortcode output
});


add_shortcode('popular-categories', function(){
    ob_start(); // Start output buffering to capture output as string
    $categories = get_all_categories(5);
    if (!empty($categories)) {
        foreach ($categories as $category) {
            echo '<a href="' . get_permalink($category) . '" class="popular-task-item__category">';
            echo '💼 ' . esc_html($category->post_title); // Output the term name
            echo '</a>';
        }
    }
    return ob_get_clean(); // Return buffered content as shortcode output
});


add_shortcode('tool-of-the-week', function(){
    ob_start(); // Start output buffering to capture output as string

    $tool_of_the_week = get_selected_tool_of_the_week();
    $choosen_tool_text = get_options(array('tool_of_the_week_text'));
    if($tool_of_the_week->post_type==='tool' && $tool_of_the_week){
    ?>
    <h2 class="text-blue align-center">Tool of the Week</h2>
    <p><?php echo $choosen_tool_text['tool_of_the_week_text'];?></p>
    <div class="tool-item" data-link="<?php siteefy_get_field('tool_review_link',$tool_of_the_week->ID); ?>">
                        <div class="tool-item__inner">
                            <div class="tool-item__img">
                                <img src="<?php siteefy_get_field('tool_image',$tool_of_the_week->ID); ?>" alt="<?php siteefy_get_field('tool_name',$tool_of_the_week->ID); ?>">
                            </div>
                            <div class="tool-item__details">
                                <div class="tool-item__title">
                                    <a href="<?php siteefy_get_field('tool_review_link',$tool_of_the_week->ID); ?>"><?php siteefy_get_field('tool_name',$tool_of_the_week->ID); ?></a>
                                    <img width="24px" height="24px" src="<?php echo get_siteefy_home_url(); ?>wp-content/plugins/siteefy/assets/verified-icon.png" alt="Verified">
                                </div>
                                <div class="tool-item__solution-name">
                                    <?php echo get_solution_name_by_tool_id($tool_of_the_week->ID); ?>
                                </div>
                            </div>
                        </div>
                        <div class="tool-item__bottom">
                            <?php siteefy_get_field('tool_price',$tool_of_the_week->ID); ?>
                            <span class="tool-item__bottom-rating">
            <svg xmlns="http://www.w3.org/2000/svg" width="15" height="14" viewBox="0 0 15 14" fill="none">
                <path d="M7.5 0.225955L9.61452 4.51044L9.63779 4.55759L9.68982 4.56515L14.418 5.2522L10.9967 8.5872L10.959 8.6239L10.9679 8.67572L11.7756 13.3848L7.54653 11.1615L7.5 11.137L7.45347 11.1615L3.22442 13.3848L4.0321 8.67572L4.04099 8.6239L4.00334 8.5872L0.581972 5.2522L5.31018 4.56515L5.36221 4.55759L5.38548 4.51044L7.5 0.225955Z" fill="#FFDA10" stroke="#FFCC00" stroke-width="0.2"></path>
            </svg>
            <?php siteefy_get_field('tool_rating',$tool_of_the_week->ID); ?>
        </span>
                        </div>
                    </div><?php
    return ob_get_clean(); // Return buffered content as shortcode output
    }
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






