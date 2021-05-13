<?php
include_once 'dbconnection.php';
session_start();
echo "Current userID: ",$_SESSION['userID']," ||","  " , $_SESSION['full_name']; 


$userID = "'".$_SESSION['userID']."'";
$title =  "'".$_POST['title']."'";
$description =  "'".$_POST['description']."'";
$type =  $_POST['mSelect'];
$projectId = $_POST['projectId'];

if($type == 1)
$type = "'3D-Schema'";
else if($type == 2)
$type = "'2D-Sketch'";
else $type ="'Physical-item'";





$target_dir = "uploads/items/";
$target_file = $target_dir . basename($_FILES["filename"]["name"]);

$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
  $check = getimagesize($_FILES["filename"]["tmp_name"]);
  if($check !== false) {
    echo "File is an image - " . $check["mime"] . ".";
    $uploadOk = 1;
  } else {
    echo "File is not an image.";
    $uploadOk = 0;
  }
}

// Check if file already exists
if (file_exists($target_file)) {
  echo "Sorry, file already exists.";
  $uploadOk = 0;
}

// Check file size
if ($_FILES["filename"]["size"] > 500000000) {
  echo "Sorry, your file is too large.";
  $uploadOk = 0;
}

// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "gif" ) {
  echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
  $uploadOk = 0;
}

if (vision_api($_FILES["filename"]["tmp_name"]) == False)
  $uploadOk = 0;

// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
  echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
} else {
  if (move_uploaded_file($_FILES["filename"]["tmp_name"], $target_file)) {
    echo "The file ". htmlspecialchars( basename( $_FILES["filename"]["name"])). " has been uploaded.";
    $myFile =  "'uploads/items/" . htmlspecialchars( basename( $_FILES["filename"]["name"]))."'";
    $conn = mysqli_connect($servername, $username, $password, $dbname);
    echo $projectId;
    echo $myFile;
    echo $description;
    echo $type;

    $sql = "CALL insert_project_item(".$projectId.", ".$myFile.", ".$description.", ".$type.");";
    echo "fuck you";
    if( mysqli_query($conn, $sql)){
        echo "fuck you again again";
        $lastId = mysqli_insert_id($conn);
        echo $lastId;
      }
    mysqli_close($conn);
    
  } else {
    echo "Sorry, there was an error uploading your file.";
  }
}

?>



