<?php
	get_header();

	$termId = get_term_by('slug', get_query_var('term'), get_query_var('taxonomy'))->term_id;

	get_sidebar();
?>
<div class="container">

	<?php

		$profiles = get_posts( [
			'post_type'   => 'quuzy_users',
			'post_status' => 'publish',
			's'   => single_tag_title("", false),
			'posts_per_page' => -1,
		] );

		if($profiles != null){
			?>
			<div class="profiles">
				<div class="title">
					<?php echo single_tag_title(); ?> Tag User Lists
				</div>
				<?php
					foreach($profiles as $profile){
						?>
						<a href="<?php echo get_permalink($profile->ID); ?>" title="<?php echo $profile->post_title; ?>" class="profile">
							<div class="profile-pic">
								<?php echo get_the_post_thumbnail($profile->ID)?>
								<svg viewbox="0 0 100 100">
									<circle cx="50" cy="50" r="40"/>
								</svg>
							</div>
							<div class="profile-name">
								<?php echo $profile->post_title; ?>
							</div>
						</a>
						<?php
					}
				?>
			</div>
			<?php
		}
	?>
</div>
<?php
	get_footer();
?>
