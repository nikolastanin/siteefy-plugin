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
                    <a href="{{get_solution_link_by_tool_id($tool->ID)}}" class="tool-item__solution-name">
                        <?php echo get_solution_name_by_tool_id($tool->ID, true); ?>
                    </a>
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