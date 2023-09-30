<?php


ini_set('session.save_path', sys_get_temp_dir());
session_start();

function base26($id){
	$r = range('a','z');
	$s = array_merge(range('0','9'),range('a','p'));
	$raw = base_convert($id, 10, 26);
	return strtr($raw, array_combine($s,$r));
}

function Mod($a, $b)
{
	return ($a % $b + $b) % $b;
}

function Cipher($input, $key, $encipher)
{
	$keyLen = strlen($key);

	for ($i = 0; $i < $keyLen; ++$i)
		if (!ctype_alpha($key[$i]))
			return ""; // Error

	$output = "";
	$nonAlphaCharCount = 0;
	$inputLen = strlen($input);

	for ($i = 0; $i < $inputLen; ++$i)
	{
		if (ctype_alpha($input[$i]))
		{
			$cIsUpper = ctype_upper($input[$i]);
			$offset = ord($cIsUpper ? 'A' : 'a');
			$keyIndex = ($i - $nonAlphaCharCount) % $keyLen;
			$k = ord($cIsUpper ? strtoupper($key[$keyIndex]) : strtolower($key[$keyIndex])) - $offset;
			$k = $encipher ? $k : -$k;
			$ch = chr((Mod(((ord($input[$i]) + $k) - $offset), 26)) + $offset);
			$output .= $ch;
		}
		else
		{
			$output .= $input[$i];
			++$nonAlphaCharCount;
		}
	}

	return $output;
}

function encode($input, $key)
{
	return Cipher($input, $key, true);
}

function decode($input, $key)
{
	return Cipher($input, $key, false);
}

?>
<!DOCTYPE html>
<html>
	<head> 
		<title>A particle</title>
		<link rel="stylesheet" type="text/css" href="../level.css">
	</head>
	<body>
		<div align="center">
		<audio src="../bgm.mp3" autoplay loop></audio> 
		<?php

		if(isset($_COOKIE["id"])){
			$id = $_COOKIE["id"];
			$key = array('','','','','','','','');
			for($i = 0; $i < 9; $i++){
				$key[0] = $key[0].$id[2*$i].$id[2*$i+1];
				$key[1] = $key[1].$id[2*$i].strval(9-intval($id[2*$i+1]));
				$key[2] = $key[2].strval(9-intval($id[2*$i])).strval(9-intval($id[2*$i+1]));
				$key[3] = $key[3].strval(9-intval($id[2*$i])).$id[2*$i+1];
				$key[4] = $key[4].$id[2*$i].'0';
				$key[5] = $key[5].'0'.$id[2*$i+1];
				$key[6] = $key[6].'0'.strval(9-intval($id[2*$i+1]));
				$key[7] = $key[7].strval(9-intval($id[2*$i])).'0';
			}
			for($i = 0; $i < 8; $i++){
				$key[$i] = base26($key[$i]);
			}
			if(!isset($_SESSION['state']) or isset($_POST['Reset'])){
				$_SESSION['state'] = 0;
				$_SESSION['pt'] = str_repeat('a',strlen($key[0]));
			}elseif(isset($_POST['token'])){
				$newpt = decode($_POST['token'],$key[$_SESSION['state']]);
				if($newpt != $_SESSION['pt']){
					$_SESSION['state'] = 0;
					$_SESSION['pt'] = decode($_POST['token'],$key[0]);
				}
			}
			if(isset($_POST['X'])) {
				$newstate = array(0,1,2,3,4,5,6,7);
				$_SESSION['state'] = $newstate[$_SESSION['state']];
			}elseif(isset($_POST['Z'])) {
				$newstate = array(4,5,6,7,0,1,2,3);
				$_SESSION['state'] = $newstate[$_SESSION['state']];
			}elseif(isset($_POST['H'])) {
				$newstate = array(7,6,5,4,3,2,1,0);
				$_SESSION['state'] = $newstate[$_SESSION['state']];
			}

		?>
		<form method="POST">
			Token: <input type="text" name="token" style="font-family: Consolas; width=50" value="<?php echo encode($_SESSION['pt'],$key[$_SESSION['state']]); ?>"><br><br>
			<input type="submit" name="X" value="X">
			<input type="submit" name="Z" value="Z">
			<input type="submit" name="H" value="H">
			<input type="submit" name="Reset" value="Reset">
		</form>
		<?php }else{ ?>
		<a href="https://thestringharmony.com/login/">Log in</a> first!
		<?php } ?>
		</div> 
	</body>
</html>

<!--

Here is a single particle. Its quantum state is represented by a token.
You can change the state with QUANTUM OPERATIONS. There are three kinds of operations: X, Z, H.
You can reset the state back to the initial state I gave you, or set your favorite initial state.
These operations will be used when we simulate quantum teleportation.

Move on when you become familiar with these operations. What's next?

-->