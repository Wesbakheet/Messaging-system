<!DOCTYPE html>
<head>
<title>Registration form</title>
<h1>Registration form</h1>
<form action="" method="POST">
	<p><label>UserName : </label>
	<input id="username" type="text" name="username" placeholder="username" required /></p>

	<p><label>Password&nbsp;&nbsp; : </label>
	<input type="password" name="password" placeholder="password" required /></p>

	<p><label>Confirm password&nbsp;&nbsp; : </label>
	<input type="password" name="passconfirm" placeholder="confirm password" required><br>

	<p><input type="submit" name="submit" value="Sign UP"/></p>
</form>

<form action="index.html" method="POST">
	<p><input type="submit" name="submit" value="Home" /></p>
</form>

<?php

$salt= "skkgf4dfg!";
require('databaseinfo.php');
if(isset($_POST['submit']))
{

        $conn = @mysqli_connect($Server, $MySuser, $MYSpass,$MYSdb) or die("There is an error");

        $InputUser = mysqli_real_escape_string($conn, $_POST['username']);
        $password = mysqli_real_escape_string($conn, $_POST['password']);
        $PasswordEn = md5(md5($InputUser . $password) . $salt); #  substr(md5($password), 0, 30);
	$PassConfirm = mysqli_real_escape_string($conn, $_POST['passconfirm']);
	
	echo $PasswordEn;
        #Username Validation
        if(preg_match("/^[A-Z][a-zA-Z]+$/", $InputUser) === 0)
        {
                echo "UserName must be began with upper case letter and contain lower case letters only.";
        }
        else
        {
                #Password validation
                if(preg_match("/^.*(?=.{8,})(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z]).*$/", $password) === 0)
                {
                        echo "Password must be at least 8 characters,must contain at least one lower case letter, one upper case letter and one digit ";
                }
                else
                {
			if($password== $PassConfirm)
			{
				$MYsqlcomm = $conn->prepare("SELECT UserName FROM Users WHERE UserName = ?;");
		        	$MYsqlcomm->bind_param("s", $InputUser);
		        	$MYsqlcomm->execute();
        			$MYsqlcomm->bind_result($UserName);
        			$rows = $MYsqlcomm->fetch();
			        if($rows != NULL)
				{
					echo "This username already exist.";	
				}
				else
				{
                        		$MYsqlcomm = $conn->prepare("INSERT INTO Users (UserName, Password) VALUES (?, ?);");
		                        $MYsqlcomm->bind_param("ss", $InputUser, $PasswordEn);
                		        $MYsqlcomm->execute();
		                        header("Location: welcome.html", true, 301);
                		        $MYsqlcomm->close();
                        		$conn->close();
		                        $MYsqlcomm->close();
                		        $conn->close();
				}
			}
			else
			{
				echo "Password don't match";
			}
                }
        }
}
?>
</html>

