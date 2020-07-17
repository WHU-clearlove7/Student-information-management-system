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
	$Score = $_POST["Score"];
	$op = $_POST["op"];
	if(($Score<"0" || $Score>"100")&&($op=="0"||$op=="2"))
	{
		echo "
	    <script>
	      alert('There is something wrong with your score');
	      window.location.href = 'SC.php' ;
	    </script>
		";
		exit;
	}
	if(($Sno=="" && $Sname==""&&$Cno==""&& $Cname=="")||$op == "" )
	{
	  echo "
	    <script>
	      alert('None of the information should be empty');
	      window.location.href = 'SC.php' ;
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
		$Score=check_input($Score);
		$Score=base64_encode($Score);
		mysqli_query($conn,"begin");
		if($Sno=="") {$check_query = mysqli_query($conn,"SELECT * FROM `sc` WHERE Cno='$Cno'");}
		if($Cno=="") {$check_query = mysqli_query($conn,"select * from SC where Sno='$Sno'");}
		else {$check_query = mysqli_query($conn,"select * from SC where Sno='$Sno' and Cno='$Cno'");}
		if($result=mysqli_fetch_array($check_query)){
			if($op == "0"){
				echo "
					<script>
					alert('Error, the score information existed.Please try again with a different student and course number.');
					window.location.href = 'SC.php' ;
					</script>
					";
				exit;
			}
			if($op == "1"){
				$sql = "DELETE FROM SC WHERE Cno='$Cno' and Sno='$Sno'";
				if(mysqli_query($conn,$sql)){
					mysqli_query($conn,"commit");
					mysqli_close($conn);
					echo "
						<script>
						alert('delete Course delete succeed!');
						window.location.href ='SC.php' ;
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
				if($Cname == "") {$Credit=$result['Cname'];}
				if($Sname == "") {$Remarks=$result['Sname'];}
				$sql = "UPDATE SC SET Cname='$Cname',Sname='$Sname',Score='$Score' WHERE Cno='$Cno' and Sno='$Sno'";
				if(mysqli_query($conn,$sql)){
					mysqli_query($conn,"commit");
					mysqli_close($conn);
					echo "
						<script>
						alert('Course alter succeed!');
						window.location.href = 'SC.php' ;
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
			if($op == "3"){
				echo "<html><head>
				<meta charset=\"utf-8\">
				<link rel=\"stylesheet\" type=\"text/css\" href=\"./styles.css\"></head><body><div class=\"bg-img1\" style=\"overflow-y:auto\"> ";
				echo"<table border=\"1\"><tr>
				<th>学  号</th>
				<th>姓  名</th>
				<th>课程号</th>
				<th>课程名</th>
				<th>成  绩</th>
				</tr>";
				echo"<tr><td>";
				echo$result['Sno'],"</td><td>";
				echo$result['Sname'],"</td><td>";
				echo$result['Cno'],"</td><td>";
				echo$result['Cname'],"</td><td>";
				echo base64_decode($result['Score']),"</td></tr>";	
				while($result = mysqli_fetch_array($check_query))
				{
					echo"<tr><td>";
					echo$result['Sno'],"</td><td>";
					echo$result['Sname'],"</td><td>";
					echo$result['Cno'],"</td><td>";
					echo$result['Cname'],"</td><td>";
					echo base64_decode($result['Score']),"</td></tr>";
				}
				echo"</table>";
				echo '<br /><a href="SC.php">Back</a><br />';
				echo "</div></body></html>";
				mysqli_query($conn,"commit");
				mysqli_close($conn);
				exit();
			}
		}
		else{
			if($op == "0"){
				$sql = "INSERT INTO SC(Sno,Sname,Cno,Cname,Score) VALUES('$Sno','$Sname','$Cno','$Cname','$Score')";
				if(mysqli_query($conn,$sql)){
					mysqli_query($conn,"commit");
					mysqli_close($conn);
					echo "
						<script>
						alert('Modification succeed!');
						window.location.href = 'SC.php' ;
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
			if($op == "1"|| $op == "2"||$op =="3"){
			    echo "
				    <script>
					alert('Error, Course name not exists.Please try again with a different username.');
					window.location.href = 'SC.php' ;
					</script>
				";
			exit;
			}
			
		}
	
    }
?>
