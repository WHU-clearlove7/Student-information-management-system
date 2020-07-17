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
	$password2 = $_POST["password2"];
	$accounttype = $_POST["accounttype"];
	if($username == "" || $password == "" || $password2 == "" )
	{
	  echo "
	    <script>
	      alert('None of the information should be empty');
	      window.location.href = 'register.html' ;
	    </script>
	  ";
	}
      else if($password  != $password2)
      {
          echo "
            <script>
              alert('Password confirmation error!');
              window.location.href = 'register.html' ;
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
	$password = MD5($password);//以MD5散列值存储密码
	$accounttype = check_input($accounttype);
	mysqli_query($conn,"begin");
	$check_query = mysqli_query($conn,"select * from user where name='$username' limit 1");
	if(mysqli_fetch_array($check_query)){
	  echo "
            <script>
              alert('Error, username existed.Please try again with a different username.');
              window.location.href = 'register.html' ;
            </script>
          ";
	    exit;
	}
	
	$sql = "INSERT INTO user(name,password,accounttype) VALUES('$username','$password','$accounttype')";
	if(mysqli_query($conn,$sql)){
	    mysqli_query($conn,"commit");
	    mysqli_close($conn);
	    echo "
            <script>
              alert('Succesfully Registered');
              window.location.href = 'index.html' ;
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
?>
