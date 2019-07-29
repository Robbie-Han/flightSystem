<?php
session_start();
include('head.php');
require('dbconnect.php');

//提示用户登录

if (!isset($_SESSION['user'])) {
	 header('Content-type: text/html; charset=UTF8'); 

	echo "<p align='center'><font color=#FF0000 size=5 >您还没有登录，请<a href=\"login.php\">登录</a>!</font></p>";
	exit();
}

?>

<!DOCTYPE html>
<html>
<meta charset="utf-8">
<body>

<?php
error_reporting(E_ALL ^ E_NOTICE);
if ($_POST['show']=="" and $_POST['lend']=="") {
?>
<form name="form1" method="post" action="">
	<table align="center" width="60%" border="0" cellspacing="1" cellpadding="3">
		<tr>
			<th colspan="2">航班预订</th>
		</tr>
		<tr>
			<td align="right" width="30%" height="32">航班编号：</td>
			<td width="70%" height="32">
				<input type="text" name="flightNumber" size="10">
				<input type="submit" name="show" value="显示航班信息">
			</td>
		</tr>
	</table>
</form>
<?php
}

else{
	//只是显示航班详细信息
	if ($_POST['show']) {
		$book_id = $_POST['flightNumber'];
		if ($book_id =="") {
		echo "<div align=center><font color=red>航班号没有填写</font></div>";
		exit();
		}
		else{
			$booksql = "select * from flights where flightNum like '%".$book_id."%'";
			//"select * from flights  where ".$queryfield." like '%".$queryvalue."%'";
			//print_r($booksql);
			$bookresult = mysqli_query($conn,$booksql);
			$bookinfo = mysqli_fetch_array($bookresult, MYSQLI_ASSOC);//获得数组的键值是表中属性名
			//print_r($bookinfo);

			if (empty($bookinfo)) {
				echo "<div align=center><font color=red> 不存在该航班号！</font></div>";
				exit();
			}
			else{
				if ($bookinfo[numAvail]=="0") {
					echo "<div align=center><font color=red>该航班全部售完！</font></div>";
				}

?>

	<form name="form1" method="post" action="">
	<table align="center" width="60%" border="0" cellspacing="1" cellpadding="3">
		<tr>
			<th colspan="2">航班预订</th>
		</tr>
		<tr>
			<td align="right" width="30%" height="32">航班编号：</td>
			<td width="70%" height="32"><?php echo $book_id; ?>
			<input type="hidden" name="numAvail" value="<?php echo $bookinfo[numAvail];?>">
			<input type="hidden" name="flightNumber" value="<?php echo $bookinfo[flightNum];?>">
			</td>
		</tr>
		<tr>
			<td width="30%" align="right">价格：</td>
			<td width="70%"><?php echo $bookinfo[price]; ?></td>
		</tr>
		<tr>
			<td width="30%" align="right">总席位：</td>
			<td width="70%"><?php echo $bookinfo[numSeat]; ?></td>
		</tr>
		<tr>
			<td width="30%" align="right">剩余席位：</td>
			<td width="70%"><?php echo $bookinfo[numAvail]; ?></td>
		</tr>
		<tr>
			<td width="30%" align="right">出发城市：</td>
			<td width="70%"><?php echo $bookinfo[FromCity]; ?></td>
		</tr>
		<tr>
			<td width="30%" align="right">到达城市：</td>
			<td width="70%"><?php echo $bookinfo[ArivCity]; ?></td>
			
		</tr>
		<tr>
			<td width="30%" align="right">用户ID：</td>
			<td width="70%">
				<input type="text" name="user_id" size="10">
			</td>
		</tr>
		<tr>
			<td width="30%" align="right">用户姓名：</td>
			<td width="70%">
				<input type="text" name="user_name" size="30">
			</td>
		</tr>
		<tr>
			<td width="30%" align="right">
				<input type="submit" name="lend" value="预订">
			</td>
			<td width="70%">
				<input type="reset" name="Submit2" value="重置">
			</td>
		</tr>

	</table>
</form>

<?php
			}

		}
	}
	//预订
	if($_POST['numAvail']){
		$user_id = $_POST['user_id'];
		$book_id = $_POST['flightNumber'];
		$user_name = $_POST['user_name'];
		//echo $book_id;
		if ($user_id=="") {
			echo '<div align=center><font color=red>用户ID没有填写！</font></div>';
			exit();

		}elseif ($user_name=="") {
			# code...
			echo '<div align=center><font color=red>用户名没有填写！</font></div>';
			exit();
		}
		//记录正常借书
		$now = date("Y-m-d");

		$logsql = "insert into flightbook_log(flightNum,user_id,user_name,lend_time) value('$book_id','$user_id','$user_name','$now')";
		mysqli_query($conn,$logsql) or die("操作失败".mysqli_connect_error());


		$booksql = "insert into flightbook(flightNum,user_id,user_name) value('$book_id','$user_id','$user_name')";
		//echo $lendsql;
		mysqli_query($conn,$booksql) or die("操作失败".mysqli_connect_error());
		//在log中记录
		
		$numAvail = $_POST['numAvail']-1;
		//echo $numAvail;
		$update = "update flights set numAvail ="."'$numAvail'"." where flightNum like '%".$book_id."%'";
		//echo $update;
		mysqli_query($conn,$update);
		//"select * from flights  where ".$queryfield." like '%".$queryvalue."%'";


?>
		<p align="center">&nbsp;</p>
		<p align="center">&nbsp;</p>
		<p align="center"><font color="red">预订完成！</font></p>
		<p align="center"><a href="<?php echo $PHP_SELF; ?>">继续预订</a></p>
<?php 
	}

}
 ?>
</body>
</html>