<?php

ini_set('session.save_path', sys_get_temp_dir());
session_start();

if (!isset($_SESSION['history'])){
	$_SESSION['history'] = '11111111';
}

$pressed = intval($_POST['p']);

$_SESSION['history'] = substr($_SESSION['history'], 1).strval($pressed);
switch ($pressed){
	case 1:
		$message = 'a';
		break;
	case 2:
		$message = 'b';
		break;
	case 3:
		$message = 'c';
		break;
	case 4:
		$message = 'd';
		break;
	case 5:
		$message = 'e';
		break;
	case 6:
		$message = 'f';
		break;
	case 7:
		$message = 'g';
		break;
	case 8:
		$message = 'h';
		break;	
}
$progress1 = substr($_COOKIE['finale'], 5, 5);

echo $message;

?>