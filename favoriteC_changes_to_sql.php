<?php 
    include_once 'dbconnection.php';
    
    session_start();
    echo "Current userID: ",$_SESSION['userID']," ||","  " , $_SESSION['full_name']; 

    $conn = mysqli_connect($servername, $username, $password, $dbname);


    $id_dirty = json_decode($_POST['id']);
    $action = json_decode($_POST['action']);

    $id_clean = str_replace( "a", "", $id_dirty);

    if($action == "insert"){
        $sqlAddRow = "CALL add_post_to_favorites($_SESSION['userID'],$id_clean, 'sales_item');";
        mysqli_query($conn, $sqlAddRow);
    } else {
        $sqlDeleteRow = "CALL remove_post_from_favorites($_SESSION['userID'], $id_clean, 'sales_item');";
        mysqli_query($conn, $sqlDeleteRow);
    }


    mysqli_close($conn);

   
?>