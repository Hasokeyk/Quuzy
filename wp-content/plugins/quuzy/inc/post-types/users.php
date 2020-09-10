<?php

	global $quuzy_users_post_type;
	$quuzy_users_post_type = 'quuzy_users';

	//ADD CSS
	function quuzy_users_css() {
		wp_enqueue_style( 'story-maker-style', plugins_url( 'story-maker' ) . '/assets/css/story-maker.css', [], null, false );
	}
	//add_action( 'wp_enqueue_scripts', 'quuzy_users_css' );
	//ADD CSS

	//ADD POST TYPE
	function quuzy_users_post_type() {
		global $quuzy_users_post_type;

		$theme_name = 'quuzy';

		$labels = [
			'name'               => __( 'Quuzy Users', $theme_name ),
			'singular_name'      => __( 'User', $theme_name ),
			'menu_name'          => __( 'Quuzy Users', $theme_name ),
			'parent_item_colon'  => __( 'Sub User', $theme_name ),
			'all_items'          => __( 'All Quuzy Users', $theme_name ),
			'view_item'          => __( 'View User', $theme_name ),
			'add_new_item'       => __( 'New User', $theme_name ),
			'add_new'            => __( 'Add User', $theme_name ),
			'edit_item'          => __( 'Edit User', $theme_name ),
			'update_item'        => __( 'Update User', $theme_name ),
			'search_items'       => __( 'Find User', $theme_name ),
			'not_found'          => __( 'Not Found', $theme_name ),
			'not_found_in_trash' => __( 'Trash is Empty', $theme_name ),
			'search_items'       => __( 'Search', $theme_name ),
		];

		$args = [
			'label'              => __( 'Quuzy Users', $theme_name ),
			'public'             => true,
			'labels'             => $labels,
			'publicly_queryable' => true,
			'query_var'          => true,
			'hierarchical'       => true,
			'rewrite'            => false,
			"supports"           => [ "title", "editor", "thumbnail", 'custom-fields' ],
		];

		// POST SLUG
		add_rewrite_tag('%'.$quuzy_users_post_type.'%', '([^/]*)');
		add_permastruct($quuzy_users_post_type, '%'.$quuzy_users_post_type.'%-user', true);
		// POST SLUG

		flush_rewrite_rules();

		register_post_type( $quuzy_users_post_type, $args );
	}
	add_action( 'init', 'quuzy_users_post_type' );
	//ADD POST TYPE

	//ADD TAXONOMY
	function quuzy_users_taxonomy() {
		global $quuzy_users_post_type;

		register_taxonomy( $quuzy_users_post_type . '_tags', $quuzy_users_post_type, [
			'label'        => __( 'Tags' ),
			'rewrite'      => [
				'slug' => 'user-tag',
			],
			'hierarchical' => true,
		] );
	}
	add_action( 'init', 'quuzy_users_taxonomy' );
	//ADD TAXONOMY

	//TAXONOMY TEMPLATE
	function quuzy_users_taxonomy_template($tax_template) {
		global $quuzy_users_post_type;

		if (is_tax($quuzy_users_post_type.'_tags')) {
			$tax_template = (get_template_directory()) . '/templates/'.$quuzy_users_post_type.'_tags.php';
		}
		return $tax_template;
	}
	add_filter( "taxonomy_template", 'quuzy_users_taxonomy_template');
	//TAXONOMY TEMPLATE

	//POST TYPE ADD TEMPLATE
	function quuzy_users_template( $single ) {
		global $quuzy_users_post_type,$wp_query, $post;

		if ( $post->post_type == $quuzy_users_post_type ) {
			$file = (get_template_directory()) . '/templates/' . $quuzy_users_post_type . '.php';
			if ( file_exists( $file ) ) {
				return $file;
			}
		}

		return $single;
	}
	add_filter( 'single_template', 'quuzy_users_template' );
	//POST TYPE ADD TEMPLATE