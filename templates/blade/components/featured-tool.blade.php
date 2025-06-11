<div class="row-top-tool">
    <div class="tab-tool full {{ !isset($margin) && !$margin ? 'margin' : '' }}">
        <div class="tag">
            🔥 Tool of the Week </div>
        <div class="tab-tool__inner">
{{--            <div class="featured-tool__title">Tool of the Week</div>--}}

            <img class="tab-tool__image" src="{{siteefy_get_field('tool_image',$tool_of_the_week->ID)}}" alt="tool image">
            <div class="tab-tool__top">
                <div class="tab-tool__heading">
                    {{siteefy_get_field('tool_name',$tool_of_the_week->ID)}}
                </div>
                <img width="18px" height="18px" src="{{ get_siteefy_home_url() . '/wp-content/plugins/siteefy/assets/verified-icon.png'}}" alt="Verified">
            </div>
            <div class="tab-tool__description">
                {{siteefy_get_field('tool_description', $tool_of_the_week->ID)}}
            </div>
            <div class="one-tool__tags">
                <a href="{{get_solution_link_by_tool_id($tool_of_the_week->ID)}}" class="one-tool__task">
                    <?php echo get_solution_name_by_tool_id($tool_of_the_week->ID); ?>
                </a>
            </div>
            <a class="get-featured-link" href="https://siteefy.com/get-featured/" target="_blank">Get Featured</a>
        </div>
{{--        <svg class="pin" xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 22 22" fill="none">--}}
{{--            <path d="M0 0H17C19.7614 0 22 2.23858 22 5V22L0 0Z" fill="#FFDA10"></path>--}}
{{--        </svg>--}}
        <a class="tool-item__link" href="{{siteefy_get_field('tool_review_link', $tool_of_the_week->ID)}}"></a>
    </div>
</div>
