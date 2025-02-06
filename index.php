<?php
/**
 * Plugin Name:          Siteefy
 * Plugin URI:
 * Description:
 * Version: 1.1.01
 * Author:                 Nikola Stanin
 * Author URI:
 * License:
 * License URI:          https://www.gnu.org/licenses/gpl-3.0.html
 * Requires at least:
 * Requires PHP:         7.4
 * Text Domain:
 * Domain Path:
 */



defined('ABSPATH') || exit;

require_once  WP_PLUGIN_DIR . '/siteefy/functions.php';
require_once  WP_PLUGIN_DIR . '/siteefy/ajax.php';
require_once  WP_PLUGIN_DIR . '/siteefy/shortcodes.php';

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
        'public'             => false,
        'publicly_queryable' => false,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'            => array( 'slug' => 'tools' ),
        'capability_type'    => 'post',
        'has_archive'        => false,
        'hierarchical'       => false,
        'menu_position'      => 53,
        'menu_icon' => 'dashicons-admin-tools',
        'supports'           => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments' ),
    );

    register_post_type( 'tool', $args );
}
add_action( 'init', 'siteefy_tool_init' );



/**
 * Register a custom post type called "Tool".
 *
 * @see get_post_type_labels() for label keys.
 */
function siteefy_solution_init() {
    $labels = array(
        'name'                  => _x( 'Solution', 'Post type general name', 'textdomain' ),
        'singular_name'         => _x( 'Solution', 'Post type singular name', 'textdomain' ),
        'menu_name'             => _x( 'Solutions', 'Admin Menu text', 'textdomain' ),
        'name_admin_bar'        => _x( 'Solution', 'Add New on Toolbar', 'textdomain' ),
        'add_new'               => __( 'Add New', 'textdomain' ),
        'add_new_item'          => __( 'Add New Solution', 'textdomain' ),
        'new_item'              => __( 'New Solution', 'textdomain' ),
        'edit_item'             => __( 'Edit Solution', 'textdomain' ),
        'view_item'             => __( 'View Solution', 'textdomain' ),
        'all_items'             => __( 'All Solution', 'textdomain' ),
        'search_items'          => __( 'Search Solutions', 'textdomain' ),
        'parent_item_colon'     => __( 'Parent Solutions:', 'textdomain' ),
        'not_found'             => __( 'No Solution found.', 'textdomain' ),
        'not_found_in_trash'    => __( 'No Solutions found in Trash.', 'textdomain' ),
        'featured_image'        => _x( 'Solution Cover Image', 'Overrides the “Featured Image” phrase for this post type. Added in 4.3', 'textdomain' ),
        'set_featured_image'    => _x( 'Set cover image', 'Overrides the “Set featured image” phrase for this post type. Added in 4.3', 'textdomain' ),
        'remove_featured_image' => _x( 'Remove cover image', 'Overrides the “Remove featured image” phrase for this post type. Added in 4.3', 'textdomain' ),
        'use_featured_image'    => _x( 'Use as cover image', 'Overrides the “Use as featured image” phrase for this post type. Added in 4.3', 'textdomain' ),
        'archives'              => _x( 'Solution archives', 'The post type archive label used in nav menus. Default “Post Archives”. Added in 4.4', 'textdomain' ),
        'insert_into_item'      => _x( 'Insert into Solution', 'Overrides the “Insert into post”/”Insert into page” phrase (used when inserting media into a post). Added in 4.4', 'textdomain' ),
        'uploaded_to_this_item' => _x( 'Uploaded to this Solution', 'Overrides the “Uploaded to this post”/”Uploaded to this page” phrase (used when viewing media attached to a post). Added in 4.4', 'textdomain' ),
        'filter_items_list'     => _x( 'Filter Solutions list', 'Screen reader text for the filter links heading on the post type listing screen. Default “Filter posts list”/”Filter pages list”. Added in 4.4', 'textdomain' ),
        'items_list_navigation' => _x( 'Solutions list navigation', 'Screen reader text for the pagination heading on the post type listing screen. Default “Posts list navigation”/”Pages list navigation”. Added in 4.4', 'textdomain' ),
        'items_list'            => _x( 'Solutions list', 'Screen reader text for the items list heading on the post type listing screen. Default “Posts list”/”Pages list”. Added in 4.4', 'textdomain' ),
    );

    $args = array(
        'labels'             => $labels,
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'            => array( 'slug' => 'solutions' ),
        'capability_type'    => 'post',
        'has_archive'        => true,
        'hierarchical'       => false,
        'menu_position'      => 53,
        'menu_icon' => 'dashicons-admin-tools',
        'supports'           => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments' ),
    );

    register_post_type( 'solution', $args );
}
add_action( 'init', 'siteefy_solution_init' );

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
        'rewrite'            => array( 'slug' => 'tasks' ),
        'capability_type'    => 'post',
        'has_archive'        => true,
        'hierarchical'       => false,
        'menu_position'      => 52,
        'supports'           => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments' ),
    );

    register_post_type( 'task', $args );
}

