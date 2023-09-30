<?php

if(!isset($_COOKIE['finale'])){
	header('Location:https://thestringharmony.com/xxxxxx/abcde.php');
	die();
}

$universe = substr($_COOKIE['finale'], 0, 5);
$remaining = substr($_COOKIE['finale'], 5);
$first = ($universe == '12345') && (strlen($_COOKIE['finale']) == 8);
if($first){
	$remaining = '000000000000'.$remaining;
}

if(isset($_POST['traverse'])){
	if($universe == '12345'){
		setcookie("finale", '67890'.$remaining, [
			'expires' => (time() + 31536000),
			'path' => "/",
			'domain' => ".thestringharmony.com",
			'secure' => true,
			'httponly' => false,
			'samesite' => 'None',
		]);
		$universe = '67890';
		$first = false;
	}elseif($universe == '67890'){
		setcookie("finale", '12345'.$remaining, [
			'expires' => (time() + 31536000),
			'path' => "/",
			'domain' => ".thestringharmony.com",
			'secure' => true,
			'httponly' => false,
			'samesite' => 'None',
		]);
		$universe = '12345';
	}elseif($universe == '13579'){
		header('Location:https://thestringharmony.com/xxxxxx/klmno.php');
		die();
	}
}

?>
<!DOCTYPE html>
<html>
	<head> 
		<title>Welcome to The String Harmony's Forbidden Enrichment Center</title>
		<link rel="stylesheet" type="text/css" href="../../level.css">
	</head>
	<body>
		<div align="center">
		<audio id="bgm" src="portal.mp3" autoplay loop></audio><!-- prior knowledge about Portal is not required in this level -->
		<?php if($first){ ?>
		<audio id="glados" src="glados.mp3"></audio>
		<img id="scene" src="?????.jpg" width="640" height="480" usemap="#portal">
		<map name="portal">
			<area id="door" href="#" coords="0,0,0,0" shape="rect">
		</map>
		<?php }elseif($universe == '67890'){ ?>
		<img id="scene" src="?????.jpg" width="640" height="480" usemap="#portal">
		<map name="portal">
			<area id="door" href="#" coords="210,80,430,400" shape="rect">
		</map>
		<p><?php if (substr($remaining, 0, 5) == '00000'){echo 'Nice job! Now feel free to explore this parallel universe. Perhaps start with your home?';} ?></p>
		<?php }elseif($universe == '13579'){ ?>
		<img id="scene" src="?????.jpg" width="640" height="480" usemap="#portal">
		<map name="portal">
			<area id="door" href="#" coords="210,80,430,400" shape="rect">
		</map>
		<?php }else{ ?>
		<img id="scene" src="?????.jpg" width="640" height="480" usemap="#portal">
		<map name="portal">
			<area id="door" href="#" coords="210,80,430,400" shape="rect">
		</map>
		<?php } ?>
		<script src="fghij.js"></script>
		</div> 
	</body>
</html>

<!-- viewing the source code of this page may trigger the portal - always double check which universe you are in -->