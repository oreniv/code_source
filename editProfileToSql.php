<?php 
include_once 'dbconnection.php';
include_once 'user_params.php';
include_once 'vision_api_check.php';

session_start();
echo "Current userID: ",$_SESSION['userID']," ||","  " , $_SESSION['full_name']; 

$userID = "'".$_SESSION['userID']."'";
$name =  "'".$_POST['nameEdit']."'";
$email =  "'".$_POST['email']."'";
$birthday =  "'".$_POST['start']."'";
$Address =  "'".$_POST['Address']."'";

$target_dir = "uploads/profile/";
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
    $myFile =  "'uploads/profile/" . htmlspecialchars( basename( $_FILES["filename"]["name"]))."'";
  } else {
    echo "Sorry, there was an error uploading your file.";
  }
}


if($name != "''")
{
    $conn = mysqli_connect($servername, $username, $password, $dbname);
    $sqlEditName = "UPDATE users SET full_name = $name WHERE id = $userID";
    mysqli_query($conn, $sqlEditName);
    mysqli_close($conn);
}
if($email != "''")
{
    $conn = mysqli_connect($servername, $username, $password, $dbname);
    $sqlEditMail = "UPDATE users SET email = $email WHERE id = $userID";
    mysqli_query($conn, $sqlEditMail);
    mysqli_close($conn);
}
if($birthday != "''")
{
    $conn = mysqli_connect($servername, $username, $password, $dbname);
    $sqlEditBirthday = "UPDATE users SET birthdate = $birthday WHERE id = $userID";
    mysqli_query($conn, $sqlEditBirthday);
    mysqli_close($conn);
}
if($Address != "''")
{
    $conn = mysqli_connect($servername, $username, $password, $dbname);
    $sqlEditAddress = "UPDATE users SET address = $Address  WHERE id = $userID";
    mysqli_query($conn, $sqlEditAddress);
    mysqli_close($conn);
}

if($uploadOk == 1)
{
    $conn = mysqli_connect($servername, $username, $password, $dbname);
    $sqlEditProfilePic = "UPDATE users SET profile_pic_link = $myFile WHERE id = $userID";
    mysqli_query($conn, $sqlEditProfilePic);
    mysqli_close($conn);
}


?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
    <link rel="stylesheet" href="styleSheet.css" />
    <title>Oray</title>
    <!-- Jquery import -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script> 
</head>

<body>
<script>
  window.alert("You are getting redirected, please wait few second after clicking on OK");
  window.history.go(-1);

</script>
</body>
</html>
