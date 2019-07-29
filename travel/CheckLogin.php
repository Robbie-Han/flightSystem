<?php

session_start();

if (isset($_SESSION['user'])) {
	//重定向到管理留言
	header("Location:index.php");
	exit;
}
include('head.php');
require ('dbconnect.php');

//获得参数
$nickname = $_POST['username'];
$password = $_POST['pass'];
//$password = md5($password);

//检查账号和密码是否正确
$sql = "select * from user where user_id = '$nickname' and password = '$password'";
//echo $sql;
$re = mysqli_query($conn,$sql);
$result = mysqli_fetch_array($re);

if (!empty($result)) {
	$_SESSION['user'] = 1;
	//$user = $nickname;

	header("Location:index.php");
}
else{
	//include('head.php');
	header('Content-type: text/html; charset=UTF8');
	echo "用户ID或密码错误，登录失败！";
	echo "<br>";
	echo "<a href='login.php'>请重试</a>";
}