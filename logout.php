<?php
if(isset($_POST['Logout']))
{
        session_start();
        unset($_SESSION);
        session_destroy();
        session_write_close();
        header('Location: index.html');
        die;
#       session_destroy();
#       header('Location: index.html');
#       exit;
}
?>

