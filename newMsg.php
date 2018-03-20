<!DOCTYPE html>
<?php

require('databaseinfo.php');
session_start();

$sender = $_SESSION['ID'];

if($_SESSION['ID'])
{
?>

<form method="post" action="">
    <p>
        <label>To</label>
        <input type="text" name="To" />
    </p>

    <p>
        <label>Message</label>
        <textarea maxlength="256" name="message" rows="6" cols="30"></textarea>
    </p>
    <p>
        <input type="submit" name="send" value="Send message" />

    </p>
</form>


<form action="listMsg.php" method="POST">
        <input type="submit" name="Inbox" value="Go to your Inbox" />
</form>


<form action="logout.php" method="POST">
        <input type="submit" name="Logout" value="Logout" />
</form>
<?php
	if(isset($_POST['send']))
	{
	      	$conn = @mysqli_connect($Server, $MySuser, $MYSpass,$MYSdb) or die("There is an error");
	        $To = mysqli_real_escape_string($conn, $_POST['To']);
	        $msg = mysqli_real_escape_string($conn, $_POST['message']);
		$msgT = htmlspecialchars($msg, ENT_QUOTES, 'UTF-8');
        	#$msgEn = substr(md5($msgT), 0, 30);
                if(preg_match("/^[a-zA-Z0-9]+$/", $msg) === 0)
		{
			echo "You try to hack!";
		}
		else
		{
			$MYsqlcomm1 = $conn->prepare("SELECT ID FROM Users WHERE UserName = ?;");
		        $MYsqlcomm1->bind_param("s", $To);
	        	$MYsqlcomm1->execute();
		        $MYsqlcomm1->bind_result($ID);
        		$rows = $MYsqlcomm1->fetch();
			$MYsqlcomm1->close();

			if($rows != NULL)
			{
				$MYsqlcomm2 = $conn->prepare("INSERT INTO Msgs (FromUser,ToUser,Content) VALUES (?,?,?);");
  	     			$MYsqlcomm2->bind_param("iis",$sender,$ID,$msgT);
        			$MYsqlcomm2->execute();
	        		#       $MYsqlcomm->close();
	        	#	$conn->close();
			#       $MYsqlcomm->close();
		        #	$conn->close();
			}
			else
			{
				echo "The user you try to send message for him is not found.";
			}
		}
	}
}
else
{
        echo nl2br("Please login or register first.\n");
        echo nl2br("\n");
        echo "<form action=\"index.html\" method=\"POST\">";
        echo "<input type=\"submit\" name=\"home\" value=\"Login/register\"/>";
        echo "</form>";
}
?>
</html>
