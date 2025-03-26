<?php
/**
 * Plugin Name:          Siteefy
 * Plugin URI:
 * Description:
 * Version: 1.4
 * Author:                 Nikola Stanin
 * Author URI:
 * License:
 * License URI:          https://www.gnu.org/licenses/gpl-3.0.html
 * Requires at least:
 * Requires PHP:         7.4
 * Text Domain:
 * Domain Path:
 * Plugin Dependencies:
 *  - Yoast SEO
 *  - Custom Post Type Permalinks (Version 3.5.2 by Toro_Unit)
 */

define( 'PN_PLUGIN_ROOT', plugin_dir_path( __FILE__ ) );
$plugin_name_libraries = require PN_PLUGIN_ROOT . 'vendor/autoload.php'; //phpcs:ignore

defined('ABSPATH') || exit;
require_once  WP_PLUGIN_DIR . '/siteefy/blade.php';
require_once  WP_PLUGIN_DIR . '/siteefy/settings.php';
require_once  WP_PLUGIN_DIR . '/siteefy/solutions.php';
require_once  WP_PLUGIN_DIR . '/siteefy/category.php';
require_once  WP_PLUGIN_DIR . '/siteefy/functions.php';
require_once  WP_PLUGIN_DIR . '/siteefy/ajax.php';
require_once  WP_PLUGIN_DIR . '/siteefy/shortcodes.php';


// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Check for Yoast SEO plugin
function siteefy_check_dependencies() {
    if ( ! is_plugin_active( 'wordpress-seo/wp-seo.php' ) ) {
        // Yoast SEO plugin is not active
        add_action( 'admin_notices', 'siteefy_missing_cpt_permalink_notice' );
        return;
    }

    // Check for Custom Post Type Permalinks plugin (version 3.5.2)
    if ( !is_plugin_active( 'custom-post-type-permalinks/custom-post-type-permalinks.php' )  ) {
        // Custom Post Type Permalinks plugin is not active or wrong version
        add_action( 'admin_notices', 'siteefy_missing_cpt_permalink_notice' );
        return;
    }

    // Your plugin logic goes here if dependencies are met
}
add_action( 'admin_init', 'siteefy_check_dependencies' );

// Show admin notice if Custom Post Type Permalinks plugin is missing or wrong version
function siteefy_missing_cpt_permalink_notice() {
    echo '<div class="error"><p><strong>Siteefy plugin</strong> requires <strong>Custom Post Type Permalinks</strong> & Yoast SEO  plugin to be installed and activated. Please install or update it.</p></div>';
}

/**
 * Register a custom post type called "Tool".
 *
 * @see get_post_type_labels() for label keys.
 */
function siteefy_tool_init() {
    $labels = array(
        'name'                  => _x( 'Tool', 'Post type general name', 'textdomain' ),
        'singular_name'         => _x( 'Tool', 'Post type singular name', 'textdomain' ),
        'menu_name'             => _x( 'Tools', 'Admin Menu text', 'textdomain' ),
        'name_admin_bar'        => _x( 'Tool', 'Add New on Toolbar', 'textdomain' ),
        'add_new'               => __( 'Add New', 'textdomain' ),
        'add_new_item'          => __( 'Add New Tool', 'textdomain' ),
        'new_item'              => __( 'New Tool', 'textdomain' ),
        'edit_item'             => __( 'Edit Tool', 'textdomain' ),
        'view_item'             => __( 'View Tool', 'textdomain' ),
        'all_items'             => __( 'All Tools', 'textdomain' ),
        'search_items'          => __( 'Search Tools', 'textdomain' ),
        'parent_item_colon'     => __( 'Parent Tools:', 'textdomain' ),
        'not_found'             => __( 'No Tools found.', 'textdomain' ),
        'not_found_in_trash'    => __( 'No Tools found in Trash.', 'textdomain' ),
        'featured_image'        => _x( 'Tool Cover Image', 'Overrides the “Featured Image” phrase for this post type. Added in 4.3', 'textdomain' ),
        'set_featured_image'    => _x( 'Set cover image', 'Overrides the “Set featured image” phrase for this post type. Added in 4.3', 'textdomain' ),
        'remove_featured_image' => _x( 'Remove cover image', 'Overrides the “Remove featured image” phrase for this post type. Added in 4.3', 'textdomain' ),
        'use_featured_image'    => _x( 'Use as cover image', 'Overrides the “Use as featured image” phrase for this post type. Added in 4.3', 'textdomain' ),
        'archives'              => _x( 'Tool archives', 'The post type archive label used in nav menus. Default “Post Archives”. Added in 4.4', 'textdomain' ),
        'insert_into_item'      => _x( 'Insert into Tool', 'Overrides the “Insert into post”/”Insert into page” phrase (used when inserting media into a post). Added in 4.4', 'textdomain' ),
        'uploaded_to_this_item' => _x( 'Uploaded to this Tool', 'Overrides the “Uploaded to this post”/”Uploaded to this page” phrase (used when viewing media attached to a post). Added in 4.4', 'textdomain' ),
        'filter_items_list'     => _x( 'Filter Tools list', 'Screen reader text for the filter links heading on the post type listing screen. Default “Filter posts list”/”Filter pages list”. Added in 4.4', 'textdomain' ),
        'items_list_navigation' => _x( 'Tools list navigation', 'Screen reader text for the pagination heading on the post type listing screen. Default “Posts list navigation”/”Pages list navigation”. Added in 4.4', 'textdomain' ),
        'items_list'            => _x( 'Tools list', 'Screen reader text for the items list heading on the post type listing screen. Default “Posts list”/”Pages list”. Added in 4.4', 'textdomain' ),
    );

    $args = array(
        'labels'             => $labels,
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'            => array(
            'slug'       => 'tools', // No fixed slug
            'with_front' => false,
        ),
        "cptp_permalink_structure" => "/%solution%/%postname%/",
        'capability_type'    => 'post',
        'has_archive'        => true,
        'hierarchical'       => false,
        'menu_position'      => 53,
        'menu_icon' => 'dashicons-admin-tools',
        'supports'           => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments' ),
    );

    register_post_type( 'tool', $args );
}
add_action( 'init', 'siteefy_tool_init' );



