<?php

$element_id = 31719; // Replace with your Hook Element's ID
$element = get_post($element_id);

if ($element) {
    echo apply_filters('the_content', $element->post_content);
}
?>
<style>
    @media (max-width: 1024px) {
        .gb-grid-wrapper.gb-grid-wrapper-8ebb59b1 {
            display: none;
        }
    }
    @media (min-width: 1024px) {
        .gb-grid-wrapper.gb-grid-wrapper-bbde284a {
            display: none;
        }
    }
</style>
