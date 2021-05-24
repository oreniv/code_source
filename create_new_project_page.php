<?php 
include_once 'dbconnection.php';

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

<p>1/2</p>

<form class="content" method="POST" action="add_items_to_sql.php" enctype="multipart/form-data">
            <label for="title">Title:</label><br>
            <input type="text" id="title" name="title" required><br>

            <label for="filename">Project's picture:</label><br>
            <input type="file" id="filename" name="filename"><br>

            <label for="description">Description:</label><br>
            <textarea name="description" rows="10" cols="30" required></textarea><br>

            <label for="deadline">Deadline:</label><br>
            <input type="date" id="deadline" name="deadline" required><br>

            <label for="budget">Budget:</label><br>
            <input type="number" id="budget" name="budget" min="0" required><br>

            <input class="withdraw_button" type="submit" value="Create project" name="submit">
            
</form>




<footer>
      <!-- jQuery pulls this -->
</footer>

</body>

</html>