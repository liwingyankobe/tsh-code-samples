<?php

function cookie($code, $pos){
	$first = substr($_COOKIE['finale'], 0, $pos);
	$last = substr($_COOKIE['finale'], $pos + strlen($code));
	$newcookie = $first.$code.$last;
	setcookie("finale", $newcookie, [
		'expires' => (time() + 31536000),
		'path' => "/",
		'domain' => ".thestringharmony.com",
		'secure' => true,
		'httponly' => false,
		'samesite' => 'None',
	]);
}

$error401 = $_SERVER['DOCUMENT_ROOT'].'/error/401.htm';
$error403 = $_SERVER['DOCUMENT_ROOT'].'/error/403.htm';
$error404 = $_SERVER['DOCUMENT_ROOT'].'/error/404.htm';

$path = $_SERVER['REQUEST_URI'];
$universe = substr($_COOKIE['finale'], 0, 5);
$progress1 = substr($_COOKIE['finale'], 5, 5);
$progress2 = substr($_COOKIE['finale'], 10, 4);
$progress3 = substr($_COOKIE['finale'], 14, 3);
$choices = substr($_COOKIE['finale'], 17);
$unilist = array('0','1','2');
$p1list = array('0','1','2','3','4','5','6','7','8','9','10');
$p2list = array('0','1','2','3');
$p3list = '012';
$fpaths = array(
	'a.htm',
	'b.htm',
	'c.htm',
	'd.htm',
	'e.htm',
	'f.htm',
	'g.htm',
	'h.htm');
	
$u = array_search($universe, $unilist);
$p1 = array_search($progress1, $p1list);

if ($path == '/xxx.htm' && $u == 2 && $p1 > 7){
	$path = '/xxx/yyy.htm';
}elseif ($path == '/xxx/' && $u == 1){
	$path = '/yyy/zzz.htm';
}elseif ($path == '/xxx/zzz.htm' && $u == 1){
	$path = '/zzz/xxx.htm';
	if ($p1 == 0){
		cookie($p1list[1], 5);
	}
}elseif ($path == '/the/remaining' && $u == 0 && $p1 > 0){
	$path = '/is/omitted.htm';
}

$path = $_SERVER['DOCUMENT_ROOT'].$path;
$qm = strpos($path, '?');
if ($qm){
	$getdata = substr($path, $qm + 1);
	$path = substr($path, 0, $qm);
	parse_str($getdata, $getarray);
	$_GET = $getarray;
}
$isindex = false;
$extension = substr($path, -4);
if ($extension != '.htm' && $extension != '.php'){
	if(is_dir($path)){
		$isindex = true;
	}
	$path = $path.'index.htm';
}

if ($_SERVER['REDIRECT_URL'] == '/error/401.htm'){
	include $error401;
}elseif (file_exists($path)){
	include $path;
}elseif ($isindex){
	include $error403;
}else{
	include $error404;
}

?>