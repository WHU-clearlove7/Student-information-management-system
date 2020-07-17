<?php 
    echo "<html><head>
	<meta charset=\"utf-8\">
	<link rel=\"stylesheet\" type=\"text/css\" href=\"./styles.css\"></head><body><div class=\"bg-img1\" style=\"overflow-y:auto\"> ";
	$conn = @mysqli_connect("localhost","root","root","S");
	if (!$conn){
		die("Connecting database error!" . mysql_error());
	}	
	
	mysqli_query($conn,"begin");
	
	$result1 = mysqli_query($conn,"SELECT * FROM teacher where 1");
	echo"<table border=\"1\"><tr>
    	<th>教工号</th>
    	<th>姓  名</th>
		<th>性  别</th>
		<th>年  龄</th>
		<th>院  系</th>
		<th>薪  资</th>
  	</tr>";
	while($row = mysqli_fetch_array($result1))
  	{
		echo"<tr><td>";
		echo$row['Tno'],"</td><td>";
		echo$row['Tname'],"</td><td>";
		echo$row['Tsex'],"</td><td>";
		echo$row['Tage'],"</td><td>";
		echo$row['Tdept'],"</td><td>";
		echo base64_decode($row['Tsalary']),"</td></tr>";	
  	}		
		echo"</table>";
	echo"<form action=\"adminteacher.php\" method=\"POST\">
		Tno:<br>
		<input type=\"text\" name=\"Tno\">
		<br>
		Tname:<br>
		<input type=\"text\" name=\"Tname\">
		<br>
		Tsex:<br>
		<input type=\"text\" name=\"Tsex\">
		<br>
		Tage:<br>
		<input type=\"text\" name=\"Tage\">
		<br>
		Tdept:<br>
		<input type=\"text\" name=\"Tdept\">
		<br>
		Tsalary:<br>
		<input type=\"text\" name=\"Tsalary\">
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