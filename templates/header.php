

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
               <a href="" class="quick-link__btn">📁 categories</a>
               <a href="" class="quick-link__btn">📁 categories</a>
               <a href="" class="quick-link__btn">📁 categories</a>
               <a href="" class="quick-link__btn">📁 categories</a>
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
<section class="newly-discovered-tools-section">
        <span id="categories-section-icon">
            <svg xmlns="http://www.w3.org/2000/svg" width="100%" height="1317" viewBox="0 0 1440 1317" fill="none" preserveAspectRatio="none">
            <path d="M1011 136.986C1091.5 67.916 1082.5 68.4864 1151 136.986C1219.5 205.486 1267.5 306.986 1441 35.9862V1202.49C1441 1202.49 877.5 1316.49 722.75 1316.49C568 1316.49 -0.500005 1202.49 -0.500005 1202.49V185.13C-0.516198 185.059 -0.500005 184.986 -0.500005 184.986V185.13C-0.295793 186.02 5.05914 186.548 113 35.9862C181.466 -59.5138 173.23 50.5731 684 184.986C882.5 237.223 884 245.954 1011 136.986Z" fill="#EEF4FF"/>
        </svg>
        </span>
    <div class="container">
            <h2><span class="highlight">Categories</span> of tools</h2>
        <p class="subtitle">These are <strong>essential</strong> for ensuring that projects stay on track.</p>
<?php $tool = get_post(57059); ?>

        <div class="category-of-tools__container">
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

        </div>
        <a href="#" class="view-more__link">>> view more</a>
        <hr>
    </div>
    <div class="container tabs-and-commonly-searched__container">
