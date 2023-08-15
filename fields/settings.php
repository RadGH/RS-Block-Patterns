<?php

add_action( 'acf/include_fields', function() {
	if ( ! function_exists( 'acf_add_local_field_group' ) ) {
		return;
	}
	
	acf_add_local_field_group( array(
		'key' => 'group_64ac6fb9619a1',
		'title' => 'Block Pattern - General Settings',
		'fields' => array(
			array(
				'key' => 'field_64ac6fb99e8e8',
				'label' => 'Category Name',
				'name' => 'category_name',
				'aria-label' => '',
				'type' => 'text',
				'instructions' => 'This is the category name that is assigned to each custom block pattern. The internal category slug is "rs_block_patterns".',
				'required' => 0,
				'conditional_logic' => 0,
				'wrapper' => array(
					'width' => '',
					'class' => '',
					'id' => '',
				),
				'default_value' => '',
				'maxlength' => '',
				'placeholder' => '',
				'prepend' => '',
				'append' => '',
			),
		),
		'location' => array(
			array(
				array(
					'param' => 'options_page',
					'operator' => '==',
					'value' => 'acf-rsbp-settings',
				),
			),
		),
		'menu_order' => 0,
		'position' => 'normal',
		'style' => 'default',
		'label_placement' => 'top',
		'instruction_placement' => 'label',
		'hide_on_screen' => '',
		'active' => true,
		'description' => '',
		'show_in_rest' => 0,
	) );
} );

