

<?php

session_start();

require('dbconnect.php');
include('head.php');
?>

<?php 
$ID = $_POST['ID'];
$name = $_POST['name'];
$password = $_POST['password'];
@$Email = $_POST['Email'];
$tel = $_POST['tel'];
$address = $_POST['address'];

//加密密码
//$password = md5($password);
/*
echo $name;
echo $password;
echo $Email;
echo "<br>";
echo $password;
*/
//连接数据库
$sql = "insert into user(user_id,user_name,password,Email,tel,address) values('$ID','$name','$password','$Email','$tel','$address')";

$result1 = $conn->query($sql) or die("注册用户失败：".mysqli_error());

//获得注册用户的ID
//$sql_id = "select last_insert_id()";
//$result = $conn->query($sql_id);

//$result = mysql_query("select last_insert_id()",$conn);
//$re_arr = mysql_fetch_array($result);
//$id = $re_arr[0];

//注册成功，自动登录，注册session变量
//$_SESSION['user'] = null;
//$user = $id;
echo "<table align = center><tr><td align = center>注册成功</td></tr>";
echo "<tr><td align = center><font color=red>您的ID是：".$ID;
echo "，请您记住，以后用此ID登录！<a href ='login.php' color=#0000ff align = center>点此登录</a></font></td></tr></table>";


?>


