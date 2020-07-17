<?php 
    echo "<html><head>
	<meta charset=\"utf-8\">
	<link rel=\"stylesheet\" type=\"text/css\" href=\"./styles.css\"></head><body><div class=\"bg-img1\" style=\"overflow-y:auto\"> ";
	session_start();
	if(!isset($_SESSION['username']) or !isset($_SESSION['accounttype'])){
		header("Location:index.html");
		exit();
	}
	
	$conn = @mysqli_connect("localhost","root","root","s");
	if (!$conn){
		die("Connecting database error!" . mysql_error());
	}	
	
	mysqli_query($conn,"begin");
	
	$username=$_SESSION['username'];
	$accounttype=$_SESSION['accounttype'];
	
	
	if($accounttype=="1"){
		echo"Welcome, ";
		echo$username,"! <br />";	
		echo"You are administrator of this system.<br /> What do you want to do? <br />";	
		echo '<a href="Student.php">管理学生信息</a><br />';
		echo '<a href="Teacher.php">管理教师信息</a><br />';
		echo '<a href="Course.php">管理课程信息</a><br />';
		echo '<a href="SelectCourse.php">管理选课信息</a><br />';
		echo '<a href="SC.php">管理成绩信息</a><br />';
		echo"If you want to create or delete a user please operate it in the following area.<br />";
		echo"用户表单如下：<be />";
		$result1 = mysqli_query($conn,"SELECT name,accounttype FROM user where 1");
		echo"<table border=\"1\"><tr>
    	<th>用户名</th>
    	<th>用户类型</th>
		</tr>";
		while($row = mysqli_fetch_array($result1))
		{
			echo"<tr><td>";
			echo$row['name'],"</td><td>";
			echo$row['accounttype'],"</td></tr>";	
		}		
		echo"</table><br />";	
		echo"<form action=\"admin.php\" method=\"POST\">
		Name:<br>
		<input type=\"text\" name=\"username\">
		<br>
		Password:<br>
		<input type=\"password\" name=\"password\">
		<br>
		accounttype:<br>
		<input type=\"text\" name=\"accounttype\">
		<br>
		<input type=\"radio\" name=\"op\" value=\"0\" /> create
		<input type=\"radio\" name=\"op\" value=\"1\" /> delete
		<br />		
		<input type=\"submit\" value=\"Submit\">
		</form> ";
				
	}
	else if($accounttype == "student"||$accounttype == "Student")
	{
		$result = mysqli_query($conn,"SELECT * FROM student where Sno='$username'");
		$row = mysqli_fetch_array($result);
		echo"欢迎来到A学生信息管理系统！<br />";
		echo"您的基本信息：<br />";
		echo"<table border=\"1\"><tr>
				<th>学  号</th>
				<th>姓  名</th>
				<th>性  别</th>
				<th>年  龄</th>
				<th>院  系</th>
				<th>班  级</th>
				</tr>";
				echo"<tr><td>";
				echo$row['Sno'],"</td><td>";
				echo$row['Sname'],"</td><td>";
				echo$row['Ssex'],"</td><td>";
				echo$row['Sage'],"</td><td>";
				echo$row['Sdept'],"</td><td>";
				echo$row['Class'],"</td></tr>";			
				echo"</table>";
		echo"您的选课与成绩信息：<br />";
		$result1 = mysqli_query($conn,"SELECT * FROM sc where Sno='$username'");
		echo"<table border=\"1\"><tr>
				<th>学  号</th>
				<th>姓  名</th>
				<th>课程号</th>
				<th>课程名</th>
				<th>成  绩</th>
				</tr>";
		while($row1 = mysqli_fetch_array($result1))
		{
				echo"<tr><td>";
				echo$row1['Sno'],"</td><td>";
				echo$row1['Sname'],"</td><td>";
				echo$row1['Cno'],"</td><td>";
				echo$row1['Cname'],"</td><td>";
				echo base64_decode($row1['Score']),"</td></tr>";	
		}
		echo"</table>";
		echo"您所在院系的名单如下：<br />";
		$result2 = mysqli_query($conn,"SELECT Sno,Sname,Ssex FROM Student where Sdept=(Select Sdept FROM Student Where Sno='$username')");
		echo"<table border=\"1\"><tr>
				<th>学  号</th>
				<th>姓  名</th>
				<th>性  别</th>
				</tr>";
		while($row2 = mysqli_fetch_array($result2))
		{
				echo"<tr><td>";
				echo$row2['Sno'],"</td><td>";
				echo$row2['Sname'],"</td><td>";
				echo$row2['Ssex'],"</td></tr>";	
		}
		echo"</table>";
		echo"您的老师信息如下：<br />";
		$result3 = mysqli_query($conn,"SELECT Tname,Tsex FROM Teacher where Tdept=(Select Sdept FROM Student Where Sno='$username')");
		echo"<table border=\"1\"><tr>
				<th>姓  名</th>
				<th>性  别</th>
				</tr>";
		while($row3 = mysqli_fetch_array($result3))
		{
				echo"<tr><td>";
				echo$row3['Tname'],"</td><td>";
				echo$row3['Tsex'],"</td></tr>";	
		}
		echo"</table>";
	}
	else if($accounttype == "teacher"||$accounttype == "Teacher")
	{
		$result = mysqli_query($conn,"SELECT * FROM teacher where Tno='$username'");
		$row = mysqli_fetch_array($result);
		echo"欢迎来到A教师信息管理系统！<br />";
		echo"您的基本信息：<br />";
		echo"<table border=\"1\"><tr>
				<th>职工号</th>
				<th>姓  名</th>
				<th>性  别</th>
				<th>年  龄</th>
				<th>院  系</th>
				<th>薪  资</th>
				</tr>";
				echo"<tr><td>";
				echo$row['Tno'],"</td><td>";
				echo$row['Tname'],"</td><td>";
				echo$row['Tsex'],"</td><td>";
				echo$row['Tage'],"</td><td>";
				echo$row['Tdept'],"</td><td>";
				echo base64_decode($row['Tsalary']),"</td></tr>";			
				echo"</table>";
				
		echo"您的学生有：<br />";
		$result1 = mysqli_query($conn,"SELECT * FROM Student Where Sdept=(Select Tdept FROM teacher where Tno='$username')");
		echo"<table border=\"1\"><tr>
				<th>学  号</th>
				<th>姓  名</th>
				<th>性  别</th>
				<th>年  龄</th>
				<th>院  系</th>
				<th>班  级</th>
				</tr>";
		while($row1 = mysqli_fetch_array($result1))
		{
			echo"<tr><td>";
				echo$row1['Sno'],"</td><td>";
				echo$row1['Sname'],"</td><td>";
				echo$row1['Ssex'],"</td><td>";
				echo$row1['Sage'],"</td><td>";
				echo$row1['Sdept'],"</td><td>";
				echo$row1['Class'],"</td></tr>";	
		}
		echo"</table>";
		
		echo"他们的课程成绩如下：<br />";
		$result2 = mysqli_query($conn,"SELECT *
FROM teacher, student, sc
WHERE teacher.Tdept = student.Sdept
AND student.Sno = sc.Sno
AND teacher.Tno = '$username'");
		echo"<table border=\"1\"><tr>
				<th>学  号</th>
				<th>姓  名</th>
				<th>课程号</th>
				<th>课程名</th>
				<th>成  绩</th>
				</tr>";
		while($row2 = mysqli_fetch_array($result2))
		{
			echo"<tr><td>";
				echo$row2['Sno'],"</td><td>";
				echo$row2['Sname'],"</td><td>";
				echo$row2['Cno'],"</td><td>";
				echo$row2['Cname'],"</td><td>";
				echo base64_decode($row2['Score']),"</td></tr>";	
		}
		echo"</table>";
	}
	else{
		echo" Welcome, ";
		echo$username,"! <br />";	
		echo"You are a test user.<br /> ";
	}
	echo '<br /><a href="index.html">Log out</a><br />';
	echo "</div></body></html>";
	mysqli_query($conn,"commit");
?>