<?php  
include('head.php');
require('dbconnect.php');
?>

<?php

$start = $_POST['start'];
$terminal = $_POST['terminal'];

// 检测连接
if (!$conn) {
    die("Connection failed: " . mysqli_error());
}
if ($start==""||$terminal=="") {
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
	$sqlsearch = "select * from flights  where ".$queryfield." like '%".$queryvalue."%'";
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
$arr = array();

$flag = 0;

if ($start != "") {
	$start_id = array();
	$start_id = Get_search_id("FromCity",$start,$conn);

	if ($flag == 0) {
		$resultid = $start_id;
		$flag = 1;
	}
	else{
		$arr = array_intersect($resultid, $start_id);
		$resultid = $arr;
		
	}
}
if ($terminal != "") {

	$terminal_id = array();
	$terminal_id = Get_search_id("ArivCity",$terminal,$conn);
	
	if ($flag == 0) {
		$resultid = $terminal_id;
		
	}
	else{
		//echo "aaa";
		$arr = array_intersect($resultid, $terminal_id);
		$resultid = $arr;
	}
}
//print_r($resultid);
$num = count($resultid);

echo "<h2 align=center>航班查询结果</h2>";
if ($num == 0) {
	echo "<div align='center'><font color='red'>没有找到符合查询条件的航班</font></div>";
	exit();
}
echo "<div align='center'>查询到<font color='red'>$num</font>条路线！如下表：</div>";
echo "<br>";
echo "<table border=1 width='80%' align='center'>";
echo "<th>flightNum</th>";
echo "<th>price</th>";
echo "<th>numSet</th>";
echo "<th>numAvail</th>";
echo "<th>FromCity</th>";
echo "<th>ArivCity</th>";
echo "<th>Book</th>";

//for ($i=0; $i < $num; $i++) { 
foreach ($resultid as $key => $value) {
	$bresult = mysqli_query($conn,"select * from flights where flightNum='$resultid[$key]'");
	$binfo = mysqli_fetch_array($bresult);
echo "<tr align=center><td>$binfo[flightNum]</td>";
echo "<td>$binfo[price]</td>";
echo "<td>$binfo[numSeat]</td>";
echo "<td>$binfo[numAvail]</td>";
echo "<td>$binfo[FromCity]</td>";
echo "<td>$binfo[ArivCity]</td>";
echo "<td><a href='flight_book.php' color=#0000ff>book</a></td>";

echo "</tr>";

}

echo "</table>";   

?>

	
	
	
	
	
	

