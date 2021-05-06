<?php 
    include_once 'dbconnection.php';
    
    session_start();
    echo "Current userID: ",$_SESSION['userID']," ||","  " , $_SESSION['full_name']; 

    $conn = mysqli_connect($servername, $username, $password, $dbname);


   
    $id = json_decode($_POST['id']);
    $action = json_decode($_POST['action']);
    
     $resultType = json_decode($_POST['type']);

     if($resultType)
        $type = "'".'project'."'";
     else if(!$resultType) 
        $type = "'".'sales_item'."'";
   
    $userID = $_SESSION['userID'];
   
 
     if($action){
        $sqlDeleteRow = "CALL remove_post_from_favorites($userID, $id, $type);";
        mysqli_query($conn, $sqlDeleteRow);
        mysqli_close($conn);
         
      } else {
        $sqlAddRow = "CALL add_post_to_favorites( $userID,$id,$type)";
        mysqli_query($conn, $sqlAddRow);
        mysqli_close($conn);
    }
 
 


    

   
?>