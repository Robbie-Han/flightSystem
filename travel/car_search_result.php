<?php  
include('head.php');
require('dbconnect.php');
?>

<?php

$location = $_POST['location'];

// 检测连接
if (!$conn) {
    die("Connection failed: " . mysqli_error());
}
if ($location=="") {
	echo "<div align=center>请输入查询条件<br>";
	echo "<a href='javascript:history.back(-1)'>后退</a></div>";
	exit();
}

function Get_search_id(){
  
	$args = func_get_args();
	$queryfield = $args[0];
	$queryvalue = $args[1];

	//echo $queryfield ;
	//echo $queryvalue;

	$conn = $args[2];
	$id_search = array();
	$sqlsearch = "select * from cars where ".$queryfield." like '%".$queryvalue."%'";
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

if ($location != "") {

	$terminal_id = array();
	$terminal_id = Get_search_id("location",$location,$conn);
	
	$resultid = $terminal_id;
	
}
//print_r($resultid);
$num = count($resultid);

echo "<h2 align=center>酒店查询结果</h2>";
if ($num == 0) {
	echo "<div align='center'><font color='red'>没有找到符合查询条件的酒店</font></div>";
	exit();
}
echo "<div align='center'>查询到<font color='red'>$num</font>个酒店！如下表：</div>";
echo "<br>";
echo "<table border=1 width='80%' align='center'>";
echo "<th>type</th>";
echo "<th>location</th>";
echo "<th>price</th>";
echo "<th>numCars</th>";
echo "<th>numAvail</th>";
echo "<th>Book</th>";

//for ($i=0; $i < $num; $i++) { 
foreach ($resultid as $key => $value) {
	$bresult = mysqli_query($conn,"select * from cars where type='$resultid[$key]'");
	$binfo = mysqli_fetch_array($bresult);
echo "<tr align=center><td>$binfo[type]</td>";
echo "<td>$binfo[location]</td>";
echo "<td>$binfo[price]</td>";
echo "<td>$binfo[numCars]</td>";
echo "<td>$binfo[numAvail]</td>";
echo "<td><a href='car_book.php' color=#0000ff>book</a></td>";

echo "</tr>";

}

echo "</table>";   

?>

	
	
	
	
	
	

