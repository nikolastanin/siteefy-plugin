<div class="one-tool-item w-50">
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
            <a href="{{get_solution_link_by_tool_id($tool->ID)}}" class="one-tool__task">
                <?php echo get_solution_name_by_tool_id($tool->ID); ?>
            </a>
            <div class="one-tool__price">
                <?php siteefy_get_field('tool_exact_price', $tool->ID); ?>
            </div>
        </div>
    </div>
    <a class="tool-item__link" href="{{siteefy_get_field('tool_review_link', $tool->ID)}}"></a>
</div>
