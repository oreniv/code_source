<?php
session_start();

 if (!isset($_SESSION['userID'])) // check if the userID is already SET FOR THIS SESSION
    $_SESSION['userID'] = $_POST["uname"];

if ($_POST["kill_session"]) // if kill_session is return true then kill the session
{
    session_unset();
    session_destroy();
}
 
// From now on when I want the userID call it with $_SESSION['userID'] 
/************************** */