function siteefy_add_options_menu() {
    add_menu_page(
        'Siteefy Options',
        'Siteefy Options',
        'read',
        'siteefy-options',
        'siteefy_options_menu',
        'dashicons-admin-site',
        50 // Position
    );
    add_submenu_page( 'siteefy-options', 'Siteefy Options', 'Siteefy Options',
        'manage_options', 'siteefy-options','', '0');
    add_submenu_page('siteefy-options', 'Tool of the week', 'Tool of the Week', 'manage_options', 'tool-of-the-week', 'siteefy_central_menu', '5');
}

add_action( 'admin_menu', 'siteefy_add_options_menu' );


function siteefy_options_menu(){
    echo '<h1>Siteefy Options. </h1>';
    echo '<a class="btn button" href="admin.php?page=tool-of-the-week">Tool of the week - settings</a>';
}


function siteefy_add_admin_styles($hook) {
    wp_enqueue_style( 'admin_styles_siteefy', plugins_url('/admin/style.css', __FILE__), [], time() );
}
add_action( 'admin_enqueue_scripts', 'siteefy_add_admin_styles' );

function siteefy_central_menu() {
    // Get all tools (posts)
    $tools = get_all_tools();

    // Check if the form is submitted
    if (isset($_POST['submit_tool_of_the_week'])) {
        $selected_tool_id = intval($_POST['tool_of_the_week']);
        $tool_of_the_week_text = sanitize_text_field($_POST['tool_of_the_week_text']);

        // Save the selected tool and text as options in the wp_options table
        update_option('tool_of_the_week', $selected_tool_id);
        update_option('tool_of_the_week_text', $tool_of_the_week_text);
    }

    // Get the currently saved tool of the week and text
    $current_tool = get_option('tool_of_the_week', 0);
    $current_tool_text = get_option('tool_of_the_week_text', '');

    ?>
    <form method="POST">
        <label for="tool_of_the_week">Select Tool of the Week:</label>
        <select id="tool_of_the_week" name="tool_of_the_week">
            <option value="">-- Select a Tool --</option>
            <?php foreach ($tools as $tool): ?>
                <option value="<?php echo $tool->ID; ?>" <?php selected($current_tool, $tool->ID); ?>>
                    <?php echo esc_html($tool->post_title); ?>
                </option>
            <?php endforeach; ?>
        </select>
        <br><br>

        <label for="tool_of_the_week_text">Tool of the Week Text:</label>
        <textarea style="width: 100%;height: 150px;" type="text" id="tool_of_the_week_text" name="tool_of_the_week_text" value="<?php echo esc_attr($current_tool_text); ?>"><?php echo esc_attr($current_tool_text); ?></textarea>
        <br><br>

        <button type="submit" class="button btn" name="submit_tool_of_the_week">Save</button>
    </form>
    <?php
}

function get_selected_tool_of_the_week(){
    $choosen_tool = get_options(array('tool_of_the_week'));
    if(array_key_exists('tool_of_the_week',$choosen_tool)){
        return get_post($choosen_tool['tool_of_the_week']);
    }
}

function get_selected_tool_of_the_week_text(){
    $choosen_tool_text = get_options(array('tool_of_the_week_text'));
    if(array_key_exists('tool_of_the_week_text',$choosen_tool_text)){
        return get_post($choosen_tool_text['tool_of_the_week_text']);
    }
}
function wpdocs_register_my_custom_submenu_page() {
    add_submenu_page(
        'siteefy-options',
        'Tools',
        'Tools',
        'manage_options',
        'tools',
        'tools_custom_submenu_page_callback',
    );
}
function tools_custom_submenu_page_callback(){
    $site_url = get_site_url();
    echo '<a class="button button-primary2" href="' . $site_url . '/wp-admin/edit.php?post_type=tool">View all Tools</a>';
    echo '<a class="button button-primary2" href="' . $site_url . '/wp-admin/edit-tags.php?taxonomy=tool_categories">View all Tools > Categories</a>';
}

