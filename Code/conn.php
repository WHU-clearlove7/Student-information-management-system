<?php
	$conn = @mysqli_connect("localhost","root","root");
	if (!$conn){
		die("Connecting database error!" . mysql_error());
	}
	mysql_select_db("user", $conn);
?>
