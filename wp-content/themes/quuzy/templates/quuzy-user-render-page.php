<?php
	global $data;

	$data = json_decode($_POST['data'], true);
	$user = $data['graphql']['user'];

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

		<div class="profile-pic">
			<div class="profile-circle">
				<img src="<?php echo $user['profile_pic_url_hd']; ?>" alt="<?php echo $user['full_name']; ?>">
			</div>
		</div>

		<div class="profile-fullName">
			<?php echo $user['full_name']; ?>
		</div>

		<div class="profile-username">
			@<?php echo $user['username']; ?>
		</div>

		<div class="profile-istatistic">

			<ul>
				<li>
					<div class="count">
						<?php echo $user['edge_owner_to_timeline_media']['count']; ?>
					</div>
					<div class="text">Posts</div>
				</li>
				<li>
					<div class="count">
						<?php echo $user['edge_followed_by']['count']; ?>
					</div>
					<div class="text">Followers</div>
				</li>
				<li>
					<div class="count">
						<?php echo $user['edge_follow']['count']; ?>
					</div>
					<div class="text">Following</div>
				</li>
			</ul>

		</div>

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
		<h1><?php echo $user['full_name']; ?>'s Posts</h1>

		<?php
			if($user['is_private'] === 'true'){
				?>
				<div class="alert alert-danger">This profile is private. The contents will be loaded within 24 hours. Please visit this page again.</div>
				<?php
			}
		?>

		<div class="posts">

			<?php
				$posts = $user['edge_owner_to_timeline_media']['edges'];
				foreach($posts as $post){

					$post = $post['node'];

					$postLink         = '/';
					$postType         = $post['is_video'] == 'true'?'video':'photo';
					$postShortCode    = $post['shorcode'];
					$postLikeCount    = $post['edge_liked_by']['count'];
					$postCommentCount = $post['edge_media_to_comment']['count'];
					$postPicUrl       = $post['display_url'];
					?>
					<div class="post play <?php echo $postType; ?>" data-shortcode="<?php echo $postShortCode; ?>">
						<div class="post-img">
							<a href="<?php echo $postLink; ?>" data-fancybox="gallery">
								<img src="<?php echo $postPicUrl; ?>" alt="Hasan">
							</a>
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
				}
			?>

		</div>
	</div>

</div>