<?php
$servername = "localhost";
$username = "root";
$password = "";
 $dbname = "travel";
// 创建连接
$conn = mysqli_connect($servername, $username, $password, $dbname);
 
// 检测连接
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
//echo "连接成功";
?>