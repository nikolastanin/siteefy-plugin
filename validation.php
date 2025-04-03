<?php

function siteefy_prevent_term_creation_if_post_or_cross_term_exists( $term_id, $tt_id, $taxonomy ) {
    // Only apply to 'solution' or 'category' taxonomies
    if ( in_array( $taxonomy, array( 'solution', 'category' ) ) ) {

        // Get the term object and slug
        $term = get_term( $term_id, $taxonomy );
        $term_slug = $term->slug;

        // Check if a page or post with the same slug already exists
        $post = get_page_by_path( $term_slug, OBJECT, array( 'post', 'page' ) );

        // Determine the opposite taxonomy to check for duplicate slug
        $other_taxonomy = $taxonomy === 'solution' ? 'category' : 'solution';
        $duplicate_term = get_term_by( 'slug', $term_slug, $other_taxonomy );

        if ( $post || $duplicate_term ) {
            // If a conflict is found, delete the term
            wp_delete_term( $term_id, $taxonomy );
            flush_rewrite_rules();

            // Build a dynamic error message
            $conflict_message = $post ? 'a post or page ' : 'a term(category or solution) ';

            wp_die('A conflict was found: ' . $conflict_message . 'with same slug already exists. The term has not been created.');
        }
    }
}
add_action( 'create_term', 'siteefy_prevent_term_creation_if_post_or_cross_term_exists', 10, 3 );
