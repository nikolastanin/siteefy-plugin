<div class="tabs-container">
    <div class="tabs-switcher__container">
        @foreach($categories as $cat)
            <div class="rounded-tab left {{ $loop->first ? '' : 'colored' }}"  data-id="{{$cat->term_id}}">
                {{$cat->name}}
            </div>
        @endforeach
    </div>
    @foreach($tools_by_category as $key=>$single_tools_collection)
        <div class="tab" style="{{ $loop->first ? '' : 'display:none;' }}" data-tab-id="{{$key}}">
            <div class="tab-inner">
                <div class="tab-tools__container">
                    @foreach($single_tools_collection as $tool)
                        <div class="tab-tool">
                            <div class="tab-tool__inner">
                                <div class="tab-tool__top">
                                    <img class="tab-tool__image" src="<?php siteefy_get_field('tool_image', $tool->ID); ?>" alt="tool image">
                                    <div class="tab-tool__heading">
                                        <?php siteefy_get_field('tool_name', $tool->ID); ?>
                                    </div>
                                    <img width="18px" height="18px" src="<?php echo get_siteefy_home_url(); ?>wp-content/plugins/siteefy/assets/verified-icon.png" alt="Verified">
                                </div>
                                <div class="tab-tool__description">
                                    {{ get_tool_description($tool->ID) }}
                                </div>
                                <div class="tab-tool__rating">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="11" height="12" viewBox="0 0 11 12" fill="none">
                                        <path d="M2.86 6.40777V11.0886H8.58V6.40777H11L5.5 0.088623L0 6.40777H2.86Z" fill="#029D24"/>
                                    </svg>
                                    {{siteefy_get_field('tool_rating', $tool->ID)}}
                                </div>
                            </div>
                            <div class="tab-tool__inner-mobile">
                                <img class="tab-tool__image" src="<?php siteefy_get_field('tool_image', $tool->ID); ?>" alt="tool image">
                                <div class="tab-tool__right">
                                    <div class="tab-tool__right-top">
                                        <div class="tab-tool__heading">
                                            <?php siteefy_get_field('tool_name', $tool->ID); ?>
                                        </div>
                                        <img width="18px" height="18px" src="<?php echo get_siteefy_home_url(); ?>wp-content/plugins/siteefy/assets/verified-icon.png" alt="Verified">
                                        <div class="tab-tool__rating">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="11" height="12" viewBox="0 0 11 12" fill="none">
                                                <path d="M2.86 6.40777V11.0886H8.58V6.40777H11L5.5 0.088623L0 6.40777H2.86Z" fill="#029D24"/>
                                            </svg>
                                            {{siteefy_get_field('tool_rating', $tool->ID)}}
                                        </div>
                                    </div>
                                    <div class="tab-tool__description">
                                        {{ get_tool_description($tool->ID) }}
                                    </div>
                                </div>
                            </div>

                            <a class="tool-item__link" href="{{siteefy_get_field('tool_review_link', $tool->ID)}}"></a>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endforeach
</div>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const tabs = document.querySelectorAll(".rounded-tab");
        const tabContents = document.querySelectorAll(".tab");

        tabs.forEach(tab => {
            tab.addEventListener("click", function () {
                const tabId = this.getAttribute("data-id");

                // Remove "colored" class from all tabs and add it only to the clicked one
                tabs.forEach(t => t.classList.add("colored"));
                this.classList.toggle("colored", !this.classList.contains("colored"));

                // Hide all tab contents
                tabContents.forEach(content => content.style.display = "none");

                // Show the corresponding tab if it exists
                const targetTab = document.querySelector(`.tab[data-tab-id="${tabId}"]`);
                if (targetTab) {
                    targetTab.style.display = "block";
                }
            });
        });
    });


</script>