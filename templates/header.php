<div class="main-hero">
    <div class="container">
        <div class="main-hero__inner">
            <div class="main-hero__search">
                <h1>
                   <?php echo get_field('field_homepage_text'); ?>
                </h1>
                <?php do_action( 'get_siteefy_search' ); ?>
            </div>
            <div class="hero-quick-categories">
                <?php
                    $categories = get_all_categories(3);
                    // Display the categories for task_categories
                    if (!empty($categories)) {
                        foreach ($categories as $category) {
                            echo '<a href="'.  get_permalink($category)   .'" class="quick-category">';
                            echo  '#' . esc_html($category->post_title); // Output the term name
                            echo '</a>';
                        }
                    }
               ?>

            </div>
        </div>
    </div>
</div>
<?php //echo $data['data'] ?>
