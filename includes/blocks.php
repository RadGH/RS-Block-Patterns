<?php

/**
 * Adds a block pattern category for the theme in order to distinguish our custom patterns from default ones.
 *
 * @return void
 */
function rsbp_register_block_pattern_categories() {
	if ( ! function_exists( 'register_block_pattern_category' ) ) return;
	
	$category = get_field( 'category_name', 'rsbp_options' );
	if ( ! $category ) $category = 'RS Block Patterns';
	
	register_block_pattern_category(
		'rs_block_patterns',
		array( 'label' => __( $category, 'rsbp' ) )
	);
}
add_action( 'init', 'rsbp_register_block_pattern_categories' );


/**
 * Load our custom block pattern post type to registered block patterns
 *
 * @return void
 */
function rsbp_register_block_patterns_from_post_type() {
	if ( ! function_exists( 'register_block_pattern' ) ) return;
	
	$patterns = get_transient('rs_block_patterns');
	
	if ( ! $patterns ) {
		
		// Load all block patterns from our custom post type
		$args = array(
			'post_type' => 'rs_block_pattern',
			'nopaging' => true,
			'fields' => 'ids',
		);
		
		$q = new WP_Query($args);
		if ( ! $q->have_posts() ) return;
		
		// Store calculated results in $patterns
		$patterns = array();
		
		foreach( $q->posts as $post_id ) {
			$title = get_the_title( $post_id );
			$categories = (array) get_field( 'category_name', $post_id ); // custom field
			$content = get_post_field( 'post_content', $post_id );
			
			if ( ! $categories ) $categories = array( 'text' );
			
			// Always add our custom pattern category
			$categories[] = 'rs_block_patterns';
			
			// Store this pattern
			if ( $title && $content ) {
				$patterns[] = array(
					'pattern_name' => 'rs_block_patterns/' . $post_id,
					'pattern_properties' => array(
						'title' => $title,
						'categories' => $categories,
						'content' => $content,
					),
				);
			}
		}
		
		// Cache results for 24 hours
		set_transient( 'rs_block_patterns', $patterns, DAY_IN_SECONDS );
	}
	
	// Register each block pattern
	if ( $patterns ) foreach( $patterns as $p ) {
		register_block_pattern(
			$p['pattern_name'],
			$p['pattern_properties']
		);
	}
}
add_action( 'init', 'rsbp_register_block_patterns_from_post_type' );

/**
 * Purge the cached block patterns when a new block pattern is saved
 */
function rsbp_purge_block_pattern_cache( $post_id ) {
	if ( get_post_type( $post_id ) != 'rs_block_pattern' ) return;
	
	// Purge the block pattern cache
	delete_transient( 'rs_block_patterns' );
}
add_action( 'save_post', 'rsbp_purge_block_pattern_cache' );