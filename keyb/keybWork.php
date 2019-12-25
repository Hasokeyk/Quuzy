<?php

    /*
        Hasan Yüksektepe
        29.10.2019
        hasanhasokeyk@hotmail.com
    */

    class keybWork{

        public $page = 'home';
        public $pageInfo = null;

        function __construct(){
            global $mysqli;

            $get = $this->getSecurity($_GET);
            extract($get);
            $post = $this->postSecurity($_POST);
            extract($post);

            $urlParse = $this->urlParse();

            if($urlParse['folder'] == 'ajax' and isset($_SERVER['HTTP_X_REQUESTED_WITH'],$_SERVER['HTTP_REFERER']) and $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest' and $_SERVER['HTTP_ORIGIN'] == 'https://quuzy.com'){
                require THEMEDIR.'ajax/'.$urlParse['subFolder'].'.php';
                exit;
            }else if(substr($urlParse['folder'],0,7) == 'sitemap'){
                require THEMEDIR.'sitemap.php';
                exit;
            }else if($urlParse['fullLink'] == '/'){
                goto nonControl;
            }else if(!isset($urlParse['subFolder']) and empty($urlParse['subFolder'])){
                $sql = "SELECT * FROM seolinks WHERE url = '".$urlParse['subFolder']."'";
            }else if(isset($urlParse['subFolder']) and !empty($urlParse['subFolder'])){
                $sql = "SELECT * FROM seolinks WHERE url = '".$urlParse['subFolder']."'";
            }else if(isset($urlParse['folder']) and !empty($urlParse['folder'])){
                $sql = "SELECT * FROM seolinks WHERE url = '".$urlParse['folder']."'";
            }

            //VERİTABANINDA VAR MI?
            
            $ask = $mysqli->query($sql);
            if($ask->num_rows > 0){
                $info       = $ask->fetch_assoc();
                $this->pageInfo = $info;
                $this->page =  $info['template'];
            }else{
                $this->page = '404';
            }
            //VERİTABANINDA VAR MI?

            nonControl:
            //SAYFANIN YOK İSE 404 DÜŞSÜN
			if(!file_exists(THEMEDIR.$this->page.'.php')){
                require THEMEDIR.'404.php';
                exit;
			}else{
				$htmlName = md5($_SERVER['REQUEST_URI']).'.html';
				if(file_exists(ROOT.'/cache/html/'.$htmlName)){
					echo file_get_contents(ROOT.'/cache/html/'.$htmlName);
					exit;
				}else{
					ob_start();
					require THEMEDIR.$this->page.'.php';
					$html = ob_get_contents();
					ob_clean();
					file_put_contents(ROOT.'/cache/html/'.$htmlName, $html);
					echo $html;
					exit;
				}
			}
			//SAYFANIN YOK İSE 404 DÜŞSÜN

        }

        private function urlParse(){

            $url = parse_url($_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
            $path = explode('/',ltrim($url['path'],'/'));
            
            return [
                'data' => $url,
                'fullLink' => $_SERVER['REQUEST_URI'],
                'folder' => $path[0],
                'subFolder' => $path[1]??null,
                'subSubFolder' => $path[2]??null,
            ];

        }

        public function getSecurity($get){
			global $mysqli;
			$degerler = array();
			foreach($get as $p => $d){
				if(is_string($_GET[$p]) === true){
					$degerler[$p] = trim(strip_tags($mysqli->escape_string($d)));
				}
			}
			return $degerler;
		}
		
		public function postSecurity($post){
			global $mysqli;
			$degerler = array();
			foreach($post as $p => $d){
				if(is_string($_POST[$p]) === true){
					$degerler[$p] = trim(strip_tags($mysqli->escape_string($d)));
				}
			}
			return $degerler;
		}

        function seoTitle(){
            global $mysqli;
            
            $settings = $mysqli->query("SELECT * FROM settings WHERE keywords = '".($this->pageInfo['template']??'home')."' AND type='seo-title'");
            if($settings->num_rows > 0){
                $settingsInfo = $settings->fetch_assoc();
                $title = $settingsInfo['value'];
            }else{
                $title = $this->pageInfo['template'];
            }

            $title = $this->pageInfo['title']??$title;

            if($this->pageInfo['template'] == 'profile-detail'){
                $user = $mysqli->query("SELECT * FROM users WHERE username = '".$this->pageInfo['url']."'");
                if($user->num_rows > 0){
                    $userInfo = $user->fetch_assoc();
                }

                $seo = [
                    '-{USERNAME}-' => $userInfo['username'],
                    '-{USERFULLNAME}-' => $userInfo['fullName'],
                    '-{SITENAME}-' => 'Quuzy',
                ];
            }

            $outPut = $title;
            if(isset($seo)){
                foreach($seo as $paramter => $val){
                    $outPut = str_replace($paramter,$val,$outPut);
                }
            }
            return $outPut;

        }
        function seoDesc(){
            global $mysqli;
            
            $settings = $mysqli->query("SELECT * FROM settings WHERE keywords = '".($this->pageInfo['template']??'home')."' AND type='seo-desc'");
            if($settings->num_rows > 0){
                $settingsInfo = $settings->fetch_assoc();
                $title = $settingsInfo['value'];
            }else{
                $title = $this->pageInfo['template'];
            }

            $title = $this->pageInfo['title']??$title;

            if($this->pageInfo['template'] == 'profile-detail'){
                $user = $mysqli->query("SELECT * FROM users WHERE username = '".$this->pageInfo['url']."'");
                if($user->num_rows > 0){
                    $userInfo = $user->fetch_assoc();
                }

                $seo = [
                    '-{USERNAME}-' => $userInfo['username'],
                    '-{USERFULLNAME}-' => $userInfo['fullName'],
                    '-{SITENAME}-' => 'Quuzy',
                ];
            }

            $outPut = $title;
            if(isset($seo)){
                foreach($seo as $paramter => $val){
                    $outPut = str_replace($paramter,$val,$outPut);
                }
            }
            return $outPut;
        }
    }