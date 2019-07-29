<?php
session_start();
include('head.php');
require('dbconnect.php');

//提示用户登录

if (!isset($_SESSION['user'])) {
	 header('Content-type: text/html; charset=UTF8'); 

	echo "<font color=#FF0000 size=5>您还没有登录，请<a href=\"login.php\">登录</a>!</font>";
	exit();
}else{
	echo "<h1 align='center'><font color = pink>登录成功</font></h1>";
}

?>