add_action( 'init', 'siteefy_task__init' );

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
        'public'             => false,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true, // Attach CPT menu under the Siteefy Options menu
        'query_var'          => true,
//todo: this causes 404 on ai-tools/page
//        'rewrite'            => array( 'slug' => '/', 'with_front' => false, ),
        'capability_type'    => 'post',
        'has_archive'        => true,
        'hierarchical'       => false,
        'menu_position'      => 54,
        'supports'           => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments' ),
    );

    register_post_type( 'article', $args );
}

add_action( 'init', 'siteefy_article__init' );

/**
 * Register a custom post type called "Article".
 *
 * @see get_post_type_labels() for label keys.
 */
function siteefy_category__init() {
    $labels = array(
        'name'                  => _x( 'Categories', 'Post type general name', 'textdomain' ),
        'singular_name'         => _x( 'Category', 'Post type singular name', 'textdomain' ),
        'menu_name'             => _x( 'Categories', 'Admin Menu text', 'textdomain' ),
        'name_admin_bar'        => _x( 'Categories', 'Add New on Toolbar', 'textdomain' ),
        'add_new'               => __( 'Add New', 'textdomain' ),
        'add_new_item'          => __( 'Add New Category', 'textdomain' ),
        'new_item'              => __( 'New Category', 'textdomain' ),
        'edit_item'             => __( 'Edit Category', 'textdomain' ),
        'view_item'             => __( 'View Category', 'textdomain' ),
        'all_items'             => __( 'All Categories', 'textdomain' ),
        'search_items'          => __( 'Search Categories', 'textdomain' ),
        'parent_item_colon'     => __( 'Parent Categories:', 'textdomain' ),
        'not_found'             => __( 'No categories found.', 'textdomain' ),
        'not_found_in_trash'    => __( 'No categories found in Trash.', 'textdomain' ),
        'featured_image'        => _x( 'Category Cover Image', 'Overrides the “Featured Image” phrase for this post type. Added in 4.3', 'textdomain' ),
        'set_featured_image'    => _x( 'Set cover image', 'Overrides the “Set featured image” phrase for this post type. Added in 4.3', 'textdomain' ),
        'remove_featured_image' => _x( 'Remove cover image', 'Overrides the “Remove featured image” phrase for this post type. Added in 4.3', 'textdomain' ),
        'use_featured_image'    => _x( 'Use as cover image', 'Overrides the “Use as featured image” phrase for this post type. Added in 4.3', 'textdomain' ),
        'archives'              => _x( 'Category archives', 'The post type archive label used in nav menus. Default “Post Archives”. Added in 4.4', 'textdomain' ),
        'insert_into_item'      => _x( 'Insert into Category', 'Overrides the “Insert into post”/”Insert into page” phrase (used when inserting media into a post). Added in 4.4', 'textdomain' ),
        'uploaded_to_this_item' => _x( 'Uploaded to this Category', 'Overrides the “Uploaded to this post”/”Uploaded to this page” phrase (used when viewing media attached to a post). Added in 4.4', 'textdomain' ),
        'filter_items_list'     => _x( 'Filter categories list', 'Screen reader text for the filter links heading on the post type listing screen. Default “Filter posts list”/”Filter pages list”. Added in 4.4', 'textdomain' ),
        'items_list_navigation' => _x( 'Category list navigation', 'Screen reader text for the pagination heading on the post type listing screen. Default “Posts list navigation”/”Pages list navigation”. Added in 4.4', 'textdomain' ),
        'items_list'            => _x( 'Category list', 'Screen reader text for the items list heading on the post type listing screen. Default “Posts list”/”Pages list”. Added in 4.4', 'textdomain' ),
    );

    $args = array(
        'labels'             => $labels,
        'public'             => true,
        'publicly_queryable' => true,
        'show_ui'            => true,
        'show_in_menu'       => true,
        'query_var'          => true,
        'rewrite'            => array( 'slug' => 'categories' ),
        'capability_type'    => 'post',
        'has_archive'        => true,
        'hierarchical'       => false,
        'menu_position'      => 51,
        'supports'           => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments' ),
    );

    register_post_type( 'category', $args );
}

