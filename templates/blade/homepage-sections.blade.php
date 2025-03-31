
<section class="categories-homepage">
    <span id="categories-section-icon">
        <svg xmlns="http://www.w3.org/2000/svg" width="100%" height="1317" viewBox="0 0 1440 1317" fill="none" preserveAspectRatio="none">
        <path d="M1011 136.986C1091.5 67.916 1082.5 68.4864 1151 136.986C1219.5 205.486 1267.5 306.986 1441 35.9862V1202.49C1441 1202.49 877.5 1316.49 722.75 1316.49C568 1316.49 -0.500005 1202.49 -0.500005 1202.49V185.13C-0.516198 185.059 -0.500005 184.986 -0.500005 184.986V185.13C-0.295793 186.02 5.05914 186.548 113 35.9862C181.466 -59.5138 173.23 50.5731 684 184.986C882.5 237.223 884 245.954 1011 136.986Z" fill="#EEF4FF"/>
         </svg>
    </span>
    <span id="categories-section-icon-mobile">
       <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 390 1136" fill="none" width="100%" height="100%" preserveAspectRatio="none"><path d="M267.5 121C294.802 84.5377 285.627 80.7438 308.218 121C330.809 161.256 352 175.5 390 0L390 1069.97C390 1069.97 237.545 1136 195.677 1136C153.81 1136 0.00192379 1069.97 0.00192379 1069.97L0.0019471 198.69C-0.00243387 198.649 0.0019471 198.607 0.0019471 198.607L0.0019471 198.69C0.0571965 199.205 1.50597 199.511 30.7094 112.302C49.2329 56.986 84.589 87.7136 96.5 93.5C255 170.5 228.337 173.303 267.5 121Z" fill="#EEF4FF"/></svg>
    </span>
    <div class="container">
        <h2><span class="highlight">Newly discovered</span> tools</h2>
        <p class="subtitle">New tools are added <strong>daily</strong> to our database ensuring we stay up to date on the latest trends.</p>
        <div class="subheading">
            New tools of the week:
        </div>
        <div class="category-of-tools__container">
            @foreach($recent_tools as $tool)
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
                                <?php echo get_solution_name_by_tool_id($tool->ID, true); ?>
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
                    <svg class="pin" xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 22 22" fill="none">
                        <path d="M0 0H17C19.7614 0 22 2.23858 22 5V22L0 0Z" fill="#FFDA10"></path>
                    </svg>
                    <a class="tool-item__link" href="{{siteefy_get_field('tool_review_link', $tool->ID)}}"></a>
                </div>
            @endforeach

        </div>
        <a href="<?php echo get_siteefy_home_url('/tools'); ?>" class="view-more__link">>> view more</a>
        <hr>
    </div>

    <?php do_action('get_siteefy_top_tools_by_categories'); ?>

</section>

<?php do_action('get_siteefy_tool_of_the_week'); ?>

<section class="tasks listing-section">
    <div class="container">
        <h2>Tasks <span class="highlight">blabla</span></h2>
        <p class="subtitle">Need a drawing? Need a perfectly tailored resume? <br>Find tools in our database that can help you with any
            <strong>task</strong> at hand.</p>
        <div class="related-container">
            <div class="subheading">
                Top Tasks:
            </div>

            <div class="related-items">
                @foreach($tasks as $index=>$task)
                    <div class="related-item {{ $index === 0 ? 'active' : '' }}" data-id="{{ $task->ID }}">
                        {{$task->post_title}}
                    </div>
                @endforeach
            </div>
            @foreach ($tools_collection_by_tasks as $key=>$tools_collection)
                <div class="tools-collection-container" data-tab-id="{{$key}}">
                    @foreach($tools_collection as $tool)
                        <div class="one-tool-item">
                            <div class="one-tool__upper">
                                <img src="<?php siteefy_get_field('tool_image', $tool->ID); ?>" alt="tool headline image">
                            </div>
                            <div class="one-tool__bottom">
                                <div class="one-tool__bottom-inner">
                                </div>
                                <div class="one-tool__heading">
                                    <?php siteefy_get_field('tool_name', $tool->ID); ?>
                                    <img width="24px" height="24px" src="<?php echo get_siteefy_home_url(); ?>wp-content/plugins/siteefy/assets/verified-icon.png" alt="Verified">
                                </div>
                                <div class="one-tool__description">
                                    {{ get_tool_description($tool->ID) }}
                                </div>
                                <div class="one-tool__tags">
                                    <div class="one-tool__task">
                                        <?php echo get_solution_name_by_tool_id($tool->ID); ?>
                                    </div>
                                    <div class="one-tool__price">
                                        <?php siteefy_get_field('tool_exact_price', $tool->ID); ?>
                                    </div>
                                </div>
                            </div>
                            <a class="tool-item__link" href="{{siteefy_get_field('tool_review_link', $tool->ID)}}"></a>
                        </div>
                    @endforeach
                </div>
            @endforeach
            <div class="button-container">
                <a class="show-more__btn" href="<?php echo get_siteefy_home_url('/tasks');?>">view more</a>
            </div>
        </div>
        <script>
            document.addEventListener("DOMContentLoaded", function () {

                const tasksSection = document.querySelector(".tasks");
                if (!tasksSection) return;

                const taskItems = tasksSection.querySelectorAll(".tasks * > .related-item");
                const toolCollections = tasksSection.querySelectorAll(".tasks * > .tools-collection-container");

                // Hide all collections except the first one
                toolCollections.forEach((collection, index) => {
                    collection.style.display = index === 0 ? "flex" : "none";
                });

                // Add 'active' class to the first task item
                if (taskItems.length > 0) {
                    taskItems[0].classList.add("active");
                }

                taskItems.forEach((item) => {
                    item.addEventListener("click", function () {
                        const selectedId = this.getAttribute("data-id");

                        // Remove 'active' class from all task items
                        taskItems.forEach(task => task.classList.remove("active"));

                        // Add 'active' class to clicked item
                        this.classList.add("active");

                        // Show the corresponding collection and hide others
                        toolCollections.forEach(collection => {
                            collection.style.display = collection.getAttribute("data-tab-id") === selectedId ? "flex" : "none";
                        });
                    });
                });
            });


        </script>
    </div>
