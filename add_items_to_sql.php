<?php 
include_once 'dbconnection.php';
include_once 'vision_api_check.php' ;

session_start();
echo "Current userID: ",$_SESSION['userID']," ||","  " , $_SESSION['full_name']; 
 
 
?>

<!DOCTYPE html>
<html>


<head>

<meta charset="utf-8" />
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
   <link rel="stylesheet" href="styleSheet.css" />
    <title>Oray</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script> 
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
</head>

<script>
 
 $(document).ready(function(){
   $(".header_class").load("header.php");
   $("footer").load("footer.html");
 });
 
</script>

<body>
  
<header class="header_class">
  <!-- Header is loaded with jQuery -->
</header>








<footer>
      <!-- jQuery pulls this -->
</footer>

<?php 

 
$title = "'".$_POST['title']."'";
$description = "'".$_POST['description']."'";
$deadline = "'".$_POST['deadline']."'";
$budget = $_POST['budget'];



$target_dir = "uploads/projects/";
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
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
  echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
  $uploadOk = 0;
}

if (vision_api($_FILES["filename"]["tmp_name"]) == False)
  {$uploadOk = 0;}

// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
  echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
} else {
  if (move_uploaded_file($_FILES["filename"]["tmp_name"], $target_file)) {
    echo "The file ". htmlspecialchars( basename( $_FILES["filename"]["name"])). " has been uploaded.";
    $myFile =  "'uploads/projects/" . htmlspecialchars( basename( $_FILES["filename"]["name"]))."'";
  } else {
    echo "Sorry, there was an error uploading your file.";
  }
}

if($uploadOk != 0 ){
    
    $conn = mysqli_connect($servername, $username, $password, $dbname);
    $sql = "INSERT INTO project (posterID, project_name, project_description, project_pic_link, project_status, deadline, budget, bid_count) VALUES (".$_SESSION['userID'].", ".$title.", ".$description.", '".$target_file."', 'online', ".$deadline.", ".$budget.", '0');";
   
    if( mysqli_query($conn, $sql)){
      $lastId = mysqli_insert_id($conn);
    }
    mysqli_close($conn);

    
}


?>


<script>

var projectId = <?= $lastId ?>;
console.log(projectId);
load();
    function load()
    {
    window.location.href = "add_item_to_project_sql.php?projectId="+projectId+"";
    }
</script>


</body>

</html>