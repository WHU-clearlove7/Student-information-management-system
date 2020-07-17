 <?php
	header("Content-Type:text/html; charset=utf8");
	function check_input($value)
	{
		if(get_magic_quotes_gpc()){
			$value = htmlspecialchars(trim($value));
		} else {
			$value = addslashes(htmlspecialchars(trim($value)));
		}
		return $value;
	}
	$Sno = $_POST["Sno"];
	$Sname = $_POST["Sname"];
	$Cno = $_POST["Cno"];
	$Cname = $_POST["Cname"];
	$op = $_POST["op"];
	if(($Sno=="" && $Sname==""&&$Cno==""&& $Cname=="")||$op == "" )
	{
	  echo "
	    <script>
	      alert('None of the information should be empty');
	      window.location.href = 'SelectCourse.php' ;
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
	
		$Sno=check_input($Sno);
		$Sname=check_input($Sname);
		$Cno=check_input($Cno);
		$Cname=check_input($Cname);
		mysqli_query($conn,"begin");
		if($Sno=="" && $Sname=="") {$check_query = mysqli_query($conn,"select * from SelectCourse where Cno='$Cno' and Cname='$Cname'");}
		if($Cno=="" && $Cname=="") {$check_query = mysqli_query($conn,"select * from SelectCourse where Sno='$Sno' and Sname='$Sname'");}
		else {$check_query = mysqli_query($conn,"select * from SelectCourse where Sno='$Sno' and Cno='$Cno'");}
		$result=mysqli_fetch_array($check_query);
		if($result){
			if($op == "0"){
				echo "
					<script>
					alert('Error, the selectcourse information existed.Please try again with a different student and course number.');
					window.location.href = 'SelectCourse.php' ;
					</script>
					";
				exit;
			}
			if($op == "1"){
				$sql = "DELETE FROM SelectCourse WHERE Cno='$Cno' and Sno='$Sno'";
				if(mysqli_query($conn,$sql)){
					mysqli_query($conn,"commit");
					mysqli_close($conn);
					echo "
						<script>
						alert('Select Course delete succeed!');
						window.location.href ='SelectCourse.php' ;
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
				<th>学  号</th>
				<th>姓  名</th>
				<th>课程号</th>
				<th>课程名</th>
				</tr>";
				echo"<tr><td>";
				echo$result['Sno'],"</td><td>";
				echo$result['Sname'],"</td><td>";
				echo$result['Cno'],"</td><td>";
				echo$result['Cname'],"</td></tr>";
				while($result = mysqli_fetch_array($check_query))
				{
					echo"<tr><td>";
					echo$result['Sno'],"</td><td>";
					echo$result['Sname'],"</td><td>";
					echo$result['Cno'],"</td><td>";
					echo$result['Cname'],"</td></tr>";
				}		
				echo"</table>";
				echo '<br /><a href="SelectCourse.php">Back</a><br />';
				echo "</div></body></html>";
				mysqli_query($conn,"commit");
				mysqli_close($conn);
				exit();
			}
		}
		else{
			if($op == "0"){
				$sql = "INSERT INTO SelectCourse(Sno,Sname,Cno,Cname) VALUES('$Sno','$Sname','$Cno','$Cname')";
				if(mysqli_query($conn,$sql)){
					mysqli_query($conn,"commit");
					mysqli_close($conn);
					echo "
						<script>
						alert('Modification succeed!');
						window.location.href = 'SelectCourse.php' ;
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
			if($op == "1"||$op=="3"){
			    echo "
				    <script>
					alert('Error, Course name not exists.Please try again with a different username.');
					window.location.href = 'SelectCourse.php' ;
					</script>
				";
			exit;
			}
			
		}
	
    }
?>
