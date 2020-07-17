<?php 
    echo "<html><head>
	<meta charset=\"utf-8\">
	<link rel=\"stylesheet\" type=\"text/css\" href=\"./styles.css\"></head><body><div class=\"bg-img1\" style=\"overflow-y:auto\"> ";
	$conn = @mysqli_connect("localhost","root","root","S");
	if (!$conn){
		die("Connecting database error!" . mysql_error());
	}	
	
	mysqli_query($conn,"begin");
	
	$result1 = mysqli_query($conn,"SELECT * FROM course where 1");
	echo"<table border=\"1\"><tr>
    	<th>课程号</th>
    	<th>课程名称</th>
		<th>先导课程</th>
		<th>学  分</th>
		<th>类  别</th>
  	</tr>";
	while($row = mysqli_fetch_array($result1))
  	{
		echo"<tr><td>";
		echo$row['Cno'],"</td><td>";
		echo$row['Cname'],"</td><td>";
		echo$row['Cpno'],"</td><td>";
		echo$row['Credit'],"</td><td>";
		echo$row['Remarks'],"</td>";
  	}		
	echo"</table>";
		echo"<form action=\"admincourse.php\" method=\"POST\">
		Cno:<br>
		<input type=\"text\" name=\"Cno\">
		<br>
		Cname:<br>
		<input type=\"text\" name=\"Cname\">
		<br>
		Cpno:<br>
		<input type=\"text\" name=\"Cpno\">
		<br>
		Credit:<br>
		<input type=\"text\" name=\"Credit\">
		<br>
		Remarks:<br>
		<input type=\"text\" name=\"Remarks\">
		<br>
		<input type=\"radio\" name=\"op\" value=\"0\" /> create
		<input type=\"radio\" name=\"op\" value=\"1\" /> delete
		<input type=\"radio\" name=\"op\" value=\"2\" /> alter
		<input type=\"radio\" name=\"op\" value=\"3\" /> search
		<br />
		<input type=\"submit\" value=\"Submit\">
		</form> ";
	echo '<br /><a href="mypage.php">Back</a><br />';
	mysqli_query($conn,"commit");
	echo "</div></body></html>"
?>