/**
 * Register a custom post type called "Task".
 *
 * @see get_post_type_labels() for label keys.
 */
function siteefy_task__init() {
    $labels = array(
        'name'                  => _x( 'Task', 'Post type general name', 'textdomain' ),
        'singular_name'         => _x( 'Task', 'Post type singular name', 'textdomain' ),
        'menu_name'             => _x( 'Tasks', 'Admin Menu text', 'textdomain' ),
        'name_admin_bar'        => _x( 'Task', 'Add New on Taskbar', 'textdomain' ),
        'add_new'               => __( 'Add New', 'textdomain' ),
        'add_new_item'          => __( 'Add New Task', 'textdomain' ),
        'new_item'              => __( 'New Task', 'textdomain' ),
        'edit_item'             => __( 'Edit Task', 'textdomain' ),
        'view_item'             => __( 'View Task', 'textdomain' ),
        'all_items'             => __( 'All Tasks', 'textdomain' ),
        'search_items'          => __( 'Search Tasks', 'textdomain' ),
        'parent_item_colon'     => __( 'Parent Tasks:', 'textdomain' ),
        'not_found'             => __( 'No Tasks found.', 'textdomain' ),
        'not_found_in_trash'    => __( 'No Tasks found in Trash.', 'textdomain' ),
        'featured_image'        => _x( 'Task Cover Image', 'Overrides the “Featured Image” phrase for this post type. Added in 4.3', 'textdomain' ),
        'set_featured_image'    => _x( 'Set cover image', 'Overrides the “Set featured image” phrase for this post type. Added in 4.3', 'textdomain' ),
        'remove_featured_image' => _x( 'Remove cover image', 'Overrides the “Remove featured image” phrase for this post type. Added in 4.3', 'textdomain' ),
        'use_featured_image'    => _x( 'Use as cover image', 'Overrides the “Use as featured image” phrase for this post type. Added in 4.3', 'textdomain' ),
        'archives'              => _x( 'Task archives', 'The post type archive label used in nav menus. Default “Post Archives”. Added in 4.4', 'textdomain' ),
        'insert_into_item'      => _x( 'Insert into Task', 'Overrides the “Insert into post”/”Insert into page” phrase (used when inserting media into a post). Added in 4.4', 'textdomain' ),
        'uploaded_to_this_item' => _x( 'Uploaded to this Task', 'Overrides the “Uploaded to this post”/”Uploaded to this page” phrase (used when viewing media attached to a post). Added in 4.4', 'textdomain' ),
        'filter_items_list'     => _x( 'Filter Tasks list', 'Screen reader text for the filter links heading on the post type listing screen. Default “Filter posts list”/”Filter pages list”. Added in 4.4', 'textdomain' ),
        'items_list_navigation' => _x( 'Tasks list navigation', 'Screen reader text for the pagination heading on the post type listing screen. Default “Posts list navigation”/”Pages list navigation”. Added in 4.4', 'textdomain' ),
        'items_list'            => _x( 'Tasks list', 'Screen reader text for the items list heading on the post type listing screen. Default “Posts list”/”Pages list”. Added in 4.4', 'textdomain' ),
    );

    $args = array(
        'labels'             => $labels,
        'public'             => 'true',
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'            => array(
            'slug'       => 'tasks', // No fixed slug
            'with_front' => false,
        ),
        "cptp_permalink_structure" => "/%category%/%postname%/",
        'capability_type'    => 'post',
        'has_archive'        => true,
        'hierarchical'       => false,
        'menu_position'      => 52,
        'supports'           => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments' ),
    );
    register_post_type( 'task', $args );
    // Register the taxonomy
    register_taxonomy('category', array('task', 'tool','page', 'post'), array(
        'label'             => 'Categories',
        'hierarchical'      => true,
        'rewrite'           => array('slug' => 'category'),
        'public' => true,
    ));
    register_taxonomy('solution', array('task', 'tool'), array(
        'labels' => array(
            'name'              => 'Solutions',
            'singular_name'     => 'Solution',
            'menu_name'         => 'Solutions',
            'all_items'         => 'All Solutions',
            'edit_item'         => 'Edit Solution',
            'view_item'         => 'View Solution',
            'update_item'       => 'Update Solution',
            'add_new_item'      => 'Add New Solution',
            'new_item_name'     => 'New Solution Name',
            'parent_item'       => 'Parent Solution',
            'parent_item_colon' => 'Parent Solution:',
            'search_items'      => 'Search Solutions',
            'not_found'         => 'No Solutions found.',
        ),
        'hierarchical'      => true,
        'rewrite'           => array('slug' => 'solution'),
        'public'            => true,
        'show_ui'           => true,
        'show_admin_column' => true,
        'query_var'         => true,
    ));

}
add_action( 'init', 'siteefy_task__init' );


