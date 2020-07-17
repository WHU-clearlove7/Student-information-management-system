<?php	 
	function check_input($value)
	{
		if(get_magic_quotes_gpc()){ //获取当前 magic_quotes_gpc 的配置选项 当 magic_quotes_gpc=On 时，如果输入的数据有单引号（’）、双引号（”）、反斜线（）与 NUL（NULL 字符）等字符都会被加上反斜线
			$value = htmlspecialchars(trim($value));//去掉空白
		} else {
			$value = addslashes(htmlspecialchars(trim($value))); //手动加上转义反斜线
		}
		return $value;
	}
		
	session_start();
	if(isset($_GET['logout'])&&$_GET['logout']){
		session_destroy();
		echo "
		<script>
			alert('Successfully Logged out!');
			window.location.href = 'index.html' ;
		</script>
		";
		exit;
		
	}
	$username = $_POST["Username"];
	$password = $_POST["Password"];
	$accounttype = $_POST["Accounttype"];
	if($accounttype == "Administrator")
	{
		$accounttype="1";
	}
	if($username == "" || $password == "")
	{
		echo "
		<script>
			alert('None of the information should be empty');
			window.location.href = 'index.html' ;
		</script>
		";
	}
	else
	{
		$conn = @mysqli_connect("localhost","root","root","S");
		if (!$conn){
			die("Connecting database error!" . mysql_connect_error());
		}
		

		$username=check_input($username);
		$password = MD5($password);
		
		mysqli_query($conn,"begin");
		$check_query = mysqli_query($conn,"select * from user where name='$username' and password='$password' and accounttype='$accounttype' limit 1 for update");
		if($result = mysqli_fetch_array($check_query)){
			$_SESSION['username']=$username;
			$_SESSION['accounttype']=$result['accounttype']	;
			mysqli_query($conn,"commit");
			mysqli_close($conn);
			echo "
			<script>
				alert('Hello $username!');
				window.location.href = 'mypage.php' ;
			</script>
			";
		} else {
			mysqli_query($conn,"commit");
			mysqli_close($conn);
			echo "
			<script>
				alert('Login failed with username: $username!');
				window.location.href = 'index.html' ;
			</script>
			";
			
		}
		
	}

	exit();
?>
