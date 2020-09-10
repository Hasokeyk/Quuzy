<?php

	global $quuzy_user_post_post_type;
	$quuzy_user_post_post_type = 'quuzy_user_posts';

	//ADD CSS
	function quuzy_user_posts_css() {
		wp_enqueue_style( 'story-maker-style', plugins_url( 'story-maker' ) . '/assets/css/story-maker.css', [], null, false );
	}

	//add_action( 'wp_enqueue_scripts', 'quuzy_user_posts_css' );
	//ADD CSS

	//ADD POST TYPE
	function quuzy_user_posts_post_type() {
		global $quuzy_user_post_post_type;

		$theme_name = 'quuzy';

		$labels = [
			'name'               => __( 'Quuzy Posts', $theme_name ),
			'singular_name'      => __( 'Post', $theme_name ),
			'menu_name'          => __( 'Quuzy Posts', $theme_name ),
			'parent_item_colon'  => __( 'Sub Post', $theme_name ),
			'all_items'          => __( 'All Quuzy Posts', $theme_name ),
			'view_item'          => __( 'View Post', $theme_name ),
			'add_new_item'       => __( 'New Post', $theme_name ),
			'add_new'            => __( 'Add Post', $theme_name ),
			'edit_item'          => __( 'Edit Post', $theme_name ),
			'update_item'        => __( 'Update Post', $theme_name ),
			'search_items'       => __( 'Find Post', $theme_name ),
			'not_found'          => __( 'Not Found', $theme_name ),
			'not_found_in_trash' => __( 'Trash is Empty', $theme_name ),
			'search_items'       => __( 'Search', $theme_name ),
		];

		$args = [
			'label'              => __( 'Quuzy Post Posts', $theme_name ),
			'public'             => true,
			'labels'             => $labels,
			'publicly_queryable' => true,
			'query_var'          => true,
			'hierarchical'       => true,
			'rewrite'            => false,
			"supports"           => [ "title", "editor", "thumbnail", 'custom-fields' ],
			'show_ui'            => true,
		];

		// POST SLUG
		add_rewrite_tag( '%' . $quuzy_user_post_post_type . '%', '([^/]*)' );
		add_permastruct( $quuzy_user_post_post_type, '%' . $quuzy_user_post_post_type . '%-post', true );
		// POST SLUG

		flush_rewrite_rules();

		register_post_type( $quuzy_user_post_post_type, $args );
	}

	add_action( 'init', 'quuzy_user_posts_post_type' );
	//ADD POST TYPE

	//ADD TAXONOMY
	function quuzy_user_posts_taxonomy() {
		global $quuzy_user_post_post_type;

		register_taxonomy( $quuzy_user_post_post_type . '_tags', $quuzy_user_post_post_type, [
			'label'        => __( 'Tags' ),
			'rewrite'      => [
				'slug' => 'posts-tag',
			],
			'hierarchical' => true,
		] );
	}

	add_action( 'init', 'quuzy_user_posts_taxonomy' );
	//ADD TAXONOMY

	//TAXONOMY TEMPLATE
	function quuzy_user_posts_taxonomy_template( $tax_template ) {
		global $quuzy_user_post_post_type;

		if ( is_tax( $quuzy_user_post_post_type . '_tags' ) ) {
			$tax_template = ( get_template_directory() ) . '/templates/' . $quuzy_user_post_post_type . '_tags.php';
		}

		return $tax_template;
	}

	add_filter( "taxonomy_template", 'quuzy_user_posts_taxonomy_template' );
	//TAXONOMY TEMPLATE

	//POST TYPE ADD TEMPLATE
	function quuzy_user_posts_template( $single ) {
		global $quuzy_user_post_post_type, $wp_query, $post;

		if ( $post->post_type == $quuzy_user_post_post_type ) {
			$file = ( get_template_directory() ) . '/templates/' . $quuzy_user_post_post_type . '.php';
			if ( file_exists( $file ) ) {
				return $file;
			}
		}

		return $single;
	}

	add_filter( 'single_template', 'quuzy_user_posts_template' );
	//POST TYPE ADD TEMPLATE

	//ADD META BOX
	function quuzy_user_posts_register_meta_boxes() {
		global $quuzy_user_post_post_type;
		add_meta_box(
			'meta-box-id',
			__( 'Sub Quuzy Post', 'quuzy' ),
			'quuzy_user_posts_display_callback',
			$quuzy_user_post_post_type
		);
	}
	add_action( 'add_meta_boxes', 'quuzy_user_posts_register_meta_boxes' );


	function quuzy_user_posts_display_callback( $post ) {
		?>
		<div class="postboxs">
			<select name="sub_quuzy_user_id" id="sub_quuzy_user_id">
				<option value="0">---Select Post---</option>
				<?php
					$selected = get_post_meta( $post->ID, 'sub_quuzy_user_id',true);
					$stories  = get_posts( [ 'post_type'      => 'quuzy_users',
					                         'post_status'    => 'publish',
					                         'posts_per_page' => - 1,
					                         'exclude'        => $post->ID,
					] );
					foreach ( $stories as $s ) {
				?>
				<option value="<?=$s->ID?>" <?=( isset( $selected ) and $s->ID == $selected) ? 'selected' : ''?>><?=$s->post_title?></option>
				<?php
					}
				?>
			</select>
		</div>
		<?php
	}

	function quuzy_user_posts_save_meta_box( $post_id ) {
		global $post;

		if ( isset( $_POST["sub_quuzy_user_id"] ) ) {
			$sub_quuzy_user_id = $_POST["sub_quuzy_user_id"];
			update_post_meta( $post_id, "sub_quuzy_user_id", $sub_quuzy_user_id );
		}

		return $post_id;
	}

	add_action( 'save_post', 'quuzy_user_posts_save_meta_box' );
	//ADD META BOX