//function modify_category_route($q){
//    if ($q->is_main_query() && !is_admin() && $q->is_single){
////        $q->set( 'post_type',  array_merge(array('post'), array('page', 'task'))   );
//    }
//    return $q;
//}
//add_action('pre_get_posts', 'modify_category_route',  12);

function custom_task_permalink($permalink, $post) {
    if ($post->post_type === 'task') {
        $terms = get_the_terms($post->ID, 'category');

        if (!empty($terms) && !is_wp_error($terms)) {
            // Check for Yoast SEO primary term
            $primary_term_id = get_post_meta($post->ID, '_yoast_wpseo_primary_category', true);

            if ($primary_term_id) {
                $primary_term = get_term($primary_term_id);
                if ($primary_term && !is_wp_error($primary_term)) {
                    return home_url('/' . $primary_term->slug . '/' . $post->post_name . '/');
                }
            }

            // Fallback: Use first term
            $category_slug = $terms[0]->slug;
            return home_url('/' . $category_slug . '/' . $post->post_name . '/');
        }
    }
    return $permalink;
}
add_filter('post_type_link', 'custom_task_permalink', 10, 2);


function custom_solution_permalink($permalink, $post) {
    if ($post->post_type === 'tool') {
        $terms = get_the_terms($post->ID, 'solution');

        if (!empty($terms) && !is_wp_error($terms)) {
            // Check for Yoast SEO primary term
            $primary_term_id = get_post_meta($post->ID, '_yoast_wpseo_primary_solution', true);

            if ($primary_term_id) {
                $primary_term = get_term($primary_term_id);
                if ($primary_term && !is_wp_error($primary_term)) {
                    return home_url('/' . $primary_term->slug . '/' . $post->post_name . '/');
                }
            }

            // Fallback: Use the first term if no primary term is set
            $category_slug = $terms[0]->slug;
            return home_url('/' . $category_slug . '/' . $post->post_name . '/');
        }
    }
    return $permalink;
}
add_filter('post_type_link', 'custom_solution_permalink', 10, 2);

function custom_task_rewrite_rules() {
    $categories = get_terms(array(
        'taxonomy'   => 'category',
        'hide_empty' => false, // Include all categories
    ));

    if (!is_wp_error($categories) && !empty($categories)) {
        foreach ($categories as $category) {
            add_rewrite_rule(
                '^' . $category->slug . '/([^/]+)/?$',
                'index.php?post_type=task&name=$matches[1]',
                'top'
            );
        }
    }
}
add_action('init', 'custom_task_rewrite_rules');



function add_task_query_vars($query_vars) {
    $query_vars[] = 'task';
    return $query_vars;
}
add_filter('query_vars', 'add_task_query_vars');


function custom_solution_rewrite_rules() {
    $categories = get_terms(array(
        'taxonomy'   => 'solution',
        'hide_empty' => false, // Include all categories
    ));

    if (!is_wp_error($categories) && !empty($categories)) {
        foreach ($categories as $category) {
            add_rewrite_rule(
                '^' . $category->slug . '/([^/]+)/?$',
                'index.php?post_type=tool&name=$matches[1]',
                'top'
            );
        }
    }
}
add_action('init', 'custom_solution_rewrite_rules');

function add_custom_query_vars($query_vars) {
    $query_vars[] = 'tool';
    return $query_vars;
}
add_filter('query_vars', 'add_custom_query_vars');

/**
 * Register a custom post type called "Article".
 *
 * @see get_post_type_labels() for label keys.
 */
