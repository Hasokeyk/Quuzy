<?php
	get_header();

	$termId = get_term_by( 'slug', get_query_var( 'term' ), get_query_var( 'taxonomy' ) )->term_id;

?>

<div class="sidebar">

	<div class="logo">
		<div class="icon">
			<i class="fab fa-instagram"></i>
		</div>
		<div class="text">
			Quuzy
		</div>
	</div>

	<div class="profile-info">

		<div class="profile-menu">

			<ul>
				<li>
					<a href="/">
						<div class="icon">
							<i class="fal fa-home"></i>
						</div>
						<div class="text">
							Home
						</div>
					</a>
				</li>
				<li class="active">
					<div class="icon">
						<i class="fal fa-tasks-alt"></i>
					</div>
					<div class="text">
						Feed
					</div>
				</li>
				<li>
					<div class="icon">
						<i class="fal fa-portrait"></i>
					</div>
					<div class="text">
						Stories
					</div>
				</li>
				<li>
					<div class="icon">
						<i class="fal fa-tv-retro"></i>
					</div>
					<div class="text">
						IGTV
					</div>
				</li>
			</ul>

		</div>

	</div>

</div>

<div class="profile-content">

	<div class="profile-posts">
		<h1><?php
				echo single_tag_title(); ?> Tags Post Lists</h1>

		<div class="posts">

			<?php

				$posts = get_posts( [
					'post_type'   => 'quuzy_user_posts',
					'post_status' => 'publish',
					'tax_query'   => [
						[
							'taxonomy' => 'quuzy_user_posts_tags',
							'field'    => 'id',
							'terms'    => $termId,
						],
					],
				] );

				foreach ( $posts as $post ) {
					$postLink         = get_permalink( $post->ID );
					$postType         = get_post_meta( $post->ID, 'post_type', true );
					$postShortCode    = get_post_meta( $post->ID, 'post_shortcode', true );
					$postLikeCount    = get_post_meta( $post->ID, 'post_like_count', true );
					$postCommentCount = get_post_meta( $post->ID, 'post_comment_count', true );
					?>
					<div
						class="post play <?php
							echo $postType; ?>" data-shortcode="<?php
						echo $postShortCode; ?>">
						<div class="post-img">
							<?php
								if ( $postType == 'photo' ) {
									?>
									<a
										href="<?php
											echo $postLink; ?>" data-fancybox="gallery">
										<?php
											if ( has_post_thumbnail( $post->ID ) ) {
												echo get_the_post_thumbnail( $post->ID );
											}
										?>
									</a>
									<?php
								} else {
									if ( has_post_thumbnail( $post->ID ) ) {
										echo get_the_post_thumbnail( $post->ID );
									}
								}
							?>
						</div>
						<div class="post-info">
							<div class="post-info-detail">
								<ul>
									<li>
										<div class="icon"><i class="fas fa-heart"></i></div>
										<div class="text"><?php
												echo $postLikeCount; ?></div>
									</li>
									<li>
										<div class="icon"><i class="fal fa-comment"></i></div>
										<div class="text"><?php
												echo $postCommentCount; ?></div>
									</li>
									<li class="download-btn">
										<div class="icon"><i class="fas fa-download"></i></div>
										<div class="text"><a
												href="<?php
													echo $postLink; ?>" download="<?php
												echo $postShortCode; ?>.png">Download</a></div>
									</li>
								</ul>
							</div>
						</div>
					</div>
					<?php
				}
			?>

		</div>
	</div>

</div>


<?php
	get_footer();
?>
