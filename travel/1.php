
<?php 
error_reporting(E_ALL ^ E_NOTICE);
$numAvail = $_POST['numAvail'];
echo $numAvail ;
echo 2;

?>
<td><form action="" method = 'post' >
		<input type="hidden" name="numAvail" value="<?php echo 3;?>">
    		<input type="submit" name ='book' value = 'book' />
    	</form></td>
