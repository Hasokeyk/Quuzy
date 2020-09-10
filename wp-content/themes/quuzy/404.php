<?php

	//ADD QUUZY JS
	function quuzy_404_js() {
		wp_enqueue_script( 'quuzy-404-script', get_template_directory_uri().'/assets/js/404.js', [], null, true );
	}
	add_action( 'wp_enqueue_scripts', 'quuzy_404_js' );
	//ADD QUUZY JS

	get_header();
?>

	<div class="container">



	</div>

<?php
	get_footer();
?>