<!--        <div class="commonly-searched">-->
<!--            <div class="commonly-searched__text">-->
<!--                Commonly Searched:-->
<!--            </div>-->
<!--            <div class="tool-of-the-week__left-bottom">-->
<!--                <a href="https://wordpress-1021474-4844794.cloudwaysapps.com/ai/" class="popular-task-item__category">AI</a><a href="https://wordpress-1021474-4844794.cloudwaysapps.com/ai-content-analysis/" class="popular-task-item__category">AI Content Analysis</a><a href="https://wordpress-1021474-4844794.cloudwaysapps.com/ai-tool/" class="popular-task-item__category">AI Tool</a><a href="https://wordpress-1021474-4844794.cloudwaysapps.com/business/" class="popular-task-item__category">Business</a><a href="https://wordpress-1021474-4844794.cloudwaysapps.com/design/" class="popular-task-item__category">Design</a>-->
<!--            </div>-->
<!--            <a href="#" class="view-more__link">>> view more</a>-->
<!--        </div>-->
        <div class="subheading">
            Most searched categories:
        </div>
        <div class="tabs-container">
            <div class="tabs-switcher__container">
                <div class="rounded-tab left">
                    🌐 Web Development
                </div>
                <div class="rounded-tab colored">
                    🌐 Web Development
                </div>
                <div class="rounded-tab colored">
                    🌐 Web Development
                </div>
            </div>
            <div class="tab">
               <div class="tab-inner">
                   <div class="tab-inner__text">
                       Tools related with category:<strong>top-rated</strong>
                   </div>
                   <div class="tab-tools__container">
                       <div class="tab-tool">
                           <div class="tab-tool__inner">
                               <div class="tab-tool__top">
                                   <img class="tab-tool__image" src="https://wordpress-1021474-4844794.cloudwaysapps.com/wp-content/uploads/2024/07/Yuzzit-homepage.png" alt="tool image">
                                   <div class="tab-tool__heading">
                                       heading
                                   </div>
                                   <img width="18px" height="18px" src="<?php echo get_siteefy_home_url(); ?>wp-content/plugins/siteefy/assets/verified-icon.png" alt="Verified">
                               </div>
                               <div class="tab-tool__description">Trello is a collaborative app for teams to work and communicate together more easily.</div>
                               <div class="tab-tool__rating">
                                   <svg xmlns="http://www.w3.org/2000/svg" width="11" height="12" viewBox="0 0 11 12" fill="none">
                                       <path d="M2.86 6.40777V11.0886H8.58V6.40777H11L5.5 0.088623L0 6.40777H2.86Z" fill="#029D24"/>
                                   </svg>
                                   9.8/10
                               </div>
                           </div>
                       </div>
                       <div class="tab-tool">
                           <div class="tab-tool__inner">
                               <div class="tab-tool__top">
                                   <img class="tab-tool__image" src="https://wordpress-1021474-4844794.cloudwaysapps.com/wp-content/uploads/2024/07/Yuzzit-homepage.png" alt="tool image">
                                   <div class="tab-tool__heading">
                                       heading
                                   </div>
                                   <img width="18px" height="18px" src="<?php echo get_siteefy_home_url(); ?>wp-content/plugins/siteefy/assets/verified-icon.png" alt="Verified">
                               </div>
                               <div class="tab-tool__description">Trello is a collaborative app for teams to work and communicate together more easily.</div>
                               <div class="tab-tool__rating">
                                   <svg xmlns="http://www.w3.org/2000/svg" width="11" height="12" viewBox="0 0 11 12" fill="none">
                                       <path d="M2.86 6.40777V11.0886H8.58V6.40777H11L5.5 0.088623L0 6.40777H2.86Z" fill="#029D24"/>
                                   </svg>
                                   9.8/10
                               </div>
                           </div>
                       </div>
                       <div class="tab-tool">
                           <div class="tab-tool__inner">
                               <div class="tab-tool__top">
                                   <img class="tab-tool__image" src="https://wordpress-1021474-4844794.cloudwaysapps.com/wp-content/uploads/2024/07/Yuzzit-homepage.png" alt="tool image">
                                   <div class="tab-tool__heading">
                                       heading
                                   </div>
                                   <img width="18px" height="18px" src="<?php echo get_siteefy_home_url(); ?>wp-content/plugins/siteefy/assets/verified-icon.png" alt="Verified">
                               </div>
                               <div class="tab-tool__description">Trello is a collaborative app for teams to work and communicate together more easily.</div>
                               <div class="tab-tool__rating">
                                   <svg xmlns="http://www.w3.org/2000/svg" width="11" height="12" viewBox="0 0 11 12" fill="none">
                                       <path d="M2.86 6.40777V11.0886H8.58V6.40777H11L5.5 0.088623L0 6.40777H2.86Z" fill="#029D24"/>
                                   </svg>
                                   9.8/10
                               </div>
                           </div>
                       </div> <div class="tab-tool">
                           <div class="tab-tool__inner">
                               <div class="tab-tool__top">
                                   <img class="tab-tool__image" src="https://wordpress-1021474-4844794.cloudwaysapps.com/wp-content/uploads/2024/07/Yuzzit-homepage.png" alt="tool image">
                                   <div class="tab-tool__heading">
                                       heading
                                   </div>
                                   <img width="18px" height="18px" src="<?php echo get_siteefy_home_url(); ?>wp-content/plugins/siteefy/assets/verified-icon.png" alt="Verified">
                               </div>
                               <div class="tab-tool__description">Trello is a collaborative app for teams to work and communicate together more easily.</div>
                               <div class="tab-tool__rating">
                                   <svg xmlns="http://www.w3.org/2000/svg" width="11" height="12" viewBox="0 0 11 12" fill="none">
                                       <path d="M2.86 6.40777V11.0886H8.58V6.40777H11L5.5 0.088623L0 6.40777H2.86Z" fill="#029D24"/>
                                   </svg>
                                   9.8/10
                               </div>
                           </div>
                       </div>
                       <div class="tab-tool">
                           <div class="tab-tool__inner">
                               <div class="tab-tool__top">
                                   <img class="tab-tool__image" src="https://wordpress-1021474-4844794.cloudwaysapps.com/wp-content/uploads/2024/07/Yuzzit-homepage.png" alt="tool image">
                                   <div class="tab-tool__heading">
                                       heading
                                   </div>
                                   <img width="18px" height="18px" src="<?php echo get_siteefy_home_url(); ?>wp-content/plugins/siteefy/assets/verified-icon.png" alt="Verified">
                               </div>
                               <div class="tab-tool__description">Trello is a collaborative app for teams to work and communicate together more easily.</div>
                               <div class="tab-tool__rating">
                                   <svg xmlns="http://www.w3.org/2000/svg" width="11" height="12" viewBox="0 0 11 12" fill="none">
                                       <path d="M2.86 6.40777V11.0886H8.58V6.40777H11L5.5 0.088623L0 6.40777H2.86Z" fill="#029D24"/>
                                   </svg>
                                   9.8/10
                               </div>
                           </div>
                       </div>
                       <div class="tab-tool">
                           <div class="tab-tool__inner">
                               <div class="tab-tool__top">
                                   <img class="tab-tool__image" src="https://wordpress-1021474-4844794.cloudwaysapps.com/wp-content/uploads/2024/07/Yuzzit-homepage.png" alt="tool image">
                                   <div class="tab-tool__heading">
                                       heading
                                   </div>
                                   <img width="18px" height="18px" src="<?php echo get_siteefy_home_url(); ?>wp-content/plugins/siteefy/assets/verified-icon.png" alt="Verified">
                               </div>
                               <div class="tab-tool__description">Trello is a collaborative app for teams to work and communicate together more easily.</div>
                               <div class="tab-tool__rating">
                                   <svg xmlns="http://www.w3.org/2000/svg" width="11" height="12" viewBox="0 0 11 12" fill="none">
                                       <path d="M2.86 6.40777V11.0886H8.58V6.40777H11L5.5 0.088623L0 6.40777H2.86Z" fill="#029D24"/>
                                   </svg>
                                   9.8/10
                               </div>
                           </div>
                       </div>
                   </div>
               </div>
            </div>
        </div>
    </div>
    <div class="button-container">
        <a class="show-more__btn" href="">more categories</a>
    </div>
