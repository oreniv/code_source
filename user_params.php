<?php

session_start();

 if (!isset($_SESSION['userID'])) // check if the userID is already SET FOR THIS SESSION
 { 
    $_SESSION['userID'] = $_POST["userID"];  
     
 }

else if(!($_SESSION['full_name']) && isset($_SESSION['userID'])) 
{ 
    // execute only if i don't know the user name AND I DO HAVE a userID
    // fetch the full_name of logged in user 
    
    $sqlLoggedInUser = "SELECT users.full_name FROM users WHERE users.id =".$_SESSION['userID'];
     
    $uNameQuery = mysqli_query($conn,  $sqlLoggedInUser);
    $temp = mysqli_fetch_assoc($uNameQuery);
    $_SESSION['full_name'] = $temp['full_name'];

   

    
    

}



if ($_POST["kill_session"]) // if kill_session is returned true then kill the session
{
    session_unset();
    session_destroy();
}
 
// From now on when I want the userID call it with $_SESSION['userID'] 
/************************** */








