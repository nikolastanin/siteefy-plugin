<section class="tool-of-the-week">
    <div class="container">
        <h2 class="tool-of-the-week__heading">
            Tool of the <span class="highlight">week:</span>
        </h2>
        <p class="subtitle">
            Sometimes a tool catches our attention so we highlight it to the users.
        </p>
        <div class="tool-of-the-week-item">
            <img class="tool-of-the-week__image" src="<?php siteefy_get_field('tool_image',$tool_of_the_week->ID); ?>" alt="tool of the week image">
            <div class="tool-of-the-week__details">
                <div class="tool-of-the-week__title">
                    <?php siteefy_get_field('tool_name',$tool_of_the_week->ID); ?>
                    <img width="32px" height="32px" src="<?php echo get_siteefy_home_url(); ?>wp-content/plugins/siteefy/assets/verified-icon.png" alt="Verified">
                </div>
                <div class="tool-of-the-week__description">
                    {{$choosen_tool_text['tool_of_the_week_text']}}
                </div>
                <div class="tool-of-the-week__left-bottom unset-width">
                    @foreach($solutions as $solution)
                        <a href="{{get_term_link($solution)}}" class="popular-task-item__category">{{$solution->name}} </a>
                    @endforeach
                </div>
                <div class="tool-of-the-week__price">
                    {{ siteefy_get_field('tool_price', $tool_of_the_week->ID) }}
                </div>

            </div>
            <svg class="pin" xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 22 22" fill="none">
                <path d="M0 0H17C19.7614 0 22 2.23858 22 5V22L0 0Z" fill="#FFDA10"/>
            </svg>
            <a class="tool-item__link" href="{{siteefy_get_field('tool_review_link', $tool_of_the_week->ID)}}"></a>
        </div>
    </div>
</section>