function siteefy_article__init() {
    $labels = array(
        'name'                  => _x( 'Articles', 'Post type general name', 'textdomain' ),
        'singular_name'         => _x( 'Article', 'Post type singular name', 'textdomain' ),
        'menu_name'             => _x( 'Articles', 'Admin Menu text', 'textdomain' ),
        'name_admin_bar'        => _x( 'Article', 'Add New on Toolbar', 'textdomain' ),
        'add_new'               => __( 'Add New', 'textdomain' ),
        'add_new_item'          => __( 'Add New Article', 'textdomain' ),
        'new_item'              => __( 'New Article', 'textdomain' ),
        'edit_item'             => __( 'Edit Article', 'textdomain' ),
        'view_item'             => __( 'View Article', 'textdomain' ),
        'all_items'             => __( 'All Articles', 'textdomain' ),
        'search_items'          => __( 'Search Articles', 'textdomain' ),
        'parent_item_colon'     => __( 'Parent Articles:', 'textdomain' ),
        'not_found'             => __( 'No articles found.', 'textdomain' ),
        'not_found_in_trash'    => __( 'No articles found in Trash.', 'textdomain' ),
        'featured_image'        => _x( 'Article Cover Image', 'Overrides the “Featured Image” phrase for this post type. Added in 4.3', 'textdomain' ),
        'set_featured_image'    => _x( 'Set cover image', 'Overrides the “Set featured image” phrase for this post type. Added in 4.3', 'textdomain' ),
        'remove_featured_image' => _x( 'Remove cover image', 'Overrides the “Remove featured image” phrase for this post type. Added in 4.3', 'textdomain' ),
        'use_featured_image'    => _x( 'Use as cover image', 'Overrides the “Use as featured image” phrase for this post type. Added in 4.3', 'textdomain' ),
        'archives'              => _x( 'Article archives', 'The post type archive label used in nav menus. Default “Post Archives”. Added in 4.4', 'textdomain' ),
        'insert_into_item'      => _x( 'Insert into Article', 'Overrides the “Insert into post”/”Insert into page” phrase (used when inserting media into a post). Added in 4.4', 'textdomain' ),
        'uploaded_to_this_item' => _x( 'Uploaded to this Article', 'Overrides the “Uploaded to this post”/”Uploaded to this page” phrase (used when viewing media attached to a post). Added in 4.4', 'textdomain' ),
        'filter_items_list'     => _x( 'Filter articles list', 'Screen reader text for the filter links heading on the post type listing screen. Default “Filter posts list”/”Filter pages list”. Added in 4.4', 'textdomain' ),
        'items_list_navigation' => _x( 'Articles list navigation', 'Screen reader text for the pagination heading on the post type listing screen. Default “Posts list navigation”/”Pages list navigation”. Added in 4.4', 'textdomain' ),
        'items_list'            => _x( 'Articles list', 'Screen reader text for the items list heading on the post type listing screen. Default “Posts list”/”Pages list”. Added in 4.4', 'textdomain' ),
    );

    $args = array(
        'labels'             => $labels,
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true, // Attach CPT menu under the Siteefy Options menu
        'query_var'          => true,
        'rewrite'            => array(
            'slug'       => 'tools', // No fixed slug
            'with_front' => false,
        ),
        "cptp_permalink_structure" => "/%solution%/%postname%/",
        'capability_type'    => 'post',
        'has_archive'        => true,
        'hierarchical'       => false,
        'menu_position'      => 54,
        'supports'           => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments' ),
    );

//    register_post_type( 'article', $args );
}

add_action( 'init', 'siteefy_article__init' );

function siteefy_flush_permalinks(){
    flush_rewrite_rules();
}

function siteefy_activate_plugin(){
    siteefy_flush_permalinks();
}

function siteefy_deactivate_plugin(){
    siteefy_flush_permalinks();
}


/**
 * Load Template with Plugin
 */
function siteefy_add_page_template ($templates) {
    $templates['homepage-template.php'] = 'Homepage Template';
    return $templates;
}
add_filter ('theme_page_templates', 'siteefy_add_page_template');

function siteefy_redirect_page_template ($template) {
    $post = get_post();
    $page_template = get_post_meta( $post->ID, '_wp_page_template', true );
    if ('homepage-template.php' == basename ($page_template)) {
        $template = WP_PLUGIN_DIR . '/siteefy/templates/homepage-template.php';
        return $template;
    }
    return $template;
}
add_filter ('page_template', 'siteefy_redirect_page_template');


register_activation_hook(
    __FILE__,
    'siteefy_activate_plugin'
);

register_deactivation_hook(
    __FILE__,
    'siteefy_deactivate_plugin'
);