add_action( 'init', 'siteefy_category__init' );


function na_parse_request( $query ) {

    if ( ! $query->is_main_query() || 2 != count( $query->query ) || ! isset( $query->query['page'] ) ) {
        return;
    }

    if ( ! empty( $query->query['name'] ) ) {
        $query->set( 'post_type', array( 'post', 'article', 'page' ) );
    }
}
add_action( 'pre_get_posts', 'na_parse_request' );


////CATEGORIES
//function siteefy_plugin_taxonomies() {
//    register_taxonomy(
//        'tool_categories',  // The name of the taxonomy. Name should be in slug form (must not contain capital letters or spaces).
//        'tool',             // post type name
//        array(
//            'hierarchical' => true,
//            'label' => 'Tools Categories', // display name
//            'query_var' => true,
//            'rewrite' => array(
//                'slug' => 'tool',    // This controls the base slug that will display before each term
//                'with_front' => false  // Don't display the category base before
//            )
//        )
//    );
//
//    register_taxonomy(
//        'task_categories',  // The name of the taxonomy. Name should be in slug form (must not contain capital letters or spaces).
//        'task',             // post type name
//        array(
//            'hierarchical' => true,
//            'label' => 'Tasks Categories', // display name
//            'query_var' => true,
//            'rewrite' => array(
//                'slug' => 'task',    // This controls the base slug that will display before each term
//                'with_front' => false  // Don't display the category base before
//            )
//        )
//    );
//}
//add_action( 'init', 'siteefy_plugin_taxonomies');


function siteefy_get_categories_for_tool(){
    //.
}



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
    if (is_search()) {
        $custom_template = plugin_dir_path(__FILE__) . 'templates/search-page-template.php';

        // Check if the custom template exists
        if (file_exists($custom_template)) {
            return $custom_template;
        }
    }elseif(is_single() && get_post_type($post) === 'task'){
        $custom_template = plugin_dir_path(__FILE__) . 'templates/task-template.php';
        // Check if the custom template exists
        if (file_exists($custom_template)) {
            return $custom_template;
        }
    }elseif(is_archive() && get_post_type($post) === 'task' ){
        $custom_template = plugin_dir_path(__FILE__) . 'templates/task-archive-template.php';
        // Check if the custom template exists
        if (file_exists($custom_template)) {
            return $custom_template;
        }
    }
    elseif(is_single() && get_post_type($post) === 'solution'){
        $custom_template = plugin_dir_path(__FILE__) . 'templates/solution-template.php';
        // Check if the custom template exists
        if (file_exists($custom_template)) {
            return $custom_template;
        }
    }
    elseif(is_archive() && get_post_type($post) === 'solution' ){
        $custom_template = plugin_dir_path(__FILE__) . 'templates/solution-archive-template.php';
        // Check if the custom template exists
        if (file_exists($custom_template)) {
            return $custom_template;
        }
    }
    elseif(is_archive() && get_post_type($post) === 'category' ){
        $custom_template = plugin_dir_path(__FILE__) . 'templates/category-archive-template.php';
        // Check if the custom template exists
        if (file_exists($custom_template)) {
            return $custom_template;
        }
    }elseif(is_single() && get_post_type($post) === 'category'){
        $custom_template = plugin_dir_path(__FILE__) . 'templates/category-template.php';
        // Check if the custom template exists
        if (file_exists($custom_template)) {
            return $custom_template;
        }
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
                'label' => 'Tool Name',
                'name' => 'tool_name',
                'type' => 'text',
                'required' => true,
            ),
            array (
                'key' => 'tool_review_link',
                'label' => 'Tool Review Link',
                'name' => 'tool_review_link',
                'type' => 'link',
            ),
            array (
                'key' => 'tool_rating',
                'label' => 'Tool Rating',
                'name' => 'tool_rating',
                'type' => 'range',
                'min'=>0,
                'max'=>10,
                'step'=> '0.1',
                'required' => true,
            ),
//todo:get tool assigned tasks from its solution
        //tool_assigned_tasks -> get_tasks_by_solution
