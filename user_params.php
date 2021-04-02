<?php
session_start();

 if (!isset($_SESSION['userID'])) // comment me if you want to reset userID
    $_SESSION['userID'] = $_POST["uname"];

 
 
// From now on when I want the userID call it with $_SESSION['userID'] 
/************************** */








