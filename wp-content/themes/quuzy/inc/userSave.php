<?php

	require (__DIR__)."/../../../../wp-config.php";

	global $wpdb;

	$data = json_decode(stripcslashes($_POST['data']), true);
	$user = $data['graphql']['user'];

	$username       = mb_convert_case($user['username'], MB_CASE_TITLE, 'utf8');
	$fullName       = $user['full_name'];
	$biography      = $user['biography'];
	$postCount      = $user['edge_owner_to_timeline_media']['count'];
	$followedCount  = $user['edge_followed_by']['count'];
	$followingCount = $user['edge_follow']['count'];
	$isPrivate      = $user['is_private'] == 'true'?'1':'0';
	$profilePic     = $user['profile_pic_url_hd'];

	$userCheck = $wpdb->get_results("SELECT * FROM quzy_posts WHERE post_title = '".$username."'");
	if($userCheck == null){

		//USER SAVE
		$userSave = wp_insert_post([
			'post_type'    => 'quuzy_users',
			'post_title'   => $username,
			'post_content' => $biography,
			'post_status'  => 'publish',
		]);

		add_post_meta($userSave, 'full_name', $fullName);
		add_post_meta($userSave, 'followers_count', $followedCount);
		add_post_meta($userSave, 'following_count', $followingCount);
		add_post_meta($userSave, 'post_count', $postCount);
		add_post_meta($userSave, 'private', $isPrivate);

		Generate_Featured_Image($profilePic, $userSave, $username);

		$tags = hastag_list($biography);
		foreach($tags[1] as $tag){

			$term = term_exists($tag, 'quuzy_users_tags');
			if($term == null){
				wp_insert_term($tag,   // the term
					'quuzy_users_tags', // the taxonomy
				);
				wp_set_post_terms($userSave, $tag, 'quuzy_users_tags');
			}

		}
		//USER SAVE

		//POST SAVE
		$posts = $user['edge_owner_to_timeline_media']['edges'];
		foreach($posts as $post){

			$post = $post['node'];

			$postType         = $post['is_video'] == 'true'?'video':'photo';
			$postShortCode    = $post['shortcode'];
			$postLikeCount    = $post['edge_liked_by']['count'];
			$postCommentCount = $post['edge_media_to_comment']['count'];
			$postPicUrl       = $post['display_url'];
			$postDesc         = $post['edge_media_to_caption']['edges'][0]['node']['text'];

			$userPostSave = wp_insert_post([
				'post_type'    => 'quuzy_user_posts',
				'post_title'   => $username.' '.$postShortCode,
				'post_status'  => 'publish',
				'post_content' => $postDesc,
			]);

			add_post_meta($userPostSave, 'post_comment_count', $postCommentCount);
			add_post_meta($userPostSave, 'post_like_count', $postLikeCount);
			add_post_meta($userPostSave, 'post_shortcode', $postShortCode);
			add_post_meta($userPostSave, 'post_type', $postType);
			add_post_meta($userPostSave, 'sub_quuzy_user_id', $userSave);

			Generate_Featured_Image($postPicUrl, $userPostSave, $username.'-'.$postShortCode);

			$tags = hastag_list($postDesc);
			foreach($tags[1] as $tag){

				$term = term_exists($tag, 'quuzy_user_posts_tags');
				if($term == null){
					wp_insert_term($tag,   // the term
						'quuzy_user_posts_tags', // the taxonomy
					);
					wp_set_post_terms($userPostSave, $tag, 'quuzy_user_posts_tags');
				}

			}

		}
		//POST SAVE

	}else{
		echo 2;
	}

	function Generate_Featured_Image($image_url, $post_id, $username){
		$upload_dir = wp_upload_dir();
		$image_data = file_get_contents($image_url);
		$filename   = $username.'.jpg';
		if(wp_mkdir_p($upload_dir['path'])){
			$file = $upload_dir['path'].'/'.$filename;
		}else{
			$file = $upload_dir['basedir'].'/'.$filename;
		}
		file_put_contents($file, $image_data);

		$wp_filetype = wp_check_filetype($filename, null);
		$attachment  = [
			'post_mime_type' => $wp_filetype['type'],
			'post_title'     => sanitize_file_name($filename),
			'post_content'   => '',
			'post_status'    => 'inherit',
		];
		$attach_id   = wp_insert_attachment($attachment, $file, $post_id);
		require_once(ABSPATH.'wp-admin/includes/image.php');
		$attach_data = wp_generate_attachment_metadata($attach_id, $file);
		$res1        = wp_update_attachment_metadata($attach_id, $attach_data);
		$res2        = set_post_thumbnail($post_id, $attach_id);
	}