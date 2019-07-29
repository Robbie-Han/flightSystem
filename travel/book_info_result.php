<?php  
include('head.php');
require('dbconnect.php');
?>

<?php

//获得参数
$id= $_POST['ID'];
$password = $_POST['pass'];
//$password = md5($password);
if ($id==""||$password=="") {
		echo "<div align=center>请重新输入<br>";
		echo "<a href='javascript:history.back(-1)'>后退</a></div>";
		exit();
	}
//检查账号和密码是否正确
$sql = "select * from user where user_id = '$id' and password = '$password'";
//echo $sql;
$re = mysqli_query($conn,$sql);
$result = mysqli_fetch_array($re);

if (!empty($result)) {

	function Get_search_id(){

		$args = func_get_args();
		$queryfield = $args[0];
		$queryvalue = $args[1];

		//echo $queryfield ;
		//echo $queryvalue;

		$conn = $args[2];
		$id_search = array();
		$sqlsearch = "select * from carbook_log where ".$queryfield." like '%".$queryvalue."%'";
		                    //SELECT * from flights WHERE FromCity LIKE '%BeiJing%';
		//print_r($sqlsearch);
		$re_search = mysqli_query($conn,$sqlsearch);
		
		while ($row_search = mysqli_fetch_row($re_search)) {

			//print_r($row_search[0]);
			array_push($id_search,$row_search[0]);//每次只把取出数组的第一个元素推入数组
		}
		//print_r($id_search);
		return $id_search;
	}

	$resultid = array();
	//$arr = array();

	$flag = 0;

	if ($id != "") {

		$terminal_id = array();
		$terminal_id = Get_search_id("user_id",$id,$conn);
		
		$resultid = $terminal_id;
		
	}
	//print_r($resultid);
	$num = count($resultid);

	echo "<h2 align=center>汽车预订详单</h2>";
	if ($num == 0) {
		echo "<div align='center'><font color='red'>您没有预订任何车辆</font></div>";
		exit();
	}
	echo "<div align='center'>查询到<font color='red'>$num</font>个预订记录！如下表：</div>";
	echo "<br>";
	echo "<table border=1 width='80%' align='center'>";
	echo "<th>user_id</th>";
	echo "<th>user_name</th>";
	echo "<th>location</th>";
	echo "<th>type</th>";
	echo "<th>time</th>";
	//for ($i=0; $i < $num; $i++) { 
	foreach ($resultid as $key => $value) {
		$bresult = mysqli_query($conn,"select * from carbook_log where cnum='$resultid[$key]'");
		$binfo = mysqli_fetch_array($bresult);
	echo "<tr align=center><td>$binfo[user_id]</td>";
	echo "<td>$binfo[user_name]</td>";
	echo "<td>$binfo[location]</td>";
	echo "<td>$binfo[type]</td>";
	echo "<td>$binfo[time]</td>";
	//echo "<td><a href='car_book.php' color=#0000ff>book</a></td>";

	echo "</tr>";

	}

	echo "</table>";   


	function flight_search_id(){

		$args = func_get_args();
		$queryfield = $args[0];
		$queryvalue = $args[1];

		//echo $queryfield ;
		//echo $queryvalue;

		$conn = $args[2];
		$id_search = array();
		$sqlsearch = "select * from flightbook_log where ".$queryfield." like '%".$queryvalue."%'";
		                    //SELECT * from flights WHERE FromCity LIKE '%BeiJing%';
		//print_r($sqlsearch);
		$re_search = mysqli_query($conn,$sqlsearch);
		
		while ($row_search = mysqli_fetch_row($re_search)) {

			//print_r($row_search[0]);
			array_push($id_search,$row_search[0]);//每次只把取出数组的第一个元素推入数组
		}
		//print_r($id_search);
		return $id_search;
	}

	$resultid = array();
	//$arr = array();

	$flag = 0;

	if ($id != "") {

		$terminal_id = array();
		$terminal_id = flight_search_id("user_id",$id,$conn);
		
		$resultid = $terminal_id;
		
	}
	//print_r($resultid);
	$num = count($resultid);

	echo "<h2 align=center>航班预订详单</h2>";
	if ($num == 0) {
		echo "<div align='center'><font color='red'>您没有预订任何航班</font></div>";
		exit();
	}
	echo "<div align='center'>查询到<font color='red'>$num</font>个预订记录！如下表：</div>";
	echo "<br>";
	echo "<table border=1 width='80%' align='center'>";
	echo "<th>flightNum</th>";
	echo "<th>user_id</th>";
	echo "<th>user_name</th>";
	echo "<th>time</th>";
	//for ($i=0; $i < $num; $i++) { 
	foreach ($resultid as $key => $value) {
		$bresult = mysqli_query($conn,"select * from flightbook_log where fnum='$resultid[$key]'");
		$binfo = mysqli_fetch_array($bresult);
	echo "<tr align=center><td>$binfo[flightNum]</td>";
	echo "<td>$binfo[user_id]</td>";
	echo "<td>$binfo[user_name]</td>";
	echo "<td>$binfo[lend_time]</td>";
	//echo "<td><a href='car_book.php' color=#0000ff>book</a></td>";

	echo "</tr>";

	}

	echo "</table>"; 

	function hotel_search_id(){

		$args = func_get_args();
		$queryfield = $args[0];
		$queryvalue = $args[1];

		//echo $queryfield ;
		//echo $queryvalue;

		$conn = $args[2];
		$id_search = array();
		$sqlsearch = "select * from hotelbook_log where ".$queryfield." like '%".$queryvalue."%'";
		                    //SELECT * from flights WHERE FromCity LIKE '%BeiJing%';
		//print_r($sqlsearch);
		$re_search = mysqli_query($conn,$sqlsearch);
		
		while ($row_search = mysqli_fetch_row($re_search)) {

			//print_r($row_search[0]);
			array_push($id_search,$row_search[0]);//每次只把取出数组的第一个元素推入数组
		}
		//print_r($id_search);
		return $id_search;
	}

	$resultid = array();
	//$arr = array();

	$flag = 0;

	if ($id != "") {

		$terminal_id = array();
		$terminal_id = hotel_search_id("user_id",$id,$conn);
		
		$resultid = $terminal_id;
		
	}
	//print_r($resultid);
	$num = count($resultid);

	echo "<h2 align=center>酒店预订详单</h2>";
	if ($num == 0) {
		echo "<div align='center'><font color='red'>您没有预订任何酒店</font></div>";
		exit();
	}
	echo "<div align='center'>查询到<font color='red'>$num</font>个预订记录！如下表：</div>";
	echo "<br>";
	echo "<table border=1 width='80%' align='center'>";
	echo "<th>user_id</th>";
	echo "<th>user_name</th>";
	echo "<th>location</th>";
	echo "<th>hotel_name</th>";
	echo "<th>time</th>";
	//for ($i=0; $i < $num; $i++) { 
	foreach ($resultid as $key => $value) {
		$bresult = mysqli_query($conn,"select * from hotelbook_log where hnum='$resultid[$key]'");
		$binfo = mysqli_fetch_array($bresult);
	echo "<tr align=center><td>$binfo[user_id]</td>";
	echo "<td>$binfo[user_name]</td>";
	echo "<td>$binfo[location]</td>";
	echo "<td>$binfo[name]</td>";
	echo "<td>$binfo[time]</td>";
	//echo "<td><a href='car_book.php' color=#0000ff>book</a></td>";

	echo "</tr>";

	}

	echo "</table>";   


}else{
	echo "您无权访问,请重输的ID和密码";
	echo "<a href='book_info.php'>刷新</a>";
}

?>

	
	
	
	
	
	

