<?php
//ajax


function siteefy_ajax_handler() {
    wp_send_json_success( 'It works' .$_GET['searchQuery'] );
}

add_action( 'wp_ajax_nopriv_get_data', 'siteefy_ajax_handler' );
add_action( 'wp_ajax_get_data', 'siteefy_ajax_handler' );


function get_search_results_inline(){
    $search_term = $_GET['searchQuery'];
    $results = get_tools_and_tasks_by_search_term($search_term);
    if($results){
        $html = generate_html_for_results($results, $search_term);
        wp_send_json_success( $html );
    }else{
        wp_send_json_error('fault');
    }
}
add_action( 'wp_ajax_nopriv_get_search_results_inline', 'get_search_results_inline' );
add_action( 'wp_ajax_get_search_results_inline', 'get_search_results_inline' );

function generate_html_for_results($results, $search_term) {
    $cache_key = $search_term . '_html';
    $html = get_transient($cache_key);
    if(!$html){
        // Check if 'filtered_tasks' and 'filtered_tools' exist in the results array
        $tasks = array_key_exists('filtered_tasks', $results) ? $results['filtered_tasks'] : false;
        $tools = array_key_exists('filtered_tools', $results) ? $results['filtered_tools'] : false;

        // Start building the HTML output
        $html_output = '<div class="popup-search-results__container">';

        // Tasks Section
        if ($tasks && is_array($tasks)) {
            $html_output .= '<div id="popup-tasks-group">
                    <div class="popup-search-result__header header">
                        📝 Tasks <span id="popup-tasks-count">(' . count($tasks) . ')</span>
                    </div>
                    <div class="popup-search-results-group">';

            // Loop through each task (WP_Post object) and add it to the HTML
            foreach ($tasks as $task) {
                $html_output .= '<a href="' . esc_url(get_permalink($task)) . '" class="search-result__item">
                                    <span>' . esc_html(get_the_title($task)) . '</span>
                                     <div class="search-results__icon small">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="15" height="13" viewBox="0 0 15 13" fill="none">
                                            <path d="M8 1L14 6.5L8 12" stroke="#0880EC" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                            <path d="M13 6.5L1 6.5" stroke="#0980ED" stroke-width="1.5" stroke-linecap="round"></path>
                                        </svg>
                                       </div>
                                 </a>';
            }

            $html_output .= '</div></div>';
        }

        // Tools Section
        if ($tools && is_array($tools)) {
            $html_output .= '<div id="popup-tools-group">
                    <div class="popup-search-result__header header">
                        📝 Tools <span id="popup-tools-count">(' . count($tools) . ')</span>
                    </div>
                    <div class="popup-search-results-group">';

            // Loop through each tool (WP_Post object) and add it to the HTML
            foreach ($tools as $tool) {
                $url_of_tool = is_array(get_field('tool_review_link', $tool->ID)) && array_key_exists('url', get_field('tool_review_link', $tool->ID)) ? get_field('tool_review_link', $tool->ID)['url'] : '';
                $html_output .= '<a href="' . $url_of_tool . '" class="search-result__item">
                                    <span>' . esc_html(get_the_title($tool)) . '</span>
                                 <div class="search-results__icon small">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="15" height="13" viewBox="0 0 15 13" fill="none">
                                            <path d="M8 1L14 6.5L8 12" stroke="#0880EC" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                            <path d="M13 6.5L1 6.5" stroke="#0980ED" stroke-width="1.5" stroke-linecap="round"></path>
                                        </svg>
                                       </div>
                                 </a>';
            }

            $html_output .= '</div></div>';
        }

        // Close the container div
        $html_output .= '</div>';
        $html = $html_output;
        set_transient($cache_key, $html, 1);
    }
    // Return the generated HTML
    return $html;
}

