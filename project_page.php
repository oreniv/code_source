<?php 
include_once 'dbconnection.php';

session_start();
echo "Current userID: ",$_SESSION['userID']," ||","  " , $_SESSION['full_name']; 
 
?>

<!DOCTYPE html>
<html>

<?php 

$sqlProjectInfo = " SELECT project.*,users.id,users.full_name FROM project 
                    INNER JOIN users ON users.id = project.posterID 
                    WHERE project.id =".$_GET['projectID'] ; 
$sqlResult = mysqli_query($conn, $sqlProjectInfo);
$row = mysqli_fetch_assoc($sqlResult); 
 
$postData = array(
                    "project_name" => $row['project_name'],
                    "project_description" => $row['project_description'],
                    "poster_name" => $row['full_name'],
);

$sqlProjectItems = "SELECT * FROM project_item WHERE projectID =".$_GET['projectID'];
$sqlResult = mysqli_query($conn, $sqlProjectItems);

$projectItem_array = array();

  while($row = mysqli_fetch_assoc($sqlResult))
    {
    $temp = array(
        "itemID" => $row['id'],
        "part_picture" => $row['part_pic'],
        "item_description" => $row['item_description'],
        "item_type" => $row['item_type']
        );
        array_push($projectItem_array,$temp);
        unset($temp);
    }
   
  
   


$sqlFetchTags = "CALL get_tags_for_post(".$_GET['projectID'].",'project')";

$tags = mysqli_query($conn, $sqlFetchTags);  
mysqli_close($conn);

$tag_array = array();
            while($row = mysqli_fetch_assoc($tags))
            {
               array_push($tag_array,$row['tag']);  
            }
 
$projectItem_array = json_encode($projectItem_array);
$tag_array = json_encode($tag_array);
$postData = json_encode($postData);
?>


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
<!-- -------------------------------------------- -->
<script>
function appendProjectInfo()
{

var jsonPostData = <?= $postData  ?> ; 
var jsonTags = <?= $tag_array  ?> ; 

document.getElementById("project_name").innerHTML ="Project: " + jsonPostData["project_name"];
document.getElementById("author").innerHTML ="By user: " + jsonPostData["poster_name"];
document.getElementById("description").innerHTML = jsonPostData["project_description"];

if (jsonTags.length == 0 )
    document.getElementById("tags").innerHTML = "This post has no tags";
    else
    document.getElementById("tags").innerHTML = profileData["tags"]+",";

createNewProjectItemCard ();
}

function createNewProjectItemCard ()
{


var projectItems = <?=  $projectItem_array   ?>;
console.log(projectItems);

//window.alert( projectItems[0]["item_type"]  );
var projectItemsSize = projectItems.length;
for (i = 0 ; i < projectItemsSize ; i++)
{
  var projectItemCard = document.createElement("div")
    projectItemCard.classList.add("card");
    projectItemCard.style.width = '95%';
  var cardRow = document.createElement("div")
    cardRow.classList.add("row");
    cardRow.classList.add("g-0");
  var imageDiv = document.createElement("div")
    imageDiv.classList.add("col-md-4");
    imageDiv.classList.add("border");
  var image = document.createElement("img");
    image.setAttribute("src",projectItems[i]["part_picture"]);
    image.setAttribute("style","width: 50%; height:auto;")
  var cardTextColumn =  document.createElement("div");
    cardTextColumn.classList.add("col-md-8");
  var cardTextBody = document.createElement("div");
    cardTextBody.classList.add("card-body");
  var cardText = document.createElement("p");
    cardText.classList.add("card-text");
    cardText.classList.add("border");
    cardText.classList.add("text-center");
    cardText.innerHTML = projectItems[i]["item_description"];
  
     if(projectItems[i]["part_picture"] == null)
      image.setAttribute("src","source/no_picture.jpg"); // Hardcoded image 




  projectItemCard.appendChild(cardRow);
  cardRow.appendChild(imageDiv);
  imageDiv.appendChild(image);
  cardRow.appendChild(cardTextColumn);
  cardTextColumn.appendChild(cardTextBody); 
  cardTextBody.appendChild(cardText);

  document.getElementById("project_item_info_section").appendChild(projectItemCard);
}
}

</script>



<header class="header_class">
  <!-- Header is loaded with jQuery -->
</header>


<body>

<div class="container">
    <div class="row">
        <div class="d-grid gap-2">
                <div id="project_name" class="p-2 bg-light border fw-bold text-center ">Project title</div>
                <div id="author" class="p-2 bg-light border fw-bold text-center">Author</div>
                <div id="description" class="p-2 bg-light border text-center">Description</div>
                <div id="tags" class="p-2 bg-light border text-center"> Tags </div>
        </div>
        
    </div>
</div>

<div class="container gap-2" id="project_item_info_section">







</div>






<script>
// appending all the data
appendProjectInfo();
</script>


</body>



<footer>
      <!-- jQuery pulls this -->
</footer>

</html>