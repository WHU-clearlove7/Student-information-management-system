<?php 
    echo "<html><head>
	<meta charset=\"utf-8\">
	<link rel=\"stylesheet\" type=\"text/css\" href=\"./styles.css\"></head><body><div class=\"bg-img1\" style=\"overflow-y:auto\"> ";
	$conn = @mysqli_connect("localhost","root","root","S");
	if (!$conn){
		die("Connecting database error!" . mysql_error());
	}	
	
	mysqli_query($conn,"begin");
	
	$result1 = mysqli_query($conn,"SELECT * FROM sc where 1");
	echo"<table border=\"1\"><tr>
    	<th>学  号</th>
    	<th>姓  名</th>
		<th>课程号</th>
		<th>课程名称</th>
		<th>成  绩</th>
  	</tr>";
	while($row = mysqli_fetch_array($result1))
  	{
		echo"<tr><td>";
		echo$row['Sno'],"</td><td>";
		echo$row['Sname'],"</td><td>";
		echo$row['Cno'],"</td><td>";
		echo$row['Cname'],"</td><td>";
		echo base64_decode($row['Score']),"</td>";	
  	}		
	echo"</table><br />";
	echo"<form action=\"adminsc.php\" method=\"POST\">
		Sno:<br>
		<input type=\"text\" name=\"Sno\">
		<br>
		Sname:<br>
		<input type=\"text\" name=\"Sname\">
		<br>
		Cno:<br>
		<input type=\"text\" name=\"Cno\">
		<br>
		Cname:<br>
		<input type=\"text\" name=\"Cname\">
		<br>
		Score:<br>
		<input type=\"text\" name=\"Score\">
		<br>
		<input type=\"radio\" name=\"op\" value=\"0\" /> create
		<input type=\"radio\" name=\"op\" value=\"1\" /> delete
		<input type=\"radio\" name=\"op\" value=\"2\" /> alter
		<input type=\"radio\" name=\"op\" value=\"3\" /> search
		<br />
		<input type=\"submit\" value=\"Submit\">
		</form> ";
	echo '<a href="mypage.php">Back</a><br />';
	mysqli_query($conn,"commit");
	echo "</div></body></html>"
?>