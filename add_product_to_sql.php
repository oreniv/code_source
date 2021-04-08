<?php 
include_once 'dbconnection.php';
include_once 'user_params.php';
session_start();
echo "Current userID: ",$_SESSION['userID']," ||","  " , $_SESSION['full_name']; 


$userID = $_SESSION['userID'];
$title = "'".$_POST['title']."'";
$description = "'".$_POST['description']."'";
$tag = "'".$_POST['tags']."'";
$price =$_POST['price'];
$durationDay =$_POST['dayDuration'];
$durationHour =$_POST['timeDuration'];
$type ="'".$_POST['type']."'";
$filament ="'".$_POST['filament']."'";  
$pic_link = "'"."picture link here"."'"; 
$page_link = "'"." page link here"."'";

$conn = mysqli_connect($servername, $username, $password, $dbname);

$sql = "CALL insert_sales_item($userID,$title,$description,$type,$price,$pic_link,$page_link,$durationDay,$price,$filament);";
var_dump($sql);

if (mysqli_query($conn, $sql)) {
    echo "New record created successfully";
    } else {
      echo "Error: " . $sql . "<br>"  . mysqli_error($conn);
      }
                  
mysqli_close($conn);


?>
