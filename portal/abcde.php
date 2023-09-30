<?php

$answers = array(
	'525eca1d50892835aefc910310c5e0bc23fbaa23ee026c0e224c2b45490e5f29',
	'9cf4322ed6b133f282791747364fb4dbab129ddfecab547643b2e1f04f277424',
	'4e0f7fa2672781eefdccabbe2ce0dab5ce84b0af03ab3114a6196be60b0877bb',
	'5416b64f8956927e94969f1a73859103beef1dd8d0750f50c45bea190f13b706',
	'16e12a091c5930184c19bdf10f83852d5d1a4bf1a60a11935c83692262331f37',
	'855c80b31f4d6f46101cff8e6fabc39018856bbb765967210f42a7e16daabc1f',
	'd10cb5a2bc8aeefd324ab0cd17b464dd2992ac4dfb9a02a65aa965e8b1490d29',
	'e83693190ba410f19e6d9ac226c27e1cc2eef83921acd748557686b8d3fc2e57'
);

if(isset($_POST['reset'])){
	setcookie("finale", $_COOKIE['finale'], [
		'expires' => 1,
		'path' => "/",
		'domain' => ".thestringharmony.com",
		'secure' => true,
		'httponly' => false,
		'samesite' => 'None',
	]);
	header('Location:https://thestringharmony.com/xxxxxx/abcde.php');
	die();
}

if(($_POST['level1'] != $_POST['level2']) && ($_POST['level2'] != $_POST['level3']) && ($_POST['level3'] != $_POST['level1'])){
	$level1 = intval($_POST['level1']) - 1;
	$level2 = intval($_POST['level2']) - 1;
	$level3 = intval($_POST['level3']) - 1;
	if((hash('sha256', $_POST['answer1']) == $answers[$level1]) && (hash('sha256', $_POST['answer2']) == $answers[$level2]) && (hash('sha256', $_POST['answer3']) == $answers[$level3])){
		setcookie("finale", '12345'.$_POST['level1'].$_POST['level2'].$_POST['level3'], [
			'expires' => (time() + 31536000),
			'path' => "/",
			'domain' => ".thestringharmony.com",
			'secure' => true,
			'httponly' => false,
			'samesite' => 'None',
		]);
		header('Location:https://thestringharmony.com/xxxxxx/fghij.php');
		die();
	}
}

?>
<!DOCTYPE html>
<html>
	<head> 
		<title>Verification</title>
		<link rel="stylesheet" type="text/css" href="../../level.css">
	</head>
	<body>
		<div align="center">
		<audio src="../../bgm.mp3" autoplay loop></audio>
		<?php if(!isset($_COOKIE['finale'])){ ?>
		You must have solved at least <strong>3</strong> Forbidden levels (except F0) before attempting F9.<br>
		Please enter the level solutions to proceed.<br>
		Note: Turn on the audio for the best experience.<br>
		<br>
		<form action="abcde.php" method="POST">
			<select name="level1">
				<option value="1">F1</option>
				<option value="2">F2</option>
				<option value="3">F3</option>
				<option value="4">F4</option>
				<option value="5">F5</option>
				<option value="6">F6</option>
				<option value="7">F7</option>
				<option value="8">F8</option>
			</select>
			<input type="text" name="answer1" style="color: red"><br><br>
			<select name="level2">
				<option value="1">F1</option>
				<option value="2">F2</option>
				<option value="3">F3</option>
				<option value="4">F4</option>
				<option value="5">F5</option>
				<option value="6">F6</option>
				<option value="7">F7</option>
				<option value="8">F8</option>
			</select>
			<input type="text" name="answer2" style="color: green"><br><br>
			<select name="level3">
				<option value="1">F1</option>
				<option value="2">F2</option>
				<option value="3">F3</option>
				<option value="4">F4</option>
				<option value="5">F5</option>
				<option value="6">F6</option>
				<option value="7">F7</option>
				<option value="8">F8</option>
			</select>
			<input type="text" name="answer3" style="color: blue"><br><br>
			<input type="submit" value="Submit">
		</form>
		<?php if(isset($_POST['level1'])){echo "<br>Wrong solutions...";} ?>
		<?php }else{ ?>
		You have already verified the solutions.<br>
		Would you like to reset your progress?<br><br>
		<form action="verification.php" method="POST">
			<input type="submit" name="reset" value="Reset">
		</form>
		<?php } ?>
		</div> 
	</body>
</html>