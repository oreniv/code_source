<?php 
include_once 'dbconnection.php';
include_once 'user_params.php';

session_start();
echo "Current userID: ",$_SESSION['userID']," ||","  " , $_SESSION['full_name']; 
 
if(isset($_GET['projectId']))
{$myProjectId = $_GET['projectId'];
echo $myProjectId;}
 
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

<body>

<header class="header_class">
  <!-- Header is loaded with jQuery -->
</header>


<iframe name="dummyframe" id="dummyframe" style="display: none;"></iframe>

<div class="container_forms" id="mContainer_forms">
</div>
<button class="withdraw_button add_item_button" onclick="createForm()">Add an item</button>









<footer>
      <!-- jQuery pulls this -->
</footer>

<script>
var br = document.createElement("br"); 
var number =-1;
var projectId = <?php echo json_encode($myProjectId, JSON_HEX_TAG); ?>; 
var tenId = projectId.toString();

function createForm(){
    number++;
    mClassName = "a"+number;
    var form = document.createElement("form");
    form.setAttribute("method", "post");
    form.setAttribute("action", "items_added_to_sql.php");
    form.setAttribute("enctype", "multipart/form-data");
    form.setAttribute("target", "dummyframe");
    form.classList.add(mClassName);
  
    var title = document.createElement("input");
    title.setAttribute("type", "text");
    title.setAttribute("name", "title");
    title.setAttribute("placeholder", "Title");
    title.classList.add(mClassName);
    title.setAttribute("style","margin-bottom:5px;");
    var project = document.createElement("input");
    project.setAttribute("type", "hidden");
    project.setAttribute("name", "projectId");
    project.setAttribute("value", projectId);
    project.classList.add(mClassName);
    project.setAttribute("style","margin-bottom:5px;");
    var description = document.createElement("textarea");
    description.setAttribute("rows", "10");
    description.setAttribute("cols", "30");
    description.setAttribute("name", "description");
    description.setAttribute("placeholder", "Description");
    description.classList.add(mClassName);
    description.setAttribute("style","margin-bottom:5px;");
   
    var picture = document.createElement("input");
    picture.setAttribute("type", "file");
    picture.setAttribute("name", "filename");
    picture.setAttribute("placeholder", "pictures");
    picture.classList.add(mClassName);
    picture.classList.add("file_form");
    picture.id = "filename";
    picture.setAttribute("style","margin-bottom:5px;");
 
    var select = document.createElement("select");
    select.setAttribute("name", "mSelect");
    select.classList.add(mClassName);

    var option1 = document.createElement("option");
    option1.innerHTML = "3D schema";
    option1.setAttribute("value", 1);

    var option2 = document.createElement("option");
    option2.innerHTML = "2D-Sketch";
    option2.setAttribute("value", 2);

    var option3 = document.createElement("option");
    option3.innerHTML = "Physical-item";
    option3.setAttribute("value", 3);
   
    var s = document.createElement("button");
    s.setAttribute("type", "submit");
    s.innerHTML = "Submit"
    s.classList.add("button_submit");
    s.classList.add("withdraw_button");
    s.classList.add("my_item_form");
    s.setAttribute("style","margin-bottom:5px;");
    s.id = (mClassName);

    form.appendChild(title); 
    form.appendChild(br.cloneNode()); 
    form.appendChild(description); 
    form.appendChild(br.cloneNode());
    form.appendChild(project);
    form.appendChild(picture); 
    form.appendChild(br.cloneNode()); 
    form.appendChild(select); 
    select.appendChild(option1); 
    select.appendChild(option2); 
    select.appendChild(option3); 
    form.appendChild(br.cloneNode());
    form.appendChild(s); 
    form.appendChild(br.cloneNode());
    
    document.getElementById("mContainer_forms").appendChild(form);
    s.addEventListener('click', function() {hideForm(s);});
    
}

function hideForm(element){
    var formList = document.getElementsByClassName(element.id);
    for(var i =0; i<formList.length; i++){
        formList[i].style.display = "none";
    }

}


</script>

</body>




</html>