</section>

<section class="solutions listing-section">
    <div class="container">
        <h2>Solutions <span class="highlight"> blabla</span></h2>
        <p class="subtitle">They streamline workflows, improve decision-making, and help teams work more efficiently.</p>
        <div class="related-container">
            <div class="subheading">
                Top Solutions:
            </div>

            <div class="related-items">
                @foreach($solutions as $index=>$solution)
                    <div class="related-item {{ $index === 0 ? 'active' : '' }}" data-id="{{ $solution->term_id }}">
                        {{$solution->name}}
                    </div>
                @endforeach
            </div>
            @foreach ($tools_collection_by_solutions as $key=>$tools_collection)
                <div class="tools-collection-container" data-tab-id="{{$key}}">
                    @foreach($tools_collection as $tool)
                        <div class="one-tool-item">
                            <div class="one-tool__upper">
                                <img src="<?php siteefy_get_field('tool_image', $tool->ID); ?>" alt="tool headline image">
                            </div>
                            <div class="one-tool__bottom">
                                <div class="one-tool__bottom-inner">
                                </div>
                                <div class="one-tool__heading">
                                    <?php siteefy_get_field('tool_name', $tool->ID); ?>
                                    <img width="24px" height="24px" src="<?php echo get_siteefy_home_url(); ?>wp-content/plugins/siteefy/assets/verified-icon.png" alt="Verified">
                                </div>
                                <div class="one-tool__description">
                                    {{get_tool_description($tool->ID)}}
                                </div>
                                <div class="one-tool__tags">
                                    <div class="one-tool__task">
                                        <?php echo get_solution_name_by_tool_id($tool->ID); ?>
                                    </div>
                                    <div class="one-tool__price">
                                        <?php siteefy_get_field('tool_exact_price', $tool->ID); ?>
                                    </div>
                                </div>
                            </div>
                            <a class="tool-item__link" href="{{siteefy_get_field('tool_review_link', $tool->ID)}}"></a>
                        </div>
                    @endforeach
                </div>
            @endforeach
            <div class="button-container">
                <a class="show-more__btn" href="<?php echo get_siteefy_home_url('/solution');?>">view more</a>
            </div>
        </div>
        <script>
            document.addEventListener("DOMContentLoaded", function () {

                const tasksSection = document.querySelector(".solutions");
                if (!tasksSection) return;

                const taskItems = tasksSection.querySelectorAll(".solutions * > .related-item");
                const toolCollections = tasksSection.querySelectorAll(".solutions * > .tools-collection-container");

                // Hide all collections except the first one
                toolCollections.forEach((collection, index) => {
                    collection.style.display = index === 0 ? "flex" : "none";
                });

                // Add 'active' class to the first task item
                if (taskItems.length > 0) {
                    taskItems[0].classList.add("active");
                }

                taskItems.forEach((item) => {
                    item.addEventListener("click", function () {
                        const selectedId = this.getAttribute("data-id");

                        // Remove 'active' class from all task items
                        taskItems.forEach(task => task.classList.remove("active"));

                        // Add 'active' class to clicked item
                        this.classList.add("active");

                        // Show the corresponding collection and hide others
                        toolCollections.forEach(collection => {
                            collection.style.display = collection.getAttribute("data-tab-id") === selectedId ? "flex" : "none";
                        });
                    });
                });
            });
        </script>
    </div>
</section>
