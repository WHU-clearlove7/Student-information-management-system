 <?php
	function check_input($value)
	{
		if(get_magic_quotes_gpc()){
			$value = htmlspecialchars(trim($value));
		} else {
			$value = addslashes(htmlspecialchars(trim($value)));
		}
		return $value;
	}
	$Cno = $_POST["Cno"];
	$Cname = $_POST["Cname"];
	$Cpno = $_POST["Cpno"];
	$Credit = $_POST["Credit"];
	$Remarks = $_POST["Remarks"];
	$op = $_POST["op"];
	if($Cno == ""  || $Cname== "" || $op == "" )
	{
	  echo "
	    <script>
	      alert('None of the information should be empty');
	      window.location.href = 'Course.php' ;
	    </script>
	  ";
	}
    else
    {
		//connect to mysql	
		$conn = @mysqli_connect("localhost","root","root","S");
		if (!$conn){
			die("Connecting database error!" . mysqli_error());
		}
	
		$Cno=check_input($Cno);
		$Cname=check_input($Cname);
		$Cpno=check_input($Cpno);
		$Credit=check_input($Credit);
		$Remarks=check_input($Remarks);
		mysqli_query($conn,"begin");
		$check_query = mysqli_query($conn,"select * from Course where Cno='$Cno'");
		if($result=mysqli_fetch_array($check_query)){
			if($op == "0"){
				echo "
					<script>
					alert('Error, Cno existed.Please try again with a different course number.');
					window.location.href = 'Course.php' ;
					</script>
					";
				exit;
			}
			if($op == "1"){
				$sql = "DELETE FROM Course WHERE Cno='$Cno'";
				if(mysqli_query($conn,$sql)){
					mysqli_query($conn,"commit");
					mysqli_close($conn);
					echo "
						<script>
						alert('Course delete succeed!');
						window.location.href ='Course.php' ;
						</script>
						";
					exit();
				} else {
					echo 'Fail writing database.',mysqli_error(),'<br />';
					echo 'Click here to <a href="javascript:history.back(-1);">go back</a> and retry';
					mysqli_query($conn,"rollback");
						mysqli_close($conn);
					exit();
				}
			}
			if($op == "2") {
				if($Credit == "") {$Credit=$result['Credit'];}
				if($Remarks == "") {$Remarks=$result['Remarks'];}
				if($Cpno == "") {$Cpno=$result['Cpno'];}
				$sql = "UPDATE Course SET Cname='$Cname',Cpno='$Cpno',Remarks='$Remarks',Credit='$Credit' WHERE Cno='$Cno'";
				if(mysqli_query($conn,$sql)){
					mysqli_query($conn,"commit");
					mysqli_close($conn);
					echo "
						<script>
						alert('Course alter succeed!');
						window.location.href = 'Course.php' ;
						</script>
						";
					exit();
				} else {
					echo 'Fail writing database.',mysqli_error(),'<br />';
					echo 'Click here to <a href="javascript:history.back(-1);">go back</a> and retry';
					mysqli_query($conn,"rollback");
					mysqli_close($conn);
					exit();
				}
			}
			if($op == "3"){
				echo "<html><head>
				<meta charset=\"utf-8\">
				<link rel=\"stylesheet\" type=\"text/css\" href=\"./styles.css\"></head><body><div class=\"bg-img1\" style=\"overflow-y:auto\"> ";
				echo"<table border=\"1\"><tr>
				<th>课程号</th>
				<th>课程名</th>
				<th>先导课程</th>
				<th>学  分</th>
				<th>类  别</th>
				</tr>";
				echo"<tr><td>";
				echo$result['Cno'],"</td><td>";
				echo$result['Cname'],"</td><td>";
				echo$result['Cpno'],"</td><td>";
				echo$result['Credit'],"</td><td>";
				echo$result['Remarks'],"</td></tr>";		
				echo"</table>";
				echo '<br /><a href="Course.php">Back</a><br />';
				echo "</div></body></html>";
				mysqli_query($conn,"commit");
				mysqli_close($conn);
				exit();
			}
		}
		else{
			if($op == "0"){
				if($Cpno == "") {$sql = "INSERT INTO Course(Cno,Cname,Cpno,Credit,Remarks) VALUES('$Cno','$Cname',NULL,'$Credit','$Remarks')";}
				else{$sql = "INSERT INTO Course(Cno,Cname,Cpno,Credit,Remarks) VALUES('$Cno','$Cname','$Cpno','$Credit','$Remarks')";}
				if(mysqli_query($conn,$sql)){
					mysqli_query($conn,"commit");
					mysqli_close($conn);
					echo "
						<script>
						alert('Modification succeed!');
						window.location.href = 'Course.php' ;
						</script>
						";
					exit();
				} else {
					echo 'Fail writing database.',mysqli_error($conn),'<br />';
					echo 'Click here to <a href="javascript:history.back(-1);">go back</a> and retry';
					mysqli_query($conn,"rollback");
        		    mysqli_close($conn);
					exit();
				}
			}
			if($op == "1" || $op == "2"||$op == "3"){
			    echo "
				    <script>
					alert('Error, Course name not exists.Please try again with a different username.');
					window.location.href = 'Coursese.php' ;
					</script>
				";
			exit;
			}
			
		}
	
    }
?>
