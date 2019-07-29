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
			<th colspan="2">汽车预订</th> 
		</tr>
		<tr>
			<td align="right" width="30%" height="32">汽车类型：</td>
			<td width="70%" height="32">
				<input type="text" name="type" size="10">
			</td>
		</tr>
		<tr><td align="right" width="30%" height="32">所在城市：</td>
			<td width="70%" height="32">
				<input type="text" name="location" size="10">
				<input type="submit" name="show" value="显示汽车信息">
			</td>
		</tr>
	</table>
</form>
<?php
}

else{
	
	if ($_POST['show']) {
		$book_id = $_POST['type'];
		$location = $_POST['location'];
		if ($book_id ==""||$location=="") {
		echo "<div align=center><font color=red>汽车信息没有填写完整</font></div>";
		exit();
		}
		else{
			$booksql = "select * from cars where type like '%".$book_id."%' and location like '%".$location."%'";
			//"select * from flights  where ".$queryfield." like '%".$queryvalue."%'";
			//print_r($booksql);
			$bookresult = mysqli_query($conn,$booksql);
			$bookinfo = mysqli_fetch_array($bookresult, MYSQLI_ASSOC);//获得数组的键值是表中属性名
			//print_r($bookinfo);

			if (empty($bookinfo)) {
				echo "<div align=center><font color=red> 该城市没有该车型！</font></div>";
				exit();
			}
			else{
				if ($bookinfo[numAvial]=="0") {
					echo "<div align=center><font color=red>该车全部售完！</font></div>";
				}

?>

	<form name="form1" method="post" action="">
	<table align="center" width="60%" border="0" cellspacing="1" cellpadding="3">
		<tr>
			<th colspan="2">汽车预订</th>
		</tr>
		<tr>
			<td align="right" width="30%" height="32">汽车名：</td>
			<td width="70%" height="32"><?php echo $book_id; ?>
			<input type="hidden" name="numAvail" value="<?php echo $bookinfo[numAvail];?>">
			<input type="hidden" name="type" value="<?php echo $bookinfo[type];?>">
			<input type="hidden" name="location" value="<?php echo $bookinfo[location];?>">
			</td>
		</tr>
		<tr>
			<td width="30%" align="right">城市：</td>
			<td width="70%"><?php echo $bookinfo[location]; ?></td>
		</tr>

		<tr>
			<td width="30%" align="right">价格：</td>
			<td width="70%"><?php echo $bookinfo[price]; ?></td>
		</tr>
		<tr>
			<td width="30%" align="right">汽车总数：</td>
			<td width="70%"><?php echo $bookinfo[numCars]; ?></td>
		</tr>
		<tr>
			<td width="30%" align="right">剩余车数：</td>
			<td width="70%"><?php echo $bookinfo[numAvail]; ?></td>
		</tr>
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
		$user_id = $_POST['user_id'];//用户ID
		$book_id = $_POST['type'];
		$location = $_POST['location'];
		$user_name = $_POST['user_name'];//用户名
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

		$logsql = "insert into carbook_log(user_id,user_name,location,type,time) value('$user_id','$user_name','$location','$book_id','$now')";
		//echo $logsql;
		mysqli_query($conn,$logsql) or die("操作失败1".mysqli_connect_error());


		$booksql = "insert into carbook(user_id,user_name,location,type) value('$user_id','$user_name','$location','$book_id')";
		//echo $lendsql;
		//echo $booksql;
		mysqli_query($conn,$booksql) or die("操作失败2".mysqli_connect_error());
		//在log中记录
		
		$numAvail = $_POST['numAvail']-1;
		//echo $numAvail;
		$update = "update cars set numAvail ="."'$numAvail'"." where type like '%".$book_id."%' and location like '%".$location."%'";
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