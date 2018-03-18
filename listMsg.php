<!DOCTYPE html>
<?php

require('databaseinfo.php');
session_start();

$ID =  $_SESSION['ID'];
$LoginU = $_SESSION['UserName'];

$conn = @mysqli_connect($Server, $MySuser, $MYSpass,$MYSdb) or die("There is an error");

if(isset($_SESSION['ID']))
{
	$MYsqlcomm1 = $conn->prepare("SELECT * FROM Msgs WHERE FromUser=? OR ToUser=?;");
        $MYsqlcomm1->bind_param("ii", $ID, $ID);
       	$MYsqlcomm1->execute();
        $MYsqlcomm1->store_result();
	$MYsqlcomm1->bind_result($FromUser, $ToUser, $Content);
?>

<h2>This is the list of your messages:</h2>

<table border="1" style="width:50%">
        <tr>
                <th>From</th>
                <th>To</th>
                <th>Message</th>
        </tr>

<?php
	while ($MYsqlcomm1->fetch())
	{
		if($FromUser != $ID && $ToUser== $ID)
		{
			$MYsqlcomm2 = $conn->prepare("SELECT UserName FROM Users WHERE ID=?;");
			$MYsqlcomm2->bind_param("i", $FromUser);
        		$MYsqlcomm2->execute();
       			$MYsqlcomm2->bind_result($UserName);
			$rows = $MYsqlcomm2->fetch();
			$FromU = $UserName;
			$ToU = $LoginU;
			$MYsqlcomm2->close();
		}
		elseif ($FromUser == $ID && $ToUser != $ID)
		{
			$MYsqlcomm2 = $conn->prepare("SELECT UserName FROM Users WHERE ID=?;");
			$MYsqlcomm2->bind_param("i", $ToUser);
                        $MYsqlcomm2->execute();
	                $MYsqlcomm2->bind_result($UserName);
       		        $rows = $MYsqlcomm2->fetch();
			$FromU = $LoginU;
			$ToU = $UserName;
			$MYsqlcomm2->close();
		}
?>
		<tr>
        	        <td><?php echo $FromU;?></td>
                	<td><?php echo $ToU;?></td>
                	<td><?php echo $Content ;?></td>
	        </tr>
<?php
	}
	$MYsqlcomm1->free_result();
	$MYsqlcomm1->close();
	$conn->close();
?>
</table>

<form action="logout.php" method="POST">
        <input type="submit" name="Logout" value="Logout" />
</form>

<form action="newMsg.php" method="POST">
        <input type="submit" name="Newmessage" value="New message" />
</form>

<?php
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