</section>
<section class="tool-of-the-week">
    <div class="container">
        <h2 class="tool-of-the-week__heading">
            Tool of the Week:
        </h2>
        <div class="tool-of-the-week-item">
            <img class="tool-of-the-week__image" src="https://wordpress-1021474-4844794.cloudwaysapps.com/wp-content/uploads/2024/07/Yuzzit-homepage.png" alt="tool of the week image">
            <div class="tool-of-the-week__details">
                <div class="tool-of-the-week__title">
                    Wix
                    <img width="32px" height="32px" src="<?php echo get_siteefy_home_url(); ?>wp-content/plugins/siteefy/assets/verified-icon.png" alt="Verified">
                </div>
                <div class="tool-of-the-week__description">
                    Wix is a powerful tool that helps You create your desired website quickly and easily.
                </div>
                <div class="tool-of-the-week__left-bottom unset-width">
                    <a href="https://wordpress-1021474-4844794.cloudwaysapps.com/ai/" class="popular-task-item__category">AI</a>
                    <a href="https://wordpress-1021474-4844794.cloudwaysapps.com/ai-content-analysis/" class="popular-task-item__category">AI Content Analysis</a>
                    <a href="https://wordpress-1021474-4844794.cloudwaysapps.com/ai-tool/" class="popular-task-item__category">AI Tool</a>
                    <a href="https://wordpress-1021474-4844794.cloudwaysapps.com/business/" class="popular-task-item__category">Business</a>
                    <a href="https://wordpress-1021474-4844794.cloudwaysapps.com/design/" class="popular-task-item__category">Design</a>
                </div>
                <div class="tool-of-the-week__price">
                    Free
                </div>

            </div>
        </div>
    </div>
