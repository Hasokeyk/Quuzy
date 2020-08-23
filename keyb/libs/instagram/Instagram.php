<?php

	Class Instagram{

		private $url		= 'https://www.instagram.com/graphql/query/';
		private $response	= false;
		private $client	    = '';
		private $cookies	= '';

		public function __construct(){
			$this->cookies	= \GuzzleHttp\Cookie\CookieJar::fromArray([
				'ig_did'				=> '70620273-5032-4DA2-95EF-D906A35D709E',
				'mid'				    => 'Xq7gOwALAAHvmT4jbP4DGU1R1yC5',
				'fbm_124024574287414'	=> '1TzwtHeW7xe_K3biJrfBTkpLQ3Vx3iaSaPd0624mdxE.eyJ1c2VyX2lkIjoiMTAwMDA4MDQzNTU2NTQ0IiwiY29kZSI6IkFRQzlNbVpNWjJZRm8tckFGb1doZHFUdjlrOHBoWEFMZHR0Z1o2SjRSN3hDcGFHdXVUOVhTTkxWQUJ4LXVkeUMtaWxUcl9sd2ZnaE9BU3Z3eDVaNHdQUDdaLU9XSS0yVGFVYjNXWHZ3YTFkY3hrLWxEM3ljMDZQeUNsWGRjMXV4T1dJdml5SlJFUTRhbE5IeTBLalFmYktIWUtjRlhhT240NXFyZGxxSzdid0ltWjVuQVVJUzNrN0h0ZmJVVFdGdTJ2TEFKU2swMFVsQXRiM0ZHVldHVDIwNmw5SFUzbHZVMGpBSEdnYnN1OXVQUGxoeFRmblVQbWRDZEdiYUkycFlkZWNZMmV1MnoxOWlzZWpXenZ3aExYekJSOVd4aGhmYXNhQTdfemZhSmJVcHNtUjFXN0tMTUJCeXM4R3lBM19jY1VicFJ2eFI3REhKN1Y4X0hwbmlGRWFWIiwib2F1dGhfdG9rZW4iOiJFQUFCd3pMaXhuallCQU45UzBrYTU3Rm54NjBkc01CWkM2V2h3T1NCWG83UFpCVVpBamh5S085QmtSaWxTQVl1WVhUeFFMS2pUR1Y3bjgzalhTdldyQkN4b2Y1WFJwR2xVTWRzaW1XN0t1bDdpN3JseEplUkJDMU9MbHRVWkFPR0J0YU1TVk4wRExpRkxvbXAzcnJ6MDlVQW9CdWRpeVpDbGhGZ0NDS09GamhvcW5pQlRWZjVzemNVaG5qRUM0UklNWkQiLCJhbGdvcml0aG0iOiJITUFDLVNIQTI1NiIsImlzc3VlZF9hdCI6MTU5MDM1NjY2MX0',
				'shbid'				    => '19110',
				'shbts'				    => '1590100434.33188',
				'datr'				    => '',
				'rur'				    => 'VLL',
				'fbsr_124024574287414'	=> '1TzwtHeW7xe_K3biJrfBTkpLQ3Vx3iaSaPd0624mdxE.eyJ1c2VyX2lkIjoiMTAwMDA4MDQzNTU2NTQ0IiwiY29kZSI6IkFRQzlNbVpNWjJZRm8tckFGb1doZHFUdjlrOHBoWEFMZHR0Z1o2SjRSN3hDcGFHdXVUOVhTTkxWQUJ4LXVkeUMtaWxUcl9sd2ZnaE9BU3Z3eDVaNHdQUDdaLU9XSS0yVGFVYjNXWHZ3YTFkY3hrLWxEM3ljMDZQeUNsWGRjMXV4T1dJdml5SlJFUTRhbE5IeTBLalFmYktIWUtjRlhhT240NXFyZGxxSzdid0ltWjVuQVVJUzNrN0h0ZmJVVFdGdTJ2TEFKU2swMFVsQXRiM0ZHVldHVDIwNmw5SFUzbHZVMGpBSEdnYnN1OXVQUGxoeFRmblVQbWRDZEdiYUkycFlkZWNZMmV1MnoxOWlzZWpXenZ3aExYekJSOVd4aGhmYXNhQTdfemZhSmJVcHNtUjFXN0tMTUJCeXM4R3lBM19jY1VicFJ2eFI3REhKN1Y4X0hwbmlGRWFWIiwib2F1dGhfdG9rZW4iOiJFQUFCd3pMaXhuallCQU45UzBrYTU3Rm54NjBkc01CWkM2V2h3T1NCWG83UFpCVVpBamh5S085QmtSaWxTQVl1WVhUeFFMS2pUR1Y3bjgzalhTdldyQkN4b2Y1WFJwR2xVTWRzaW1XN0t1bDdpN3JseEplUkJDMU9MbHRVWkFPR0J0YU1TVk4wRExpRkxvbXAzcnJ6MDlVQW9CdWRpeVpDbGhGZ0NDS09GamhvcW5pQlRWZjVzemNVaG5qRUM0UklNWkQiLCJhbGdvcml0aG0iOiJITUFDLVNIQTI1NiIsImlzc3VlZF9hdCI6MTU5MDM1NjY2MX0',
				'csrftoken'			    => 'mZmvv5VMvxe188Qm6o847ZlcKkonvl8i',
				'ds_user_id'			=> '31553132448',
				'sessionid'			    => '31553132448%3AviQp7Qq1jHQUC1%3A20',
				'urlgen'				=> '"{\"159.146.54.101\": 12735\054 \"95.70.129.57\": 12735}:1jcymu:1k8bFh5Tobx923Hb0ClJSTN9uhY"'
			], 'instagram.com');

			$this->client	= new \GuzzleHttp\Client([
				'headers'	=> [
					"Accept"			=> '*/*',
					"Accept-language"	=> 'tr,en;q=0.9',
					"Sec-Fetch-Mode"	=> 'cors',
					"Sec-Fetch-Site"	=> 'same-origin',
					"x-csrftoken"		=> 'uuvvDJrnAcaVPEGhsJ22nokKCCPHDcug',
				],
				'cookies'	=> $this->cookies,
				'allow_redirects' => false
			]);
		}

		public function search($keyword = null){
			$this->url = 'https://www.instagram.com/web/search/topsearch/?query=' . $keyword;

			try{

				$request	= new \GuzzleHttp\Psr7\Request('GET', $this->url);
				$promise	= $this->client->sendAsync($request)->then(function($response){
					$this->response = json_decode($response->getBody());
				});
				$promise->wait();

			}catch(\Exception $e){
				return $e->getMessage();
			}

			return $this->response;
		}
		
		public function profile($username = null){
			$this->url = 'https://www.instagram.com/' . $username . '/?__a=1';

			try{

				$request	= new \GuzzleHttp\Psr7\Request('GET', $this->url);
				$promise	= $this->client->sendAsync($request)->then(function($response){
					if($response->getStatusCode() == 200){
						$this->response = json_decode($response->getBody())->graphql->user;
					}else{
						$this->response = '404';
					}
				});
				$promise->wait();

			}catch(\Exception $e){
				return $e->getMessage();
			}

			return $this->response;
		}

		public function location($location_id = null, $location_slug = null){
			$this->url = 'https://www.instagram.com/explore/locations/' . $location_id . '/' . $location_slug . '/?__a=1';

			try{

				$request	= new \GuzzleHttp\Psr7\Request('GET', $this->url);
				$promise	= $this->client->sendAsync($request)->then(function($response){
					if($response->getStatusCode() == 200){
						$this->response = json_decode($response->getBody())->graphql->location;
					}else{
						$this->response = '404';
					}
				});
				$promise->wait();

			}catch(\Exception $e){
				return $e->getCode();
			}

			return $this->response;
		}

		public function tag($tag){
			$this->url = 'https://www.instagram.com/explore/tags/' . $tag . '/?__a=1';

			try{

				$request	= new \GuzzleHttp\Psr7\Request('GET', $this->url);
				$promise	= $this->client->sendAsync($request)->then(function($response){
					if($response->getStatusCode() == 200){
						$this->response = json_decode($response->getBody())->graphql->hashtag;
					}else{
						$this->response = '404';
					}
				});
				$promise->wait();

			}catch(\Exception $e){
				return $e->getCode();
			}

			return $this->response;
		}

		public function post($shortcode = null){
			$this->url = 'https://www.instagram.com/p/' . $shortcode . '/';

			$variables['shortcode']			= (isset($shortcode)) ? $shortcode : null;

			try{

				$request	= new \GuzzleHttp\Psr7\Request('GET', $this->url);
				$promise	= $this->client->sendAsync($request)->then(function($response){
					if($response->getStatusCode() == 200){
						$regExp	= '/<script type="text\/javascript">window\.__additionalDataLoaded\(\'(.*?)\',(.*?)\);<\/script>/m';
						$response	= $response->getBody();
						preg_match_all($regExp, $response, $result, PREG_SET_ORDER, 0);
						$this->response = json_decode($result[0][2])->graphql->shortcode_media;
					}else{
						$this->response = 'private';
					}
				});
				$promise->wait();

			}catch(\Exception $e){
				return $e->getCode();
			}

			return $this->response;
		}

		public function follow($id = null){
			$this->url = 'https://www.instagram.com/web/friendships/' . $id . '/follow/';

			try{

				$request	= new \GuzzleHttp\Psr7\Request('POST', $this->url);
				$promise	= $this->client->sendAsync($request)->then(function($response){
					$this->response = json_decode($response->getBody());
					return 4;
				});
				$promise->wait();

				return $request;

			}catch(\Exception $e){
				return $e->getMessage();
			}
			return 3;
		}

		public function highlights($query_hash = null, $opt = []){
			$this->url .= '?query_hash=' . $query_hash;

			$variables['user_id']					    = (isset($opt['user_id']))					    ? $opt['user_id']					: null;
			$variables['include_chaining']			    = (isset($opt['include_chaining']))			    ? $opt['include_chaining']			: true;
			$variables['include_reel']				    = (isset($opt['include_reel']))				    ? $opt['include_reel']				: true;
			$variables['include_suggested_users']		= (isset($opt['include_suggested_users']))		? $opt['include_suggested_users']	: false;
			$variables['include_logged_out_extras']		= (isset($opt['include_logged_out_extras']))	? $opt['include_logged_out_extras']	: false;
			$variables['include_highlight_reels']		= (isset($opt['include_highlight_reels']))		? $opt['include_highlight_reels']	: true;
			$variables['include_related_profiles']		= (isset($opt['include_related_profiles']))		? $opt['include_related_profiles']	: false;

			$this->url .= '&variables=' . urlencode(json_encode($variables));

			try{

				$request	= new \GuzzleHttp\Psr7\Request('GET', $this->url);
				$promise	= $this->client->sendAsync($request)->then(function($response){
					$this->response = json_decode($response->getBody())->data->user->edge_highlight_reels->edges;
				});
				$promise->wait();

			}catch(\Exception $e){
				return $e->getMessage();
			}

			return $this->response;
		}

		public function stories($query_hash = null, $opt = []){
			$this->url .= '?query_hash=' . $query_hash;

			$variables['reel_ids']					= (isset($opt['reel_ids']))					? $opt['reel_ids']					: [];
			$variables['tag_names']					= (isset($opt['tag_names']))					? $opt['tag_names']					: [];
			$variables['location_ids']				= (isset($opt['location_ids']))				? $opt['location_ids']				: [];
			$variables['highlight_reel_ids']			= (isset($opt['highlight_reel_ids']))			? $opt['highlight_reel_ids']			: [];
			$variables['precomposed_overlay']			= (isset($opt['precomposed_overlay']))			? $opt['precomposed_overlay']			: false;
			$variables['show_story_viewer_list']		= (isset($opt['show_story_viewer_list']))		? $opt['show_story_viewer_list']		: true;
			$variables['story_viewer_fetch_count']		= (isset($opt['story_viewer_fetch_count']))		? $opt['story_viewer_fetch_count']		: 50;
			$variables['story_viewer_cursor']			= (isset($opt['story_viewer_cursor']))			? $opt['story_viewer_cursor']			: '';
			$variables['stories_video_dash_manifest']	= (isset($opt['stories_video_dash_manifest']))	? $opt['stories_video_dash_manifest']	: false;

			$this->url .= '&variables=' . urlencode(json_encode($variables));

			try{

				$request	= new \GuzzleHttp\Psr7\Request('GET', $this->url);
				
				$promise	= $this->client->sendAsync($request)->then(function($response){
					
					$storiesArray	= [];
					$stories		= json_decode($response->getBody());
					foreach($stories->data->reels_media as $story){
						$storyItems = [];

						foreach($story->items as $item){
							$itemType		= ($item->is_video) ? 'video' : 'photo';
							$itemSrc		= ($itemType == 'video') ? (isset($item->video_resources)) ? current(end($item->video_resources)) : '' : $item->display_url;
							$itemDuration	= (isset($item->video_duration)) ? $item->video_duration : 3;
							$itemLink		= (isset($item->story_cta_url)) ? $item->story_cta_url : false;
							$storyItems[]	= [
								'id'			=> $item->id,
								'type'		=> $itemType,
								'length'		=> $itemDuration,
								'src'		=> $itemSrc,
								'preview'		=> $item->display_url,
								'link'		=> $itemLink,
								'linkText'	=> 'See More',
								'time'		=> $item->taken_at_timestamp,
								'seen'		=> false
							];
						}

						$storiesArray[]	= [
							'id'			=> $story->id,
							'photo'		=> $story->owner->profile_pic_url,
							'name'		=> $story->owner->username,
							'link'		=> $story->owner->profile_pic_url,
							'lastUpdated'	=> $story->latest_reel_media,
							'seen'		=> false,
							'items'		=> $storyItems
						];

					}

					$this->response = $storiesArray;

				});

				$promise->wait();
	
			}catch(\Exception $e){
				return $e->getMessage();
			}

			return $this->response;

		}

		public function __destruct(){}

	}
