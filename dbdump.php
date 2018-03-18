<?php
require('databaseinfo.php');
session_start();

$secret = 'a_password_of_your_choice';
$file = "/tmp/".date("d-m-y").".sql";
$encrypted = $file.".enc";
$command = exec("/usr/bin/mysqldump -h $Server -u $MySuser -p'$MYSpass' $MYSdb > $file");
$commandenc = "openssl enc -aes-256-cbc -salt -in $file -out $encrypted -pass pass:$secret";

if(isset($_SESSION['ID']))
{
	$output = shell_exec($commandenc);
	
	if (file_exists($encrypted))
	{
 		header('Content-Description: File Transfer');
		header('Content-Type: application/octet-stream');
		header('Content-Disposition: attachment; filename='.basename($encrypted));
		header('Content-Transfer-Encoding: binary');
		header('Expires: 0');
		header('Cache-Control: must-revalidate');
		header('Pragma: public');
		header('Content-Length: ' . filesize($encrypted));
		ob_clean();
		flush();
		readfile($encrypted);
		exit;
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
