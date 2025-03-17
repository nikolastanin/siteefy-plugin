
<header id="main-header">
    <div class="nav container">
        <img src="<?php echo get_siteefy_home_url(); ?>wp-content/plugins/siteefy/assets/siteefy-logo-black.png" width="141px" height="59px" alt="siteefy logo">
        <div class="main-menu">
            <?php wp_nav_menu(); ?>

        </div>
        <div id="hamburger" style="display:none;">
            <svg xmlns="http://www.w3.org/2000/svg" width="23" height="23" viewBox="0 0 23 23" fill="none">
                <path d="M0 2H23" stroke="#3F3F3F" stroke-width="3"/>
                <path d="M0 11.0357H23" stroke="#3F3F3F" stroke-width="3"/>
                <path d="M0 20.8929H23" stroke="#3F3F3F" stroke-width="3"/>
            </svg>
        </div>
    </div>
</header>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const header = document.getElementById("main-header");
        const headerImg = document.querySelector("header img");
        window.addEventListener("scroll", function () {
            if (window.scrollY > 50) {
                header.style.background = "linear-gradient(158deg, #CFDCFF 18.38%, #EDF2FF 57.07%, #99B5FF 88.75%)";
                header.style.padding = "16px 0";
                header.style.boxShadow = "0px 0px 10px 0px rgba(0, 0, 0, 0.1)";
                header.style.transition = "all 0.2s linear";
                header.style.position = "fixed";
                header.style.top = "0";
                header.style.left = "0";
                header.style.width = "100%";
                header.style.zIndex = "1000";  // Ensures it stays on top of other content
                // headerImg.style.transform = "scale(0.7)"; // Ensures it stays on top of other content
            } else {
                header.style.background = "transparent";
                header.style.padding = "32px 0";
                header.style.position = "";
                header.style.top = "";
                header.style.left = "";
                header.style.width = "";
                header.style.zIndex = "";
                header.style.boxShadow = "none";
                // headerImg.style.transform = "scale(1.0)"; // Ensures it stays on top of other content
            }
        });
    });
    document.addEventListener("DOMContentLoaded", function () {
        const hamburger = document.getElementById("hamburger");
        const mainMenu = document.querySelector(".main-menu");

        hamburger.addEventListener("click", function () {
            if (mainMenu.style.display === "none" || mainMenu.style.display === "") {
                mainMenu.style.display = "flex";
            } else {
                mainMenu.style.display = "none";
            }
        });
    });

</script>
<div id="hero">
    <div class="hero-container container">
        <div class="hero-inner">
            <div class="highlighted-text">
                <h1><span class="highlight">All Tools</span><br>
                    in one place
                </h1>
            </div>

            <p class="subtitle">Handpicked <strong>tools</strong> for real results</p>
            <div class="main-hero__search">
                <?php do_action( 'get_siteefy_search' ); ?>
            </div>
            <div class="hero-quick-links">
                <a href="<?php echo get_siteefy_home_url('/category'); ?>" class="quick-link__btn">🥇 Top rated</a>
                <a href="<?php echo get_siteefy_home_url('/category'); ?>" class="quick-link__btn">📁 Categories</a>
                <a href="<?php echo get_siteefy_home_url('/tasks'); ?>" class="quick-link__btn">📋 Tasks</a>
                <a href="<?php echo get_siteefy_home_url('/tools'); ?>" class="quick-link__btn">🔧 Tools</a>
            </div>
        </div>

    </div>
    <div class="hero-icons">
    <span id="dotted-line">
        <svg xmlns="http://www.w3.org/2000/svg" width="260" height="587" viewBox="0 0 260 587" fill="none">
<path d="M209.5 -20.5C236.167 0.666666 263.872 20.8893 256.5 81.5C247.5 155.5 179.5 198.957 103.5 232C17 269.609 -83.4999 433 129 584.5" stroke="#6892FF" stroke-width="4" stroke-dasharray="14 14"/>
</svg>
    </span>
        <span id="lightbulb-icon">
        <svg xmlns="http://www.w3.org/2000/svg" width="95" height="117" viewBox="0 0 95 117" fill="none">
        <path d="M36.1123 75.5834C40.2746 76.693 47.9778 85.259 51.3091 89.4033L70.2098 83.4283C70.2022 81.1207 68.943 76.9851 68.8088 72.1766C68.6412 66.166 67.2118 65.011 70.6913 60.3203C79.5052 48.4386 75.2729 35.0506 72.9079 27.5696C70.1443 18.8273 55.0133 2.47523 31.9056 10.2133C8.79795 17.9513 6.25493 38.6786 10.3424 52.9786C14.4299 67.2786 30.9096 74.1963 36.1123 75.5834Z" stroke="#89AAFF" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"/>
        <path d="M58.6556 86.6412C49.6058 66.6913 31.1136 30.2072 28.0488 39.1454C24.2178 50.3182 39.788 65.3194 50.191 59.8652C60.594 54.4109 61.2902 26.4714 53.5597 28.049C47.3753 29.311 58.4558 65.9148 64.9558 84.6496M55.6121 97.565L72.1502 92.3369L74.0809 102.554L61.0866 106.662L55.6121 97.565Z" stroke="#89AAFF" stroke-width="4" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
   </span>
        <span id="envelop-icon">
        <svg xmlns="http://www.w3.org/2000/svg" width="90" height="78" viewBox="0 0 90 78" fill="none">
        <rect x="22.859" y="3" width="70.2208" height="47.0552" transform="rotate(24.9632 22.859 3)" stroke="#89AAFF" stroke-width="5" stroke-linejoin="round"/>
        <path d="M23.0344 3.48091L41.5745 46.8476L86.3669 32.9639" stroke="#89AAFF" stroke-width="5" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
    </span>
        <span id="tick-icon">
        <svg xmlns="http://www.w3.org/2000/svg" width="84" height="80" viewBox="0 0 84 80" fill="none">
        <rect x="15.6882" y="32.3714" width="42.4889" height="42.4889" transform="rotate(-23.1232 15.6882 32.3714)" stroke="#89AAFF" stroke-width="5" stroke-linejoin="round"/>
        <path d="M15.6983 54.184L44.9753 64.1408L59.541 6.58713" stroke="#FFDA10" stroke-width="7" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
    </span>
        <span id="monkey-icon">
        @
    </span>
    </div>
</div>

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
