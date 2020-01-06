<?php
	require THEMEDIR."header.php";
?>
	<section class="home">

		<?php
			include "sidebar.php";
		?>

		<div class="home-content">

			<div class="last-posts">

				<h2>Last Posts</h2>

				<div class="posts">

					<?php
						$posts = $mysqli->query("SELECT
														    *
														FROM
														    userposts AS UP
														ORDER BY
														    RAND()
														DESC
														LIMIT 50");
						if($posts->num_rows > 0){
							$ads = 0;
							while($post = $posts->fetch_assoc()){
								?>
								<div  class="post">
									<div class="post-img">
										<a href="/instagram/<?=$post['username']?>/"><img src="/img/p/<?=$post['shortcode']?>/" alt="<?=$post['description']?>"/></a>
									</div>
									<div class="post-desc" style="display:none">
										<p>
											<?=linker($post['description'])?>
										</p>
									</div>
									<div class="post-info">
										<div class="post-info-detail">
											<ul>
												<li>
													<div class="icon"><i class="fas fa-heart"></i></div>
													<div class="text"><?=thousandsCurrencyFormat($post['likeCount'])?></div>
												</li>
												<li>
													<div class="icon"><i class="fal fa-comment"></i></div>
													<div class="text"><?=thousandsCurrencyFormat($post['commentCount'])?></div>
												</li>
												<li class="download-btn">
													<div class="icon"><i class="fas fa-download"></i></div>
													<div class="text"><a href="/img/p/<?=$post['shortcode']?>/" download="<?=$post['shortcode']?>.png">Download</a></div>
												</li>
											</ul>
										</div>
									</div>
								</div>
								<?php
								if($ads % 9 == 0){
									?>
									<div class="post ads">
										<div class="post-img">
											<script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
											<!-- Quuzy - 300 -->
											<ins class="adsbygoogle"
											     style="display:inline-block;width:300px;height:300px;max-height:300px;"
											     data-ad-client="ca-pub-9896875941850273"
											     data-ad-slot="3060216022"></ins>
											<script>
                                                (adsbygoogle = window.adsbygoogle || []).push({});
											</script>
										</div>
										<div class="post-desc" style="display:none">
											<p>
												<?=linker($post['description'])?>
											</p>
										</div>
										<div class="post-info">
											<div class="post-info-detail">
												<ul>
													<li>
														<div class="icon"><i class="fas fa-heart"></i></div>
														<div class="text"><?=thousandsCurrencyFormat(rand(111,9999))?></div>
													</li>
													<li>
														<div class="icon"><i class="fal fa-comment"></i></div>
														<div class="text"><?=thousandsCurrencyFormat(rand(111,9999))?></div>
													</li>
												</ul>
											</div>
										</div>
									</div>
									<?php
								}
								$ads++;
							}
						}
					?>

				</div>

			</div>

		</div>

	</section>
<?php
	require THEMEDIR."footer.php";
?>