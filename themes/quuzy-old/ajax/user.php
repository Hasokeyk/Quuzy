<?php 

    if(isset($action,$type,$user) and $action == 'userSave'){
    	
    	$username = json_decode($_POST['user'])->graphql->user->username;
	    $results = shell_exec('/www/server/php/74/bin/php -f /www/wwwroot/quuzy.com/run.php userSave '.$username);
        //$results = userSave(json_decode($_POST['user']),$type);
        //$results = userPostSave(json_decode($_POST['user']),$type);
        if($results){
            $results = [
                'status' => 'success'
            ];
        }else{
            $results = [
                'status' => 'danger'
            ];
        }
        
	    $htmlName = md5('/instagram/'.$username).'.html';
	    @unlink(ROOT.'/cache/html/'.$htmlName);

    }else if(isset($action,$type,$user) and $action == 'userPostSave'){
	
	    $username = json_decode($_POST['user'])->graphql->user->username;
	    $isPrivate = json_decode($_POST['user'])->graphql->user->is_private;
	    //$results = shell_exec('/www/server/php/74/bin/php -f /www/wwwroot/quuzy.com/run.php userSave '.$username);
        //if($results){
	    
	        if($isPrivate == true){
		        $results = shell_exec('/www/server/php/74/bin/php -f /www/wwwroot/quuzy.com/run.php privatePostSave '.$username);
	        }else{
		        $results = shell_exec('/www/server/php/74/bin/php -f /www/wwwroot/quuzy.com/run.php postSave '.$username);
	        }
	        
        	if($results){
	            $results = [
	                'status' => 'success'
	            ];
	        }else{
	            $results = [
	                'status' => 'danger'
	            ];
	        }
        //}else{
        //	$results = [
        //        'status' => 'danger'
        //    ];
        //}
	
	    $htmlName = md5('/instagram/'.$username).'.html';
	    @unlink(ROOT.'/cache/html/'.$htmlName);
        
    }else{
        $results = [
            'status' => 'danger',
            'message' => 'Parametre Hatası',
        ];
    }

    echo json_encode($results);