<?php
	get_header();

	$userID = get_post_meta(get_the_ID(),'sub_quuzy_user_id',true);

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
				<?php
					if ( has_post_thumbnail($userID) ) {
						echo get_the_post_thumbnail($userID);
					} else {
						echo 3;
					}
				?>
			</div>
		</div>

		<div class="profile-fullName">
			<?php
				echo get_post_meta( $userID, 'full_name', true );
			?>
		</div>

		<div class="profile-username">
			@<?php
				echo sanitize_title( get_the_title($userID) );
			?>
		</div>

		<div class="profile-istatistic">

			<ul>
				<li>
					<div class="count">
						<?php
							echo thousandsCurrencyFormat(get_post_meta( $userID, 'post_count', true ));
						?>
					</div>
					<div class="text">Posts</div>
				</li>
				<li>
					<div class="count">
						<?php
							echo thousandsCurrencyFormat(get_post_meta( $userID, 'followers_count', true ));
						?>
					</div>
					<div class="text">Followers</div>
				</li>
				<li>
					<div class="count">
						<?php
							echo thousandsCurrencyFormat(get_post_meta( $userID, 'following_count', true ));
						?>
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
		<h1><?php
				echo get_the_title(); ?>'s Posts</h1>

		<?php
			if ( get_post_meta( get_the_ID(), 'private', true ) == '1' ) {
				?>
				<div class="alert alert-danger">This profile is private. The contents will be loaded within 24 hours. Please visit this page again.</div>
				<?php
			}
		?>

		<div class="posts">

			<?php the_content(); ?>

		</div>
	</div>

</div>


<?php
	get_footer();
?>
