<?php

add_action( 'acf/include_fields', function() {
	if ( ! function_exists( 'acf_add_local_field_group' ) ) {
		return;
	}
	
	acf_add_local_field_group( array(
		'key' => 'group_64ac6e902bf37',
		'title' => 'Block Pattern Settings',
		'fields' => array(
			array(
				'key' => 'field_64ac6e90cda53',
				'label' => 'Categories',
				'name' => 'categories',
				'aria-label' => '',
				'type' => 'select',
				'instructions' => '',
				'required' => 0,
				'conditional_logic' => 0,
				'wrapper' => array(
					'width' => '',
					'class' => '',
					'id' => '',
				),
				'choices' => array(
					'featured' => 'Featured',
					'text' => 'Text',
					'buttons' => 'Buttons',
					'columns' => 'Columns',
					'gallery' => 'Gallery',
					'header' => 'Headers',
					'query' => 'Posts',
					'banner' => 'Banners',
					'call-to-action' => 'Call to Action',
					'team' => 'Team',
					'testimonials' => 'Testimonials',
					'services' => 'Services',
					'contact' => 'Contact',
					'about' => 'About',
					'portfolio' => 'Portfolio',
					'media' => 'Media',
					'posts' => 'Posts',
					'footer' => 'Footers',
				),
				'default_value' => array(
					0 => 'rs_block_patterns',
					1 => 'text',
				),
				'return_format' => 'value',
				'multiple' => 1,
				'allow_null' => 1,
				'ui' => 1,
				'ajax' => 0,
				'placeholder' => '',
			),
		),
		'location' => array(
			array(
				array(
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'rs_block_pattern',
				),
			),
		),
		'menu_order' => 0,
		'position' => 'side',
		'style' => 'default',
		'label_placement' => 'top',
		'instruction_placement' => 'label',
		'hide_on_screen' => '',
		'active' => true,
		'description' => 'Settings for individual "rs_block_pattern" posts.',
		'show_in_rest' => 0,
	) );
} );