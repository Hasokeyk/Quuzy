<?php
	get_header();

	global $userID;
	$userID = get_post_meta(get_the_ID(), 'sub_quuzy_user_id', true);

	get_sidebar();
?>
<div class="container">
	<div class="post-content">

		<h1><?php echo get_the_title(); ?>'s Posts</h1>

		<div class="post-image">
			<?php
				if(has_post_thumbnail()){
					echo get_the_post_thumbnail();
				}
			?>
		</div>

		<div class="post-desc">
			<?php
				echo tag_post_linker(user_linker(get_the_content()));
			?>
		</div>

	</div>
</div>
<?php
	get_footer();
?>
