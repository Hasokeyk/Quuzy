<?php
	
	if(isset($argv[1])){
		$action = $argv[1];
		$username = $argv[2];
		
		if($action == 'userSave'){
			$run = shell_exec('/www/server/php/74/bin/php -f /www/wwwroot/quuzy.com/run/userSave.php '.$username.' 2>&1');
		}else if($action == 'postSave'){
			$run = shell_exec('/www/server/php/74/bin/php -f /www/wwwroot/quuzy.com/run/postSave.php '.$username.' 2>&1');
		}else if($action == 'privatePostSave'){
			$run = shell_exec('/www/server/php/74/bin/php -f /www/wwwroot/quuzy.com/run/privatePostSave.php '.$username.' 2>&1');
		}
		
		var_dump($run);
		
	}else{
		echo '2x2';
	}