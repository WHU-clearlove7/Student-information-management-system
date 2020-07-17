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
	$Sno = $_POST["Sno"];
	$Sname = $_POST["Sname"];
	$Ssex = $_POST["Ssex"];
	$Sage = $_POST["Sage"];
	$Sdept = $_POST["Sdept"];
	$Class = $_POST["Class"];
	$op = $_POST["op"];
	if($Sno == ""  || $Sname== "" || $op == "" )
	{
	  echo "
	    <script>
	      alert('None of the information should be empty');
	      window.location.href = 'Student.php' ;
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
		$Ssex=check_input($Ssex);
		$Sage=check_input($Sage);
		$Sdept=check_input($Sdept);
		$Class=check_input($Class);
		mysqli_query($conn,"begin");
		$check_query = mysqli_query($conn,"select * from Student where Sno='$Sno'");
		if($result=mysqli_fetch_array($check_query)){
			if($op == "0"){
				echo "
					<script>
					alert('Error, Sno existed.Please try again with a different student number.');
					window.location.href = 'Student.php' ;
					</script>
					";
				exit;
			}
			if($op == "1"){
				$sql = "DELETE FROM Student WHERE Sno='$Sno'";
				if(mysqli_query($conn,$sql)){
					mysqli_query($conn,"commit");
					mysqli_close($conn);
					echo "
						<script>
						alert('Student delete succeed!');
						window.location.href ='Student.php' ;
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
				if($Ssex == "") {$Ssex=$result['Ssex'];}
				if($Sage == "") {$Sage=$result['Sage'];}
				if($Sdept == "") {$Sdept=$result['Sdept'];}
				if($Class == "") {$Class=$result['Class'];}
				$sql = "UPDATE Student SET Sname='$Sname',Ssex='$Ssex',Sage='$Sage',Sdept='$Sdept',Class='$Class' WHERE Sno='$Sno'";
				if(mysqli_query($conn,$sql)){
					mysqli_query($conn,"commit");
					mysqli_close($conn);
					echo "
						<script>
						alert('Student alter succeed!');
						window.location.href = 'Student.php' ;
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
				<th>性  别</th>
				<th>年  龄</th>
				<th>院  系</th>
				<th>班  级</th>
				</tr>";
				echo"<tr><td>";
				echo$result['Sno'],"</td><td>";
				echo$result['Sname'],"</td><td>";
				echo$result['Ssex'],"</td><td>";
				echo$result['Sage'],"</td><td>";
				echo$result['Sdept'],"</td><td>";
				echo$result['Class'],"</td></tr>";			
				echo"</table>";
				echo '<br /><a href="Student.php">Back</a><br />';
				echo "</div></body></html>";
				mysqli_query($conn,"commit");
				mysqli_close($conn);
				exit();
			}
		}
		else{
			if($op == "0"){
				$sql = "INSERT INTO Student(Sno,Sname,Ssex,Sage,Sdept,Class) VALUES('$Sno','$Sname','$Ssex','$Sage','$Sdept','$Class')";
				if(mysqli_query($conn,$sql)){
					mysqli_query($conn,"commit");
					mysqli_close($conn);
					echo "
						<script>
						alert('Modification succeed!');
						window.location.href = 'Student.php' ;
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
			if($op == "1" || $op == "2"||$op == "3"){
			    echo "
				    <script>
					alert('Error, student name not exists.Please try again with a different username.');
					window.location.href = 'Student.php' ;
					</script>
				";
			exit;
			}
			
		}
	
    }
?>
