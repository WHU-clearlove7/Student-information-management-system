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
	$username = $_POST["username"];
	$password = $_POST["password"];
	$accounttype = $_POST["accounttype"];
	$op = $_POST["op"];
	if($username == ""  || $op == "" )
	{
	  echo "
	    <script>
	      alert('None of the information should be empty');
	      window.location.href = 'mypage.php' ;
	    </script>
	  ";
	}
	if($password == "" && $op == "0")
	{
		echo "
	    <script>
	      alert('if you want to create a user, you must input password');
	      window.location.href = 'mypage.php' ;
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
	
		$username=check_input($username);
		$password=MD5($password);
		mysqli_query($conn,"begin");
		$check_query = mysqli_query($conn,"select * from user where name='$username' for update");
		if(mysqli_fetch_array($check_query)){
			if($op == "0"){
				echo "
					<script>
					alert('Error, username existed.Please try again with a different username.');
					window.location.href = 'mypage.php' ;
					</script>
					";
				exit;
			}
			if($op == "1"&&$username!="root"){
				$sql = "DELETE FROM user WHERE name='$username'";
				if(mysqli_query($conn,$sql)){
					mysqli_query($conn,"commit");
					mysqli_close($conn);
					echo "
						<script>
						alert('User delete succeed!');
						window.location.href ='mypage.php' ;
						</script>
						";
					exit();
				} else {
					echo'Fail writing database.',
					mysqli_error($conn),'<br />';
					echo 'Click here to <a href="javascript:history.back(-1);">go back</a> and retry';
					mysqli_query($conn,"rollback");
						mysqli_close($conn);
					exit();
				}
			}
			else if($op == "1"&&$username == "root"){
				echo "
					<script>
					alert('Error!You can not delete user root!');
					window.location.href = 'mypage.php' ;
					</script>
					";
				exit;
			}
		}
		else{
			if($op == "0"){
				$sql = "INSERT INTO user(name,password,accounttype) VALUES('$username','$password','$accounttype')";
				if(mysqli_query($conn,$sql)){
					mysqli_query($conn,"commit");
					mysqli_close($conn);
					echo "
						<script>
						alert('Modification succeed!');
						window.location.href = 'mypage.php' ;
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
			if($op == "1"){
			    echo "
				    <script>
					alert('Error, username not exists.Please try again with a different username.');
					window.location.href = 'mypage.php' ;
					</script>
				";
			exit;
			}
			
		}
	
    }
?>
