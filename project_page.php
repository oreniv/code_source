<?php 
include_once 'dbconnection.php';
include_once 'user_params.php';

session_start();
echo "Current userID: ",$_SESSION['userID']," ||","  " , $_SESSION['full_name']; 
 
 
?>

<!DOCTYPE html>
<html>

<?php 


// adding bids to cart 

if (isset($_POST['add_this_to_cart']))
 {
  $sqlInsertToCart = "CALL insert_into_cart(".$_SESSION['userID'].",".$_POST['add_this_to_cart'].",'bid')";
  mysqli_query($conn, $sqlInsertToCart);
  checkCart();
  mysqli_close($conn);
  $conn = mysqli_connect($servername, $username, $password, $dbname);
  die();
 }

$sqlProjectInfo = " SELECT project.*,users.id,users.full_name FROM project 
                    INNER JOIN users ON users.id = project.posterID 
                    WHERE project.id =".$_GET['projectID'] ; 
$sqlResult = mysqli_query($conn, $sqlProjectInfo);
$row = mysqli_fetch_assoc($sqlResult); 
 
$postData = array(
                    "project_name" => $row['project_name'],
                    "project_description" => $row['project_description'],
                    "poster_name" => $row['full_name'],
                    "poster_ID" => $row['posterID']
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

  
  $sqlProjectBids = " SELECT project_item_bids.id,project_item_bids.project_itemID,project_item_bids.bidderID,project_item_bids.price,project_item_bids.note  FROM project_item_bids   
                      INNER JOIN project_item ON project_item.id = project_item_bids.project_itemID 
                      WHERE project_item.projectID =".$_GET['projectID'];

  $sqlResult = mysqli_query($conn, $sqlProjectBids);
  $bid_array = array();
  while($row = mysqli_fetch_assoc($sqlResult))
  {
    $temp = array(
      "bid_id" => $row['id'],
      "project_itemID" => $row['project_itemID'],
      "bidderID" => $row['bidderID'],
      "price" => $row['price'],
      "note" => $row['note']
    );
    array_push($bid_array,$temp);
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

$bid_array = json_encode($bid_array); // array of bids for all post items of this project
$projectItem_array = json_encode($projectItem_array); // array of all items that make up the whole project
$tag_array = json_encode($tag_array); // array of tags that were given to this project
$postData = json_encode($postData); // basic data about the whole project 
 

?>


<head>

<meta charset="utf-8" />
<link rel="stylesheet" href="styleSheet.css" />
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script> 
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
 <title>Oray</title>
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

var jsonPostData = <?= $postData  ?> ; 
var userID = <?= $_SESSION['userID'] ?> ; 
var projectId = <?= $_GET['projectID'] ?> ; 


function appendProjectInfo()
{


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


 
var projectItemsSize = projectItems.length;
for (i = 0 ; i < projectItemsSize ; i++)
{
  var projectItemCard = document.createElement("div");
      projectItemCard.setAttribute("class","card text-center");
      projectItemCard.setAttribute("style","width:19rem;height: auto;");
  var itemImage = document.createElement("img");
      itemImage.setAttribute("src",projectItems[i]["part_picture"]);
      itemImage.setAttribute("class","card-img-top");
      itemImage.setAttribute("width","200");
      itemImage.setAttribute("height","auto");
      itemImage.setAttribute("style","margin-top:3px;border-style: solid; border-width:1px;");
  var cardBody = document.createElement("div");
      cardBody.setAttribute("class","card-body");
  var cardText = document.createElement("p");
      cardText.setAttribute("class","card-text text-truncate");
  var viewMoreButton = document.createElement("button");
      viewMoreButton.setAttribute("class","btn btn-secondary");
      viewMoreButton.setAttribute("type","button");
      viewMoreButton.setAttribute("style","margin-bottom:9px;border-style: solid; border-width:3px;border-radius: 12px");
  var bidArea = document.createElement("div");
      bidArea.setAttribute("id","bid_section"+[i]);

  viewMoreButton.innerHTML = "More details";
  cardText.innerHTML = projectItems[i]["item_description"];

  if(projectItems[i]["part_picture"] == null)
    itemImage.setAttribute("src","source/no_picture.jpg"); // Hardcoded image 
  
  projectItemCard.appendChild(itemImage);
  projectItemCard.appendChild(cardBody);
  cardBody.appendChild(cardText);
  projectItemCard.appendChild(bidArea);
  projectItemCard.appendChild(viewMoreButton);

  appendBidInfo(projectItems[i]["itemID"],bidArea); // adds a 'onclick' event to each bid button

  document.getElementById("project_item_info_section").appendChild(projectItemCard);


  $(viewMoreButton).wrap("<a href=bid_item_page.php?itemID="+ projectItems[i]["itemID"]   +"></a>");
  $(itemImage).wrap("<a href=bid_item_page.php?itemID="+ projectItems[i]["itemID"]   +"></a>");




}
 
}


function appendBidInfo(itemID,bidArea)
{
    var bids = <?= $bid_array ?> ; 

    var len = bids.length;
    var has_at_least_one_bid = false; 
 

   var bidList = document.createElement("ul");
   bidList.classList.add("list-group")
 

  for (bidCounter = 1,j = 0 ; j < len ; j++) // go through all the bids for a particular item
  {
    if (bids[j]["project_itemID"] == itemID ) // if the current itemID has a bid, post it.
      {    
        has_at_least_one_bid = true;
        var bidLine = document.createElement("li");
        bidLine.classList.add("list-group-item");
        bidLine.classList.add("shadow-lg");
        bidLine.innerHTML ="Bid # "+bidCounter+": $"+bids[j]["price"]+" | Note from bidder: "+bids[j]["note"];
        bidLine.setAttribute("style","margin:2px;border-style: solid; border-width:2px;");
        bidList.appendChild(bidLine);
        bidCounter++;
      }
     
    if (userID == jsonPostData["poster_ID"] && bidCounter > 1) // if the current user posted the project give an option to accept bids
      {
        var accept_bid_button = document.createElement("button");
        accept_bid_button.setAttribute("type","button");
        accept_bid_button.setAttribute("class","btn btn-warning btn-sm ");
        accept_bid_button.setAttribute("style","margin-bottom:9px;border-style: solid; border-width:3px;border-radius: 12px");
        accept_bid_button.innerHTML = "Accept bid";
        bidList.appendChild(accept_bid_button); 
        setAddToCartForm(accept_bid_button,bids[j]["bid_id"]);
    }
  }

  if (!has_at_least_one_bid)
  {
    var bidLine = document.createElement("li");
        bidLine.classList.add("list-group-item");
        bidLine.classList.add("shadow-lg");
        bidLine.innerHTML ="No bids for this part."
        bidLine.setAttribute("style","margin:2px;border-style: solid; border-width:2px;");
        bidList.appendChild(bidLine);
  }
  bidArea.appendChild(bidList);
   
 
}

function setAddToCartForm(button,bidID)
{ 
           button.onclick = function () {
           var str = "add_this_to_cart="+bidID // use jQuery to turn the form into a big array
           var xhttp = new XMLHttpRequest(); // using AJAX 
           xhttp.open("POST","project_page.php",true); // call this page again with a POST variable that indicates which item to add to cart
           xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded"); 
           xhttp.send(str); // POST  
           location.reload();
        };

}

function showEdit(){
  for(var i =0; i<document.getElementsByClassName("itemManagement").length; i++)
  {document.getElementsByClassName("itemManagement")[i].style.display = "block";}
}
function hide(){
  for(var i =0; i<document.getElementsByClassName("itemManagement").length; i++)
  {document.getElementsByClassName("itemManagement")[i].style.display = "none";}
}

</script>

<body>

<header class="header_class">
  <!-- Header is loaded with jQuery -->
</header>



<div class="container">
    <div class="row">
        <div class="d-grid gap-2">
                <div id="project_name" class="p-2 bg-light border fw-bold text-center ">Project title</div>
                <div id="author" class="p-2 bg-light border fw-bold text-center">Author</div>
                <div id="description" class="p-2 bg-light border text-center">Description</div>
                <div id="tags" class="p-2 bg-light border text-center"> Tags </div>
                <div >   </div>
        </div>
    </div>
</div>

<div class="container px-4 ">
  <div class="row gx-5 " id="project_item_info_section">

<!-- hidden form for adding to cart -->
<form id="add_to_cart" hidden method="POST" action="project_page.php" >
<input type="hidden" id="add_this_to_cart" name="add_this_to_cart" >
</form>


  </div>
</div>





<button class="itemManagement withdraw_button" onclick="window.location.href='add_item_to_project_sql.php?projectId='+projectId;">Add item</button>
<script>
// appending all the data
appendProjectInfo();
</script>

<footer>
      <!-- jQuery pulls this -->
</footer>

<script>
if(jsonPostData["poster_ID"] == userID){
    showEdit();
  } else hide();
</script>

</body>


</html>