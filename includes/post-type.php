<?php

/**
 * custom post type for block patterns
 *
 * @return void
 */
function rsbp_register_post_type() {
	$labels = array(
		'name'               => _x( 'Block Patterns', 'post type general name', 'textdomain' ),
		'singular_name'      => _x( 'Block Pattern', 'post type singular name', 'textdomain' ),
		'menu_name'          => _x( 'Block Patterns', 'admin menu', 'textdomain' ),
		'name_admin_bar'     => _x( 'Block Pattern', 'add new on admin bar', 'textdomain' ),
		'add_new'            => _x( 'Add New', 'Block Pattern', 'textdomain' ),
		'add_new_item'       => __( 'Add New Block Pattern', 'textdomain' ),
		'new_item'           => __( 'New Block Pattern', 'textdomain' ),
		'edit_item'          => __( 'Edit Block Pattern', 'textdomain' ),
		'view_item'          => __( 'View Block Pattern', 'textdomain' ),
		'all_items'          => __( 'All Block Patterns', 'textdomain' ),
		'search_items'       => __( 'Search Block Patterns', 'textdomain' ),
		'parent_item_colon'  => __( 'Parent Block Patterns:', 'textdomain' ),
		'not_found'          => __( 'No block patterns found.', 'textdomain' ),
		'not_found_in_trash' => __( 'No block patterns found in Trash.', 'textdomain' )
	);
	
	$args = array(
		'labels'             => $labels,
		'description'        => __( 'Description.', 'textdomain' ),
		
		'public'             => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'query_var'          => true,
		
		// do not include in search results
		'exclude_from_search' => true,
		
		// allow patterns to be previewed by admins
		'publicly_queryable' => true,
		'rewrite'            => true,
		
		'menu_icon'          => 'dashicons-table-col-before',
		'capability_type'    => 'post',
		'has_archive'        => false,
		'hierarchical'       => false,
		'menu_position'      => null,
		'supports'           => array( 'title', 'editor', 'revisions' ),
		'show_in_rest'       => true,  // This is what enables the Block Editor
	);
	
	register_post_type( 'rs_block_pattern', $args );
}
add_action( 'init', 'rsbp_register_post_type' );

/**
 * Prevent access to block patterns, except for admins
 *
 * @return void
 */
function rsbp_restrict_block_pattern_access() {
	if ( ! is_singular( 'rs_block_pattern' ) ) return;
	
	if ( ! current_user_can( 'manage_options' ) ) {
		global $wp_query;
		$wp_query->set_404();
		status_header( 404 );
		get_template_part( 404 );
		exit;
	}
}
add_action( 'template_redirect', 'rsbp_restrict_block_pattern_access' );

/**
 * Remove RS Block Patterns from Yoast sitemap
 *
 * @param  bool   $is_excluded  TRUE if the post type should NOT appear in the sitemap.
 * @param  string $post_type    The post type, we are interested in 'rs_block_pattern'.
 *
 * @return bool
 */
function rsbp_exclude_block_patterns_from_sitemap( $is_excluded, $post_type ) {
	if ( $post_type == 'rs_block_pattern' ) {
		return true;
	}else{
		return $is_excluded;
	}
}
add_filter( 'wpseo_sitemap_exclude_post_type', 'rsbp_exclude_block_patterns_from_sitemap', 20, 2 );


/**
 * options page for block patterns
 *
 * @return void
 */
function rsbp_register_options_page() {
	if ( ! function_exists('acf_add_options_page') ) return;
	
	// RS Block Pattern Settings
	acf_add_options_sub_page(array(
		'parent_slug'   => 'edit.php?post_type=rs_block_pattern',
		'menu_slug'     => 'acf-rsbp-settings',
		'page_title' 	=> 'Block Pattern Settings',
		'menu_title' 	=> 'Settings',
		'post_id'       => 'rsbp-settings', // $name = get_field( 'name', 'rsbp-settings' );
		'autoload'      => false,
		'capability'    => 'manage_options',
	));
}
add_action( 'admin_menu', 'rsbp_register_options_page' );