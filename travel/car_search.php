<?php  
include('head.php');
require('dbconnect.php');

?>

<script type="text/javascript">
	function checksearch(){
		if(form1.location.value !== ""){
			return true;
		}else{
			alert("请填入地址信息");
			return false;
		}
		
	}
</script>
<!DOCTYPE html>
<html>
<body>

<form name="form1" method="post" action="car_search_result.php" onsubmit="checksearch()">
	<table width="60%" border="0" cellspacing="1" cellpadding="3" align="center">
		<tr>
			<th colspan="2">汽车查询</th>
		</tr>
		

		<tr>
			<td width="26%" align="right">地点：</td>
			<td width="74%" height="25">
				<input type="text" name="location" size="50">
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