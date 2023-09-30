<?php


ini_set('session.save_path', sys_get_temp_dir());
session_start();

function base26($token){
	$r = range('a','z');
	$s = array_merge(range('0','9'),range('a','p'));
	$raw = strtr($token, array_combine($r,$s));
	$id = base_convert($raw, 26, 10);
	return str_pad($id,18,'0',STR_PAD_LEFT);
}

function keygen($id){
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
		$r = range('a','z');
		$s = array_merge(range('0','9'),range('a','p'));
		$raw = base_convert($key[$i], 10, 26);
		$key[$i] = strtr($raw, array_combine($s,$r));
	}
	return $key;
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

function stringbot($you, $partner, $yourtoken, $partnertoken){
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL,"https://the-string-harmony-bot.herokuapp.com/");
	curl_setopt($ch, CURLOPT_POST, 1);
	$ans = 'xx,'.$partner.','.$yourtoken.','.$partnertoken;
	$payload = json_encode(array('id' => $you, 'ans' => $ans));
	curl_setopt( $ch, CURLOPT_POSTFIELDS, $payload );
	curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	$server_output = curl_exec($ch);
	curl_close ($ch);
	return $server_output;
}

?>
<!DOCTYPE html>
<html>
	<head> 
		<title>Two particles</title>
		<link rel="stylesheet" type="text/css" href="../level.css">
	</head>
	<body>
		<div align="center">
		<audio src="../bgm.mp3" autoplay loop></audio> 
		<?php

		if(isset($_COOKIE["id"])){
			$id = $_COOKIE["id"];
			if(!isset($_SESSION['distributed'])){
				$_SESSION['distributed'] = false;
			}
			if(!isset($_SESSION['sent'])){
				$_SESSION['sent'] = false;
			}
			if(!isset($_SESSION['x'])){
				$_SESSION['x'] = false;
			}
			if(!isset($_SESSION['cnot'])){
				$_SESSION['cnot'] = false;
			}
			if(isset($_POST['Distribute'])){
				if($_SESSION['x'] and isset($_SESSION['you']) and isset($_SESSION['partner']) and ctype_lower($_SESSION['you']) and ctype_lower($_SESSION['partner']) and $id == base26($_SESSION['you'])){
					$server_output = stringbot($id,base26($_SESSION['partner']),'?????????????','?????????????');
					if ($server_output == 'OK'){
						$_SESSION['distributed'] = true;
					}else{
						$message = '<br><br>Invalid...';
					}
				}else{
					$message = '<br><br>Invalid...';
				}
				$_SESSION['x'] = false;
				$_SESSION['cnot'] = false;
			}elseif(isset($_POST['Back_distributed'])){
				$_SESSION['distributed'] = false;
			}elseif(isset($_POST['Measure'])){
				$r = range('a','z');
				$_SESSION['secret'] = '';
				for($i = 0; $i < 10; $i++){
					$_SESSION['secret'] = $_SESSION['secret'].$r[rand(0,25)];
				}
				$enc = rand(1,7);
				$partnertoken = encode(str_repeat('a',strlen(keygen($id)[0])),keygen($id)[$enc]);
				$partnerpt = decode($_SESSION['secret'],keygen(base26($_SESSION['partner']))[$enc]);
				$yourtoken = encode($partnerpt,keygen(base26($_SESSION['partner']))[0]);
				$server_output = stringbot($id,base26($_SESSION['partner']),$yourtoken,$partnertoken);
				if($server_output == 'OK'){
					$_SESSION['sent'] = true;
					$_SESSION['timer'] = time();
				}
			}elseif(isset($_POST['Back_sent'])){
				$_SESSION['sent'] = false;
			}
			if(!$_SESSION['distributed']){
				$flag1 = false;
				$flag2 = false;
				if(isset($_POST['you']) and $_POST['you'] != '?????????????'){
					$_SESSION['you'] = $_POST['you'];
					$flag1 = true;
				}if(empty($_POST['you']) and isset($_SESSION['you'])){
					unset($_SESSION['you']);
					$flag1 = false;
				}
				if(isset($_POST['partner']) and $_POST['partner'] != '?????????????'){
					$_SESSION['partner'] = $_POST['partner'];
					$flag2 = true;
				}if(empty($_POST['partner']) and isset($_SESSION['partner'])){
					unset($_SESSION['partner']);
					$flag2 = false;
				}
				if($flag1 and $flag2 and isset($_POST['CNOT'])){
					$_SESSION['cnot'] = true;
					$_SESSION['x'] = false;
				}elseif($_SESSION['cnot'] and isset($_POST['X'])){
					$_SESSION['x'] = true;
				}elseif(!isset($_POST['Distribute'])){
					$_SESSION['x'] = false;
					$_SESSION['cnot'] = false;
				}
		?>
		<form method="POST">
			You: <input type="text" name="you" style="font-family: Consolas; width=50" value="<?php if(isset($_SESSION['you'])){ echo '?????????????'; } ?>"> 
			<input type="submit" name="X" value="X">
			<input type="submit" name="Z" value="Z">
			<input type="submit" name="H" value="H"><br><br>
			<input type="submit" name="CNOT" value="CNOT"><br><br>
			Partner: <input type="text" name="partner" style="font-family: Consolas; width=50" value="<?php if(isset($_SESSION['partner'])){ echo '?????????????'; } ?>"><br><br>
			<input type="submit" name="Distribute" value="Distribute">
		</form>
		<?php
				if(isset($message)){
					echo $message;
				}
			}elseif(!$_SESSION['sent']){
		?>
		Distributed! Check your Discord PM.<br>
		You are now ready to teleport your (unknown) message.<br><br>
		<form method="POST">
			<input type="submit" name="Measure" value="Measure">
			<input type="submit" name="Back_distributed" value="Back">
		</form>
		<?php
			}else{
		?>
		Message sent! You have 30 seconds to answer.<br>
		Note that the message contains XX random letters.<br><br>
		<form method="POST">
			Your message: <input type="text" name="message" style="font-family: Consolas; width=50"><br><br>
			<input type="submit" name="Submit" value="Submit">
			<input type="submit" name="Back_sent" value="Back">
		</form>
		<?php
				if(isset($_POST['message'])){
					$current = time();
					if($current - $_SESSION['timer'] <= 30){
						if($_POST['message'] == $_SESSION['secret']){
		?>
		<br><br>Nice job! Your answer is correct and you have finished the lab.<br>
		Here is your reward:<br>
		xxxxxxxx
		<?php
						}else{
							echo '<br><br>Wrong answer...';
						}
					}else{
						echo '<br><br>Time is up :(';
					}
				}
			}
		?>
		<?php }else{ ?>
		<a href="https://thestringharmony.com/login/">Log in</a> first!
		<?php } ?>
		</div> 
	</body>
</html>

<!--

Here are two particles, which can be used for quantum teleportation.
Invite your lab partner and start the experiment!

First create a PAIR of BELLS, and distribute one of them to your partner.
The tokens will be entangled and unknown. This allows quantum communication between you and your partner.

An unknown message is prepared for you. You can send it to your partner by measuring your token with the message.
Once it is done, the tokens will be revealed and no longer entangled. The (encoded) message is now teleported to your partner.
Tell your partner your result. Your partner can then extract the message by appropriate QUANTUM OPERATIONS.
The lab is done by then, but to finish your lab report, get the message from your partner.

Good luck!

Note: You can be the partner of yourself, but try to find a teammate for optimal experience :)

-->