function siteefy_add_custom_templates($template) {
    global $post;
    $tools = get_tools_by_search_term();
    $tool_of_the_week = get_selected_tool_of_the_week();
    $related_items = get_all_categories(5);
    if (is_search()) {
        echo Siteefy::blade()->run('pages.search-template', [
            'page_title'=>'Search result',
            'page_subtitle' =>'Check out what we have for You!',
            'archive_title'=>$_GET['s'],
            'items'=>get_tools_by_search_term(),
            'term_name'=>'tools',
            'count' => count($tools),
            'archive_title'=>$_GET['s'],
            'related_title' => 'Related categories',
            'related_link'=>'/category',
            'related_items' =>$related_items,
            'tool_of_the_week'=>$tool_of_the_week,
        ]);
        exit;
    }elseif(is_single() && get_post_type($post) === 'task'){
        var_dump('helloe ');
        $tools = get_tools_by_task_id($post->ID);
        $tasks = get_all_tasks(5, $post->post_name);
        echo Siteefy::blade()->run('pages.single-cpt-template', [
            'page_title'=>ucfirst($post->post_title),
            'page_subtitle' =>false,
            'items' => $tools,
            'term_name'=>'task',
            'cpt'=>$post->post_type,
            'count' => count($tools),
            'archive_title'=>'Tasks',
            'related_title' => 'Related tasks',
            'related_link'=>'/tasks',
            'related_items' =>$tasks,
            'tool_of_the_week'=>$tool_of_the_week,
        ]);
        exit;
    }elseif(is_archive() && get_post_type($post) === 'task' && get_queried_object()->taxonomy !=='solution'){
        $tasks = get_all_tasks(-1);
        $categories = get_all_categories(5);
        $tool_of_the_week = get_selected_tool_of_the_week();
        echo Siteefy::blade()->run('pages.archive-cpt-template', [
            'page_title'=>false,
            'page_subtitle' =>false,
            'items' => $tasks,
            'term_name'=>'task',
            'count' => count($tasks),
            'archive_title'=>'Tasks',
            'related_title' => 'Related categories',
            'related_link'=>'/category',
            'related_items' =>$categories,
            'tool_of_the_week'=>$tool_of_the_week,
        ]);
        exit;
    }
    elseif(is_archive() && get_queried_object()->taxonomy === 'solution'){
        $term = get_queried_object();
        $taxonomy = $term->taxonomy;
        $solutions = get_all_solutions(5, $term->slug);
        $tools = get_cpt_posts_by_tax('tool', $taxonomy,$term->term_id);

        echo Siteefy::blade()->run('pages.single-tax-template', [
            'page_title'=>ucfirst($term->name),
            'page_subtitle' =>false,
            'items' => $tools,
            'term_name'=>'Solution',
            'count' => count($tools),
            'archive_title'=>$taxonomy,
            'related_title' => 'Related solutions',
            'related_link'=>'/solution',
            'related_items' =>$solutions,
            'term' => $term,
            'taxonomy'=>$taxonomy,
            'tool_of_the_week'=>$tool_of_the_week,
        ]);
        exit;

    }
    elseif(is_page() && strtolower(get_the_title())==='solution' ){
        //        todo:remove template .php file
        $solutions = get_all_solutions(-1);
        $categories = get_all_categories(5);
        $tool_of_the_week = get_selected_tool_of_the_week();
        echo Siteefy::blade()->run('pages.archive-template', [
                'page_title'=>false,
                'page_subtitle' =>false,
                'items' => $solutions,
                'term_name'=>'solution',
                'count' => count($solutions),
                'archive_title'=>'Solutions',
                'related_title' => 'Related categories',
                'related_link'=>'/category',
                'related_items' =>$categories,
                'tool_of_the_week'=>$tool_of_the_week,
        ]);
        exit;
    }
    elseif (is_page() && get_the_title()==='category') {
//        todo:remove template .php file
        $categories = get_all_categories(-1);
        $solutions = get_all_solutions(5);
        $tool_of_the_week = get_selected_tool_of_the_week();
        echo Siteefy::blade()->run('pages.archive-template', [
            'page_title'=>false,
            'page_subtitle' =>false,
            'items' => $categories,
            'term_name'=>'category',
            'count' => count($categories),
            'archive_title'=>'Categories',
            'related_title' => 'Related solutions',
            'related_link'=>'/solution',
            'related_items' =>$solutions,
            'tool_of_the_week'=>$tool_of_the_week,
        ]);
        exit;
    }elseif(is_archive() && get_queried_object()->taxonomy === 'category'){
        $term = get_queried_object();
        $taxonomy = $term->taxonomy;
        $categories = get_all_categories(5, $term->slug);
        $tools = get_cpt_posts_by_tax('tool', $taxonomy,$term->term_id);

        echo Siteefy::blade()->run('pages.single-tax-template', [
            'page_title'=>ucfirst($term->name),
            'page_subtitle' =>false,
            'items' => $tools,
            'term_name'=>'Category',
            'count' => count($tools),
            'archive_title'=>$taxonomy,
            'related_title' => 'Related categories',
            'related_link'=>'/category',
            'related_items' =>$categories,
            'term' => $term,
            'taxonomy'=>$taxonomy,
            'tool_of_the_week'=>$tool_of_the_week,
        ]);
        exit;

    }

    return $template;
}

add_filter('template_include', 'siteefy_add_custom_templates');


function siteefy_add_tool_backend_fields(){
    acf_add_local_field_group(array(
        'key' => 'tools_group',
        'title' => 'Tools Group',
        'fields' => array (
            array (
                'key' => 'tool_name',
                'label' => 'Name',
                'name' => 'tool_name',
                'type' => 'text',
                'required' => true,
            ),
            array (
                'key' => 'tool_exact_price',
                'label' => 'Exact Price Value',
                'name' => 'tool_exact_price',
                'type' => 'number',
                'required' => true,
                'instructions' =>'Numeric value of tool price per month, ex : $100. Set 0 - if free '
            ),
            array (
                'key' => 'tool_description',
                'label' => 'Short Description',
                'name' => 'tool_description',
                'type' => 'text',
                'required' => true,
                'instructions' =>'Short text description of the tool',
            ),
            array (
                'key' => 'tool_review_link',
                'label' => 'Review Link',
                'name' => 'tool_review_link',
                'type' => 'link',
                'required' =>true,
                'instructions' =>'Select a page where users will be redirected when they click on this tool. ',
            ),
            array (
                'key' => 'tool_rating',
                'label' => 'Rating',
                'name' => 'tool_rating',
                'type' => 'range',
                'min'=>0,
                'max'=>10,
                'step'=> '0.1',
                'required' => true,
            ),
            array (
                'key' => 'tool_price',
                'label' => 'Price description',
                'name' => 'tool_price',
                'type' => 'text',
                'instructions' =>'Subscription price of this tool - if empty will show as "free" on frontend. ',
                'required' => false,
            ),
            array (
                'key' => 'tool_is_featured',
                'label' => 'Is featured ?',
                'name' => 'tool_is_featured',
                'instructions' =>'Selecting this will highlight this tool in a blue border so its more visible to users.',
                'type' => 'true_false',
                'required' => false,
            ),
            array (
                'key' => 'tool_image',
                'label' => 'Tool image',
                'name' => 'sub_title',
                'type' => 'image',
                'required' => true,
            )
        ),
        'location' => array (
            array (
                array (
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'tool',
                ),
            ),
        ),
    ));
}
add_action('acf/init', 'siteefy_add_tool_backend_fields');