</section>
<section class="tasks-section">
    <div class="container">
        <h2>AI tools help with all <span class="highlight">Tasks</span></h2>
        <p class="subtitle">They streamline workflows, improve decision-making, and help teams work more efficiently.</p>
        <div class="related-container">
            <div class="subheading">
                Top Tasks:
            </div>
            <?php $tasks = get_all_tasks(5); ?>
            <div class="related-items">
                <div class="related-item">
                    🥇 Top-Rated
                </div>
                <div class="related-item">
                    📋 Project Management
                </div>
                <div class="related-item">
                    👫 Team Collaboration
                </div>
                <div class="related-item">
                    📒 Task Tracking
                </div>
                <div class="related-item">
                    📧 Web Hosting
                </div>
                <div class="related-item">
                    📃 Writing & Content
                </div>
            </div>
            <div class="tools-collection-container">
                <div class="one-tool-item">
                    <div class="one-tool__upper">
                        <img src="https://wordpress-1021474-4844794.cloudwaysapps.com/wp-content/uploads/2024/07/Yuzzit-homepage.png" alt="">
                    </div>
                    <div class="one-tool__bottom">
                        <div class="one-tool__bottom-inner">

                        </div>
                        <div class="one-tool__heading">
                            phind
                            <img width="24px" height="24px" src="<?php echo get_siteefy_home_url(); ?>wp-content/plugins/siteefy/assets/verified-icon.png" alt="Verified">
                        </div>
                        <div class="one-tool__description">
                            Phind is a powerful tool that helps developers find the answers they need quickly and easily.
                        </div>
                        <div class="one-tool__tags">
                            <div class="one-tool__task">
                                tasks
                            </div>
                            <div class="one-tool__price">
                                price
                            </div>
                        </div>
                    </div>
                </div>
                <div class="one-tool-item">
                    <div class="one-tool__upper">
                        <img src="https://wordpress-1021474-4844794.cloudwaysapps.com/wp-content/uploads/2024/07/Yuzzit-homepage.png" alt="">
                    </div>
                    <div class="one-tool__bottom">
                        <div class="one-tool__bottom-inner">

                        </div>
                        <div class="one-tool__heading">
                            phind
                            <img width="24px" height="24px" src="<?php echo get_siteefy_home_url(); ?>wp-content/plugins/siteefy/assets/verified-icon.png" alt="Verified">
                        </div>
                        <div class="one-tool__description">
                            Phind is a powerful tool that helps developers find the answers they need quickly and easily.
                        </div>
                        <div class="one-tool__tags">
                            <div class="one-tool__task">
                                tasks
                            </div>
                            <div class="one-tool__price">
                                price
                            </div>
                        </div>
                    </div>
                </div>
                <div class="one-tool-item">
                    <div class="one-tool__upper">
                        <img src="https://wordpress-1021474-4844794.cloudwaysapps.com/wp-content/uploads/2024/07/Yuzzit-homepage.png" alt="">
                    </div>
                    <div class="one-tool__bottom">
                        <div class="one-tool__bottom-inner">

                        </div>
                        <div class="one-tool__heading">
                            phind
                            <img width="24px" height="24px" src="<?php echo get_siteefy_home_url(); ?>wp-content/plugins/siteefy/assets/verified-icon.png" alt="Verified">
                        </div>
                        <div class="one-tool__description">
                            Phind is a powerful tool that helps developers find the answers they need quickly and easily.
                        </div>
                        <div class="one-tool__tags">
                            <div class="one-tool__task">
                                tasks
                            </div>
                            <div class="one-tool__price">
                                price
                            </div>
                        </div>
                    </div>
                </div>
                <div class="one-tool-item">
                    <div class="one-tool__upper">
                        <img src="https://wordpress-1021474-4844794.cloudwaysapps.com/wp-content/uploads/2024/07/Yuzzit-homepage.png" alt="">
                    </div>
                    <div class="one-tool__bottom">
                        <div class="one-tool__bottom-inner">

                        </div>
                        <div class="one-tool__heading">
                            phind
                            <img width="24px" height="24px" src="<?php echo get_siteefy_home_url(); ?>wp-content/plugins/siteefy/assets/verified-icon.png" alt="Verified">
                        </div>
                        <div class="one-tool__description">
                            Phind is a powerful tool that helps developers find the answers they need quickly and easily.
                        </div>
                        <div class="one-tool__tags">
                            <div class="one-tool__task">
                                tasks
                            </div>
                            <div class="one-tool__price">
                                price
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="tasks-section">
    <div class="container">
        <h2>Solution <span class="highlight">blabla</span></h2>
        <p class="subtitle">They streamline workflows, improve decision-making, and help teams work more efficiently.</p>
        <div class="related-container">
            <div class="subheading">
                Top Solutions:
            </div>
            <div class="related-items">
                <div class="related-item">
                    🥇 Top-Rated
                </div>
                <div class="related-item">
                    📋 Project Management
                </div>
                <div class="related-item">
                    👫 Team Collaboration
                </div>
                <div class="related-item">
                    📒 Task Tracking
                </div>
                <div class="related-item">
                    📧 Web Hosting
                </div>
                <div class="related-item">
                    📃 Writing & Content
                </div>
            </div>
            <div class="tools-collection-container">
                <div class="one-tool-item">
                    <div class="one-tool__upper">
                        <img src="https://wordpress-1021474-4844794.cloudwaysapps.com/wp-content/uploads/2024/07/Yuzzit-homepage.png" alt="">
                    </div>
                    <div class="one-tool__bottom">
                        <div class="one-tool__bottom-inner">

                        </div>
                        <div class="one-tool__heading">
                            phind
                            <img width="24px" height="24px" src="<?php echo get_siteefy_home_url(); ?>wp-content/plugins/siteefy/assets/verified-icon.png" alt="Verified">
                        </div>
                        <div class="one-tool__description">
                            Phind is a powerful tool that helps developers find the answers they need quickly and easily.
                        </div>
                        <div class="one-tool__tags">
                            <div class="one-tool__task">
                                tasks
                            </div>
                            <div class="one-tool__price">
                                price
                            </div>
                        </div>
                    </div>
                </div>
                <div class="one-tool-item">
                    <div class="one-tool__upper">
                        <img src="https://wordpress-1021474-4844794.cloudwaysapps.com/wp-content/uploads/2024/07/Yuzzit-homepage.png" alt="">
                    </div>
                    <div class="one-tool__bottom">
                        <div class="one-tool__bottom-inner">

                        </div>
                        <div class="one-tool__heading">
                            phind
                            <img width="24px" height="24px" src="<?php echo get_siteefy_home_url(); ?>wp-content/plugins/siteefy/assets/verified-icon.png" alt="Verified">
                        </div>
                        <div class="one-tool__description">
                            Phind is a powerful tool that helps developers find the answers they need quickly and easily.
                        </div>
                        <div class="one-tool__tags">
                            <div class="one-tool__task">
                                tasks
                            </div>
                            <div class="one-tool__price">
                                price
                            </div>
                        </div>
                    </div>
                </div>
                <div class="one-tool-item">
                    <div class="one-tool__upper">
                        <img src="https://wordpress-1021474-4844794.cloudwaysapps.com/wp-content/uploads/2024/07/Yuzzit-homepage.png" alt="">
                    </div>
                    <div class="one-tool__bottom">
                        <div class="one-tool__bottom-inner">

                        </div>
                        <div class="one-tool__heading">
                            phind
                            <img width="24px" height="24px" src="<?php echo get_siteefy_home_url(); ?>wp-content/plugins/siteefy/assets/verified-icon.png" alt="Verified">
                        </div>
                        <div class="one-tool__description">
                            Phind is a powerful tool that helps developers find the answers they need quickly and easily.
                        </div>
                        <div class="one-tool__tags">
                            <div class="one-tool__task">
                                tasks
                            </div>
                            <div class="one-tool__price">
                                price
                            </div>
                        </div>
                    </div>
                </div>
                <div class="one-tool-item">
                    <div class="one-tool__upper">
                        <img src="https://wordpress-1021474-4844794.cloudwaysapps.com/wp-content/uploads/2024/07/Yuzzit-homepage.png" alt="">
                    </div>
                    <div class="one-tool__bottom">
                        <div class="one-tool__bottom-inner">

                        </div>
                        <div class="one-tool__heading">
                            phind
                            <img width="24px" height="24px" src="<?php echo get_siteefy_home_url(); ?>wp-content/plugins/siteefy/assets/verified-icon.png" alt="Verified">
                        </div>
                        <div class="one-tool__description">
                            Phind is a powerful tool that helps developers find the answers they need quickly and easily.
                        </div>
                        <div class="one-tool__tags">
                            <div class="one-tool__task">
                                tasks
                            </div>
                            <div class="one-tool__price">
                                price
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

