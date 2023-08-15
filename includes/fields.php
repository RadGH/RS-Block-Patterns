<?php

/**
 * Load all block pattern categories into the pattern category dropdown, shown when editing a block pattern.
 * Also sets the default category
 *
 * @param $field
 *
 * @return mixed
 */
function rsbp_fill_block_categories_dropdown( $field ) {
	// Do not fill on field group editor screen
	if ( acf_is_screen('acf-field-group') ) return $field;
	
	// Do not fill unless block editor is enabled and loaded
	if ( ! class_exists('WP_Block_Pattern_Categories_Registry') ) return $field;
	
	// Get all registered block patterns
	$block_pattern_category_registry = WP_Block_Pattern_Categories_Registry::get_instance();
	
	$categories = $block_pattern_category_registry->get_all_registered();
	
	$default_choices = $field['choices'];
	
	$choices = array();
	
	foreach ( $categories as $category ) {
		// Ignore our custom category, it is always enabled for our custom patterns.
		if ( $category['name'] == 'rs_block_patterns' ) continue;
		
		$choices[ $category['name'] ] = $category['label'];
	}
	
	$field['choices'] = array_merge( $default_choices, $choices );
	
	// Set the default value to include the custom one from our options screen
	array_unshift( $field['default_value'], 'rs_block_patterns' );
	
	return $field;
}
add_filter('acf/load_field/key=field_64ac6e90cda53', 'rsbp_fill_block_categories_dropdown');