function siteefy_add_task_backend_fields(){
    acf_add_local_field_group(array(
        'key' => 'tasks_group',
        'title' => 'Tasks Group',
        'fields' => array (
            array (
                'key' => 'task_nice_title',
                'label' => 'Nice title (with emoji)',
                'name' => 'task_nice_title',
                'type' => 'text',
                'required' => false,
            ),
        ),
        'location' => array (
            array (
                array (
                    'param' => 'post_type',
                    'operator' => '==',
                    'value' => 'task',
                ),
            ),
        ),
    ));

}
add_action('acf/init', 'siteefy_add_task_backend_fields');


function siteefy_add_homepage_backend_fields(){
    if (function_exists('acf_add_local_field_group')) {
        acf_add_local_field_group(array(
            'key' => 'group_homepage_template_fields',
            'title' => 'Homepage Template Fields',
            'fields' => array(
                array(
                    'key' => 'field_homepage_text',
                    'label' => 'Homepage H1 Text',
                    'name' => 'homepage_h1_text',
                    'type' => 'text',
                    'default_value' => 'Find That Tool',
                ),
            ),
            'location' => array(
                array(
                    array(
                        'param' => 'page_template',
                        'operator' => '==',
                        'value' => 'homepage-template.php', // Template filename
                    ),
                ),
            ),
        ));
    }

}

add_action('acf/init', 'siteefy_add_homepage_backend_fields');




function populate_tool_assigned_tasks_field( $field ) {
    // Reset choices
    $field['choices'] = array();

    // Get all "task" posts
    $tasks = get_posts(array(
        'post_type' => 'task',
        'posts_per_page' => -1,
        'post_status' => 'publish',
    ));

    // Loop through the tasks and add them to the choices
    if( $tasks ) {
        foreach( $tasks as $task ) {
            $field['choices'][ $task->ID ] = $task->post_title;
        }
    }

    // Return the updated field
    return $field;
}

add_filter('acf/load_field/name=tool_assigned_tasks', 'populate_tool_assigned_tasks_field');

function siteefy_get_tool_image($id){
    $img = get_field('tool_image', $id);
    if(is_array($img)){
//        var_dump($img);
        return $img['url'];
    }else{
        return  PLUGIN_IMAGE_URL . '/tool-image-placeholder.png';
    }
}

function siteefy_get_field($field='', $id=false){
    if(!$id){
        global $post;
        $id = $post->ID;
    }
    switch ($field) {
        case 'tool_image':
          echo siteefy_get_tool_image($id);
            break;
        case 'tool_name':
            $title = get_field('tool_name',$id) ?: get_the_title($id) ;
            echo $title;
            break;
        case 'tool_rating':
            $rating = get_field('tool_rating', $id) ?: '4.9';
            $rating = (strpos($rating ?: '.', '.') === false) ? $rating . '.0' : $rating;
            echo $rating;
            break;
        case 'tool_review_link':
            $link = get_field('tool_review_link', $id);
            if($link){
                $link = $link['url'];
                echo $link;
            }
            break;
        case 'tool_assigned_tasks':
            $assigned_task = get_tasks_for_tool_from_its_solution($id);
            if(is_array($assigned_task) && count($assigned_task)>=0){
                return $assigned_task[0];
            }else{
                return '';
            }
            break;
        case 'tool_price':
            $price_text = get_field('tool_price', $id) ?:'Free';
            echo $price_text;
            break;
        case 'tool_exact_price':
            $price_exact_text = get_field('tool_exact_price', $id);
            echo ($price_exact_text === '0' || $price_exact_text === 0 || empty($price_exact_text)) ? 'Free' : '$'.$price_exact_text;
            break;
        case 'tool_description':
            $tool_description = get_field('tool_description', $id) ?: get_the_excerpt($id);
            echo $tool_description;
            break;
        default:
            return '';
    }
}

function get_task_by_id($id){
    return get_post($id);
}

function get_task_by_tool($tool){
    return get_tasks_for_tool_from_its_solution($tool->ID);
}





add_filter( 'request', 'rudr_change_term_request', 1, 1 );

