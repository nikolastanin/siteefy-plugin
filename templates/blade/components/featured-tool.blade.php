<div class="row-top-tool">
    <div class="tab-tool full">
        <div class="tab-tool__inner">
            <div class="tab-tool__top">
                <img class="tab-tool__image" src="{{siteefy_get_field('tool_image',$tool_of_the_week->ID)}}" alt="tool image">
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
        </div>
        <a class="tool-item__link" href="{{siteefy_get_field('tool_review_link', $tool_of_the_week->ID)}}"></a>
    </div>
</div>
