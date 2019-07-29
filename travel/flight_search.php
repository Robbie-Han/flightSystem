<?php  
include('head.php');
require('dbconnect.php');

?>

<script type="text/javascript">
	function checksearch(){
		if(form1.start.value !==""&&form1.terminal.value !== ""){
			return true;
		}else{
			alert("请填入正确填入信息");
			return false;
		}
		
	}
</script>

<!DOCTYPE html>
<html>
<body>

<form name="form1" method="post" action="flight_search_result.php" onsubmit="checksearch()">
	<table width="60%" border="0" cellspacing="1" cellpadding="3" align="center">
		<tr>
			<th colspan="2">航班查询</th>
		</tr>
		

		<tr>
			<td width="26%" align="right">始发站：</td>
			<td width="74%" height="25">
				<input type="text" name="start" size="50">
			</td>
		</tr>

		<tr>
			<td width="26%" align="right">终点站：</td>
			<td width="74%" height="25">
				<input type="text" name="terminal" size="50">
			</td>
		</tr>

		<tr>
			<td width="26%" align="right">
				<input type="submit" name="submit" value="提交">
			</td>
			<td width="74%">
				<input type="reset" name="submit2" value="重置">
			</td>
		</tr>
	</table>
</form>

</body>
</html>