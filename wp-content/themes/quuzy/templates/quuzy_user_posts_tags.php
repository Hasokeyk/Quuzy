<?php
	get_header();

	$termId = get_term_by('slug', get_query_var('term'), get_query_var('taxonomy'))->term_id;

	get_sidebar();
?>
<div class="container">

	<div class="profile-content">

		<div class="profile-posts">
			<h1><?php echo single_tag_title(); ?> Tag Post Lists</h1>

			<div class="profile-desc">
				<p><?php the_content(); ?></p>
			</div>

			<?php
				if(get_post_meta(get_the_ID(), 'private', true) == '1'){
					?>
					<div class="alert alert-danger">This profile is private. The contents will be loaded within 24 hours. Please visit this page again.</div>
					<?php
				}else{
					?>
					<div class="posts">

						<?php

							$posts = get_posts([
								'post_type'      => 'quuzy_user_posts',
								'post_status'    => 'publish',
								's'              => single_tag_title("", false),
								'posts_per_page' => -1,
							]);

							$ads = 0;
							foreach($posts as $post){
								$postLink         = get_permalink($post->ID);
								$postType         = get_post_meta($post->ID, 'post_type', true)??'photo';
								$postShortCode    = get_post_meta($post->ID, 'post_shortcode', true);
								$postLikeCount    = thousandsCurrencyFormat(get_post_meta($post->ID, 'post_like_count', true));
								$postCommentCount = thousandsCurrencyFormat(get_post_meta($post->ID, 'post_comment_count', true));
								?>
								<div class="post play <?php echo $postType; ?>" data-shortcode="<?php echo $postShortCode; ?>">
									<div class="post-img">
										<?php
											if($postType == 'photo'){
												?>
												<a href="<?php echo $postLink; ?>" data-fancybox="gallery">
													<?php
														if(has_post_thumbnail($post->ID)){
															echo get_the_post_thumbnail($post->ID);
														}
													?>
												</a>
												<?php
											}else{
												if(has_post_thumbnail($post->ID)){
													echo get_the_post_thumbnail($post->ID);
												}
											}
										?>
									</div>
									<div class="post-info">
										<div class="post-info-detail">
											<ul>
												<li>
													<div class="icon"><i class="fas fa-heart"></i></div>
													<div class="text"><?php echo $postLikeCount; ?></div>
												</li>
												<li>
													<div class="icon"><i class="fal fa-comment"></i></div>
													<div class="text"><?php echo $postCommentCount; ?></div>
												</li>
												<li class="download-btn">
													<div class="icon"><i class="fas fa-download"></i></div>
													<div class="text">
														<a href="<?php echo $postLink; ?>" download="<?php echo $postShortCode; ?>.png">Download</a>
													</div>
												</li>
											</ul>
										</div>
									</div>
								</div>
								<?php
								if($ads%6 == 0){
									?>
									<div class="post ads">
										<div class="post-img">
											<!-- Profile Detay - 300*300 -->
											<ins
												class="adsbygoogle"
												style="display:inline-block;width:300px;height:300px"
												data-ad-client="ca-pub-9896875941850273"
												data-ad-slot="6237119990"></ins>
											<script>
                                                (adsbygoogle = window.adsbygoogle || []).push({});
											</script>
										</div>
									</div>
									<?php
								}
								$ads++;

							}
						?>

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
