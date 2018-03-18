<!DOCTYPE html>
<title>Messages System</title>
<h3>Messages System:</h3>
<?php
session_start();
if(isset($_SESSION['ID'])) 
{
	echo nl2br("\n");
	echo nl2br("<a href=\"newMsg.php\">Send New Message</a>\n");
	echo nl2br("\n");
	echo nl2br("<a href=\"listMsg.php\">List you messages</a>\n");
	echo nl2br("\n");
	echo nl2br("<a href=\"dbdump.php\">Click here to download the database</a>\n");
	echo nl2br("\n");
	echo "<form action=\"logout.php\" method=\"POST\">";
	echo nl2br("<input type=\"submit\" name=\"Logout\" value=\"Logout\" />\n");
	echo "</form>";

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
