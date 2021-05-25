<?php
include_once 'dbconnection.php';
session_start();


  
 


if(!isset($_GET['itemID']))
  $_GET['itemID'] = $_POST['itemID'];

$sqlGetbidInfo = "SELECT * FROM project_item WHERE id=".$_GET['itemID'] ; 
$query = mysqli_query($conn, $sqlGetbidInfo);  
$query = mysqli_fetch_assoc($query); 
$info = json_encode($query);
// get the user who this project belongs to
$sqlGetPosterID = "SELECT posterID FROM project INNER JOIN
project_item ON project.id = project_item.projectID 
Where project_item.id =".$_GET['itemID'] ; 
$query = mysqli_query($conn, $sqlGetPosterID);  
$query = mysqli_fetch_assoc($query); 
$posterID = json_encode($query);

/*  This section handles bid submission  */
if (isset($_POST['itemID']))
{

  $conn = mysqli_connect($servername, $username, $password, $dbname);
  $notes = "'".$_POST['notes']."'" ;
  $sqlInsertBid = "CALL insert_project_item_bid (".$_POST['itemID'].",".$_SESSION['userID'].",".$_POST['asking_price'].",".$notes.")";  
    

  if (!mysqli_query($conn,  $sqlInsertBid)) {
    echo("Error description: " . mysqli_error($conn));
    $_SESSION['db_error'] = True;
  }
  else
  $_SESSION['db_error'] = False;

  mysqli_close($conn);
  $conn = mysqli_connect($servername, $username, $password, $dbname);
  header("Location:project_page.php?projectID=".$query["projectID"]);
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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script> 
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
</head>


<!--  jQuery loading header and footer -->
<script>
 
 $(document).ready(function(){
   $(".header_class").load("header.php");
   $("footer").load("footer.html");
 });
 
</script>

<script>

function appendInfo()
{
  page_info = <?=  $info ?> ;
  posterID = <?= $posterID  ?> ; 
 
  document.getElementById("item_description").innerHTML = page_info["item_description"] ; 
  document.getElementById("item_type").innerHTML = page_info["item_type"] ; 
  document.getElementById("item_pic").setAttribute("src",page_info["part_pic"]);
  document.getElementById("itemID").value = page_info["id"];

    if (<?= json_encode($_SESSION['userID']) ?>  == posterID['posterID'])
    {  
      document.getElementById("bid_submit_button").innerHTML = "You can't submit a bid on your own project";
      document.getElementById("bid_submit_button").disabled = true;
    }
    else if (<?= json_encode($_SESSION['userID']) ?>  == -1)
    {  
      document.getElementById("bid_submit_button").innerHTML = "Must be logged in to submit a bid";
      document.getElementById("bid_submit_button").disabled = true;
    }

} 



</script>

<header class="header_class"></header>
<body>
<div class="container px-4">
  <div class="row gx-5 ">
    <div class="col shadow-lg">
      <img src="..." id="item_pic" class="img-fluid" alt="Image placeholder" style="max-width:400px;height:auto;">
    </div>
    <div class="col">
    <ul class="list-group shadow-lg text-center text-wrap "">
       <li class="list-group-item" id="item_description" >Item desc</li>
       <li class="list-group-item" id="item_type" >Item type</li>
    </ul>
      <div class="row">
         <button id="bid_submit_button" type="button" data-bs-toggle="modal" data-bs-target="#bid_submit" class="btn btn-secondary col-8 mx-auto shadow-lg" style="margin-top:50px;border-radius: 12px;">Submit bid</button>
      </div>
    </div>
  </div>
</div>


<!-- Modal -->
<div class="modal fade" id="bid_submit" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="bid_submitLabel">Bid submission</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
          <form id="submit_bid_form" name="submit_bid_form" action="bid_item_page.php" method="POST">

            <label for="asking_price" class="form-label"> Asking price: </label>
            <input name="asking_price" min="1" type="number" class="form-control" id="asking_price">
            <label for="notes" class="form-label" > Notes to project owner </label>
            <textarea name="notes" class="form-control" id="notes" rows="3" maxlength="300" ></textarea>
            <input type="hidden" id="itemID" name="itemID" >
            <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button id="submit_button" type="button submit" class="btn btn-primary">Submit</button>
            </div>

          </form>      
      </div>
    </div>
  </div>
</div>


<script>
appendInfo();
</script>





</body>
<footer></footer>

</html>