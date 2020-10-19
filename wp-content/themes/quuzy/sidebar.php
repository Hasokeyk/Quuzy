<?php
	global $userID;
?>
<div class="sidebar">

	<div class="logo">
		<i class="fab fa-instagram"></i>
		<a href="/">Quuzy</a>
	</div>

	<?php
		if(isset($userID) and !empty($userID)){
			require "sidebar-user.php";
		}else{

		}
	?>

</div>