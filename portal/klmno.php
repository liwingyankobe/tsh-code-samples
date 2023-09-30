<?php

if (!isset($_COOKIE['finale'])){
	header('Location:https://thestringharmony.com/xxxxxx/fghij.php');
	die();
}

$universe = substr($_COOKIE['finale'], 0, 5);
if ($universe != '13579'){
	header('Location:https://thestringharmony.com/xxxxxx/fghij.php');
	die();
}
$progress1 = substr($_COOKIE['finale'], 5, 5);

if (isset($_POST['passcode'])){
	if ($_POST['passcode'] == '???' && $progress1 == '11111'){
		cookie('22222', 5);
		$progress1 = '22222';
	}
}

if (isset($_POST['activate'])){
	if ($progress1 == '22222'){
		cookie('33333', 5);
		$progress1 = '33333';
	}
}

?>
<!DOCTYPE html>
<html>
	<head> 
		<title>Enrichment Center Management System</title>
		<link rel="stylesheet" type="text/css" href="../../level.css">
	</head>
	<body>
		<div align="center">
		<audio id="bgm" src="portal.mp3" autoplay loop></audio>
		<?php if ($progress1 == false){ ?>
		You have lost your progress. Go back and fix it.
		<?php }elseif ($progress1 == '11111'){ ?>
		Welcome to the Enrichment Center Management System!<br>
		Please enter the passcode to proceed:<br><br>
		<form method="POST" id="pass">
			<input type="text" name="passcode">
		</form>
		<!-- missing a button? why not make one by yourself? -->
		<?php
		}else{
			if ($progress1 == '22222'){
				echo '<img src="?????.jpg" usemap="#map">';
			}elseif ($progress1 == '33333'){
				echo '<img src="?????.jpg" usemap="#map">';
			}
		?>
		<map name="map">
			<area id="11" coords="53,53,88,88" shape="rect">
			<area id="12" coords="142,53,177,88" shape="rect">
			<area id="13" coords="231,53,266,88" shape="rect">
			<area id="14" coords="53,142,88,177" shape="rect">
			<area id="blue" coords="142,142,177,177" shape="rect">
			<area id="15" coords="231,142,266,177" shape="rect">
			<area id="16" coords="53,231,88,266" shape="rect">
			<area id="17" coords="142,231,177,266" shape="rect">
			<area id="18" coords="231,231,266,266" shape="rect">
			<area id="21" coords="531,53,566,88" shape="rect">
			<area id="22" coords="620,53,655,88" shape="rect">
			<area id="23" coords="709,53,744,88" shape="rect">
			<area id="24" coords="531,142,566,177" shape="rect">
			<area id="green" coords="620,142,655,177" shape="rect">
			<area id="25" coords="709,142,744,177" shape="rect">
			<area id="26" coords="531,231,566,266" shape="rect">
			<area id="27" coords="620,231,655,266" shape="rect">
			<area id="28" coords="709,231,744,266" shape="rect">
			<area id="red" coords="383,373,416,406" shape="rect">
			<?php if ($progress1 == '22222'){ ?>
			<area id="activate" href="#" coords="310,88,503,143" shape="rect">
			<?php } ?>
		</map>
		<!-- same notation for both blue and green -->
		<p id="msg">
		<?php
		if ($progress1 == '22222'){
			echo 'Error: Entanglement not activated.';
		}elseif (isset($_POST['activate'])){
			echo 'Entanglement activated. New activities found.';
		}
		?>
		</p>
		<?php } ?>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/3.1.2/rollups/aes.js"></script>
		<script src="klmno.js"></script>
		</div> 
	</body>
</html>