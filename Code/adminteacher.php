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
	$Tno = $_POST["Tno"];
	$Tname = $_POST["Tname"];
	$Tsex = $_POST["Tsex"];
	$Tage = $_POST["Tage"];
	$Tdept = $_POST["Tdept"];
	$Tsalary = $_POST["Tsalary"];
	$op = $_POST["op"];
	if($Tno == ""  || $Tname== "" || $op == "" )
	{
	  echo "
	    <script>
	      alert('None of the information should be empty');
	      window.location.href = 'Teacher.php' ;
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
	
		$Tno=check_input($Tno);
		$Tname=check_input($Tname);
		$Tsex=check_input($Tsex);
		$Tage=check_input($Tage);
		$Tdept=check_input($Tdept);
		$Tsalary=check_input($Tsalary);
		$Tsalary=base64_encode($Tsalary);
		mysqli_query($conn,"begin");
		$check_query = mysqli_query($conn,"select * from Teacher where Tno='$Tno'");
		if($result=mysqli_fetch_array($check_query)){
			if($op == "0"){
				echo "
					<script>
					alert('Error, Tno existed.Please try again with a different Tno.');
					window.location.href = 'Teacher.php' ;
					</script>
					";
				exit;
			}
			if($op == "1"){
				$sql = "DELETE FROM Teacher WHERE Tno='$Tno'";
				if(mysqli_query($conn,$sql)){
					mysqli_query($conn,"commit");
					mysqli_close($conn);
					echo "
						<script>
						alert('Teacher delete succeed!');
						window.location.href ='Teacher.php' ;
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
				if($Tsex == "") {$Tsex=$result['Tsex'];}
				if($Tage == "") {$Tage=$result['Tage'];}
				if($Tdept == "") {$Tdept=$result['Tdept'];}
				if($Tsalary == "") {$Tsalary=$result['Tsalary'];}
				$sql = "UPDATE Teacher SET Tname='$Tname',Tsex='$Tsex',Tage='$Tage',Tdept='$Tdept',Tsalary='$Tsalary' WHERE Tno='$Tno'";
				if(mysqli_query($conn,$sql)){
					mysqli_query($conn,"commit");
					mysqli_close($conn);
					echo "
						<script>
						alert('Teacher alter succeed!');
						window.location.href = 'Teacher.php' ;
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
				<th>教工号</th>
				<th>姓  名</th>
				<th>性  别</th>
				<th>年  龄</th>
				<th>院  系</th>
				<th>薪  资</th>
				</tr>";
				echo"<tr><td>";
				echo$result['Tno'],"</td><td>";
				echo$result['Tname'],"</td><td>";
				echo$result['Tsex'],"</td><td>";
				echo$result['Tage'],"</td><td>";
				echo$result['Tdept'],"</td><td>";
				echo base64_decode($result['Tsalary']),"</td></tr>";			
				echo"</table>";
				echo '<br /><a href="Teacher.php">Back</a><br />';
				echo "</div></body></html>";
				mysqli_query($conn,"commit");
				mysqli_close($conn);
				exit();
			}
		}
		else{
			if($op == "0"){
				$sql = "INSERT INTO Teacher(Tno,Tname,Tsex,Tage,Tdept,Tsalary) VALUES('$Tno','$Tname','$Tsex','$Tage','$Tdept','$Tsalary')";
				if(mysqli_query($conn,$sql)){
					mysqli_query($conn,"commit");
					mysqli_close($conn);
					echo "
						<script>
						alert('Modification succeed!');
						window.location.href = 'Teacher.php' ;
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
			if($op == "1" || $op == "2" ||$op == "3"){
			    echo "
				    <script>
					alert('Error, username not exists.Please try again with a different username.');
					window.location.href = 'Teacher.php' ;
					</script>
				";
			exit;
			}
			
		}
	
    }
?>