function rudr_change_term_request( $query ){

    $tax_name = 'solution'; // specify your taxonomy name here, it can be also 'category' or 'post_tag'

//     Request for child terms differs, we should make an additional check
    $include_children = false;
    $name = isset( $query[ 'name' ] ) ? $query[ 'name' ] : '';

    $term = get_term_by( 'slug', $name, $tax_name ); // get the current term to make sure it exists

    if( ! is_wp_error( $term ) && $term ) {
        // let's not forget about hierarchical taxonomies
        unset( $query[ 'name' ] );

        switch( $tax_name ) {
            case 'category' : {
                $query[ 'category_name' ] = $name; // for categories
                break;
            }
            case 'solution' : {
                $query[ 'tag' ] = $name; // for post tags
                break;
            }
            default : {
                $query[ $tax_name ] = $name; // for other taxonomies
                break;
            }
        }
    }

    return $query;

}


function change_solution_permalink( $url, $term, $taxonomy ){

    $taxonomy_name = 'solution'; // your taxonomy name here
    $taxonomy_slug = 'solution'; // the taxonomy base slug can be different with the taxonomy name (like 'post_tag' and 'tag' )

    // exit the function if this taxonomy slug is not in the URL
    if( false === strpos( $url, $taxonomy_slug ) || $taxonomy !== $taxonomy_name ) {
        return $url;
    }

    // remove taxonomy base slug from term links
    $url = str_replace( '/' . $taxonomy_slug, '', $url );

    return $url;

}
add_filter( 'term_link', 'change_solution_permalink', 10, 3 );

function change_category_permalink( $url, $term, $taxonomy ){

    $taxonomy_name = 'category'; // your taxonomy name here
    $taxonomy_slug = 'category'; // the taxonomy base slug can be different with the taxonomy name (like 'post_tag' and 'tag' )

    // exit the function if this taxonomy slug is not in the URL
    if( false === strpos( $url, $taxonomy_slug ) || $taxonomy !== $taxonomy_name ) {
        return $url;
    }

    // remove taxonomy base slug from term links
    $url = str_replace( '/' . $taxonomy_slug, '', $url );

    return $url;

}
add_filter( 'term_link', 'change_category_permalink', 10, 3 );

function custom_solution_rewrite_rules_new() {
    // Keep the default rule for /solution/test2/
    add_rewrite_rule(
        '^solution/([^/]+)/?$',
        'index.php?solution=$matches[1]',
        'top'
    );

    // Fetch all existing solution terms to avoid breaking other pages
    $terms = get_terms([
        'taxonomy'   => 'solution',
        'hide_empty' => false, // Include terms without posts
    ]);

    if (!empty($terms) && !is_wp_error($terms)) {
        foreach ($terms as $term) {
            add_rewrite_rule(
                '^' . $term->slug . '/?$',
                'index.php?solution=' . $term->slug,
                'top'
            );
        }
    }




    //cat - test
    // Keep the default rule for /solution/test2/
    add_rewrite_rule(
        '^category/([^/]+)/?$',
        'index.php?category=$matches[1]',
        'top'
    );

    // Fetch all existing solution terms to avoid breaking other pages
    $terms = get_terms([
        'taxonomy'   => 'category',
        'hide_empty' => false, // Include terms without posts
    ]);

    if (!empty($terms) && !is_wp_error($terms)) {
        foreach ($terms as $term) {
            add_rewrite_rule(
                '^' . $term->slug . '/?$',
                'index.php?category=' . $term->slug,
                'top'
            );
        }
    }
}
add_action('init', 'custom_solution_rewrite_rules_new');

function siteefy_flush_permalinks_on_term_save( $term_id, $tt_id, $taxonomy ) {
    // Check if the taxonomy is the one you're interested in (e.g., 'solution')
    // Flush the rewrite rules to refresh the permalinks
    flush_rewrite_rules();
}
add_action( 'create_term', 'siteefy_flush_permalinks_on_term_save', 10, 3 );
add_action( 'edit_term', 'siteefy_flush_permalinks_on_term_save', 10, 3 );

function siteefy_flush_permalinks_on_ajax_term_creation() {
    // Flush the rewrite rules to refresh the permalinks
    flush_rewrite_rules();
}
add_action( 'wp_ajax_create_term', 'siteefy_flush_permalinks_on_ajax_term_creation' );

add_action('admin_init', function(){
    flush_rewrite_rules();
});


function siteefy_prevent_term_creation_if_post_exists( $term_id, $tt_id, $taxonomy ) {
    // Only apply to 'solution' or 'category' taxonomy
    if ( in_array( $taxonomy, array( 'solution', 'category' ) ) ) {

        // Get the term's slug
        $term = get_term( $term_id, $taxonomy );
        $term_slug = $term->slug;

        // Check if a page or post with the same slug already exists
        $post = get_page_by_path( $term_slug, OBJECT, array( 'post', 'page' ) );

        if ( $post ) {
            // If a page or post with the same slug exists, delete the term
            wp_delete_term( $term_id, $taxonomy );
            flush_rewrite_rules();

            // Return an error message (optional)
            wp_die('A page or post with the same slug already exists. The term has not been created.');
        }
    }
}
add_action( 'create_term', 'siteefy_prevent_term_creation_if_post_exists', 10, 3 );
