<?php

	//THUMBNAIL SUPPORT
	add_theme_support( 'post-thumbnails' );
	//THUMBNAIL SUPPORT

	//ADD QUUZY CSS
	function quuzy_css() {
		wp_enqueue_style( 'quuzy-style', get_template_directory_uri().'/assets/css/quuzy.css', [], null, false );
		wp_enqueue_style( 'font-awesome-style', get_template_directory_uri().'/assets/css/fontawesome-min.css', [], null, false );
	}
	add_action( 'wp_enqueue_scripts', 'quuzy_css' );
	//ADD QUUZY CSS

	//ADD QUUZY JS
	function quuzy_js() {
		wp_enqueue_script( 'quuzy-jquery', get_template_directory_uri().'/assets/js/jquery-3.5.1.min.js', [], null, true );
		wp_enqueue_script( 'quuzy-script', get_template_directory_uri().'/assets/js/quuzy.js', [], null, true );
	}
	add_action( 'wp_enqueue_scripts', 'quuzy_js' );
	//ADD QUUZY JS

	//USER RENDER AJAX
	function quuzy_user_render() {

		global $data;
		$data = json_decode(stripcslashes($_POST['data']),true);
		require (__DIR__)."/templates/quuzy-user-render-page.php";

		wp_die();
	}
	add_action( 'wp_ajax_user_render', 'quuzy_user_render' );
	//USER RENDER AJAX

	function thousandsCurrencyFormat($num) {

		if($num>1000) {

			$x = round($num);
			$x_number_format = number_format($x);
			$x_array = explode(',', $x_number_format);
			$x_parts = array('k', 'm', 'b', 't');
			$x_count_parts = count($x_array) - 1;
			$x_display = $x;
			$x_display = $x_array[0] . ((int) $x_array[1][0] !== 0 ? '.' . $x_array[1][0] : '');
			$x_display .= $x_parts[$x_count_parts - 1];

			return $x_display;

		}

		return $num;
	}