//            array (
//                'key' => 'tool_assigned_tasks',
//                'label' => 'Tool assigned Tasks',
//                'name' => 'tool_assigned_tasks',
//                'type' => 'select',
//                'multiple' => 1,
//                'required' => true,
//            ),
            array (
                'key' => 'tool_category',
                'label' => 'Tool assigned category',
                'name' => 'tool_category',
                'type' => 'select',
                'multiple' => 0,
                'required' => true,
            ),
            array (
                'key' => 'tool_solution',
                'label' => 'Tool assigned solution',
                'name' => 'tool_solution',
                'type' => 'select',
                'multiple' => 1,
                'required' => true,
            ),
            array (
                'key' => 'tool_price',
                'label' => 'Tool price description',
                'name' => 'tool_price',
                'type' => 'text',
                'required' => false,
            ),
            array (
                'key' => 'tool_is_featured',
                'label' => 'Tool - is featured ? (appears with blue highlighted border on search page "sponsored")',
                'name' => 'tool_is_featured',
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
                'label' => 'Task nice title (with emoji)',
                'name' => 'task_nice_title',
                'type' => 'text',
                'required' => false,
            ),
            array (
                'key' => 'task_category',
                'label' => 'Task assigned category',
                'name' => 'task_category',
                'type' => 'select',
                'multiple' => 0,
                'required' => true,
            ),
            array (
                'key' => 'task_solution',
                'label' => 'Task assigned solution',
                'name' => 'task_solution',
                'type' => 'select',
                'multiple' => 1,
                'required' => true,
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


function populate_category_select_field_for_tasks( $field ) {
    // Reset choices
    $field['choices'] = array();

    // Get all "categories" posts
    $categories = get_posts(array(
        'post_type' => 'category',
        'posts_per_page' => -1,
        'post_status' => 'publish',
    ));

    // Loop through the tasks and add them to the choices
    if( $categories ) {
        foreach( $categories as $category ) {
            $field['choices'][ $category->ID ] = $category->post_title;
        }
    }

    // Return the updated field
    return $field;
}
add_filter('acf/load_field/name=tool_category', 'populate_category_select_field_for_tasks');
add_filter('acf/load_field/name=task_category', 'populate_category_select_field_for_tasks');

function populate_solution_select_field_for_tasks( $field ) {
    // Reset choices
    $field['choices'] = array();

    // Get all "solution" posts
    $solutions = get_posts(array(
        'post_type' => 'solution',
        'posts_per_page' => -1,
        'post_status' => 'publish',
    ));

    // Loop through the tasks and add them to the choices
    if( $solutions ) {
        foreach( $solutions as $solution ) {
            $field['choices'][ $solution->ID ] = $solution->post_title;
        }
    }

    // Return the updated field
    return $field;
}
add_filter('acf/load_field/name=tool_solution', 'populate_solution_select_field_for_tasks');
add_filter('acf/load_field/name=task_solution', 'populate_solution_select_field_for_tasks');

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
            $rating = (!str_contains($rating ?: '.', '.')) ? $rating . '.0' : $rating;
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
//            $assigned_task = get_field('tool_assigned_tasks', $id);
            $assigned_task = get_tasks_for_tool_from_its_solution($id);
            if(is_array($assigned_task) && count($assigned_task)>=0){
                return $assigned_task[0];
//               echo get_the_title($assigned_task[0]);
            }else{
                return '';
            }
            break;
        case 'tool_price';
            $price_text = get_field('tool_price', $id) ?:'Free';
            echo $price_text;
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

function get_tasks_for_tool_from_its_solution($tool_id = 0) {
    $solution_ids = get_field('tool_solution', $tool_id);

    if (empty($solution_ids)) {
        return [];
    }

    $tasks = get_all_tasks(); // Returns an array of WP_Post objects
    $matching_tasks = [];

    foreach ($tasks as $task) {
        $task_assigned_solutions = get_field('task_solution', $task->ID);

        if (!empty($task_assigned_solutions) && array_intersect($solution_ids, $task_assigned_solutions)) {
            $matching_tasks[] = $task->ID; // Collect only task IDs
        }
    }

    return $matching_tasks;
}


//var_dump(get_tasks_for_tool_from_its_solution(57049));

function get_task_assigned_category($task){
    $category_id = get_field('task_category', $task->ID);
    echo get_post($category_id)->post_title ?? '';
}


function get_all_categories($limit=5) {
    // Get all "categories" posts
    $categories = get_posts(array(
        'post_type' => 'category',
        'posts_per_page' => $limit,
        'post_status' => 'publish',
    ));
    return $categories;
}




