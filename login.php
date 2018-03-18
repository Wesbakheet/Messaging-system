<!DOCTYPE html>

<title>Login Page</title>
<h2>Login Page</h2>
<form action="" method="POST">
        <p><label>UserName : </label>
        <input id="username" type="text" name="username" placeholder="username" required /></p>

        <p><label>Password&nbsp;&nbsp; : </label>
        <input type="password" name="password" placeholder="password" required /></p>

        <input type="submit" name="Login" value="Login"/>
</form>

        <form action="index.html" method="POST">
                <p><input type="submit" name="Home" value="Home"/></p>
        </form>

<?php

$salt= "skkgf4dfg!";

require('databaseinfo.php');

if(isset($_POST['Login']))
{
	$conn = @mysqli_connect($Server, $MySuser, $MYSpass,$MYSdb) or die("There is an error");
	
	$username = mysqli_real_escape_string($conn, $_POST['username']);
	$password = mysqli_real_escape_string($conn, $_POST['password']);
	$PasswordEn = md5(md5($username . $password) . $salt);  # substr(md5($password),0, 30);
	
	$MYsqlcomm = $conn->prepare("SELECT ID FROM Users WHERE UserName = ? and Password = ?;");
	$MYsqlcomm->bind_param("ss", $username, $PasswordEn);
	$MYsqlcomm->execute();
	$MYsqlcomm->bind_result($ID);
	$rows = $MYsqlcomm->fetch();
	if($rows != NULL)
	{
		session_start();
		$_SESSION['ID'] = $ID;
               	$_SESSION['UserName'] = $username;
               	header("Location: messages.php", true, 301);
	}
	else
	{
		echo "Invalid Credentials.";
	}
	$MYsqlcomm->close();
	$conn->close();
}
?>
</html>
