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
        @endforeach
    </div>
@endforeach
<div class="button-container">
    <a class="show-more__btn" href="<?php echo get_siteefy_home_url('/tasks');?>">view more</a>
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
