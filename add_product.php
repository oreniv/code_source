<?php 
include_once 'dbconnection.php';
include_once 'user_params.php';
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
    <!-- Jquery import -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script> 
</head>

<body>
<script>
$(document).ready(function(){
   $(".header_class").load("header.php");
   $("footer").load("footer.html");
 });
</script>
<header class="header_class"> 
     <!-- Header is loaded with jQuery -->
</header>

<div class="head_button">
                <button id="defaultOpen" class="tablink" onclick="openTab('principal_profile', this, 'tabcontent')">Your profile</button>
                <button id="buyer_profile_link" class="tablink" onclick="openTab('buyer_profile', this, 'tabcontent')">Your buyer profile</button>
                <button id="seller_profile_link" class="tablink" onclick="openTab('seller_profile', this, 'tabcontent')">Your seller profile</button>
        </div>  



<div class="dropSide">
    
        <div class="dropZone" id="dropZonePicture">
        <p>drop files' picture here to upload <br/> <img class="logoDropZone" src="source/icones/piclogo.png"></p>
    </div>
    <div id="uploadsPicture"></div>

    <div class="dropZone" id="dropZoneFileType">
        <p>drop 3D files here to upload <br/>  <img class="logoDropZone" src="source/icones/filelogo.png"></p>
    </div>
    <div id="uploadsFilesType"></div>

</div>








<script>
    (function(){
        var dropZonePicture = document.getElementById('dropZonePicture');
        var dropZoneFileType = document.getElementById('dropZoneFileType');

        var upload = function(files, dropZoneName){
            
            var displayUploads = function(data){
                var uploads = document.getElementById(dropZoneName),
                list,
                x;
                list = document.createElement('ul');
                for(x=0; x<data.length; x++){
                    item = document.createElement('li')
                    item.innerText = data[x].name;
                    list.appendChild(item);
                }
                uploads.appendChild(list);
            }
            
            var formData = new FormData (),
                xhr = new XMLHttpRequest(),
                x;
            for(x=0; x<files.length; x = x+1){
                formData.append('file[]', files[x]);
            }
            xhr.onload = function(){
                var data = JSON.parse(this.responseText);

                displayUploads(data);
            }
            xhr.open('post', 'upload.php');
            xhr.send(formData);

        }

        dropZonePicture.ondrop = function (e){
            e.preventDefault();
            this.className = 'dropZone';
            console.log(e.dataTransfer.files);
            var allName = null;

            for(var x=0; x<e.dataTransfer.files.length; x++){
                if(allName == null)
                    allName = e.dataTransfer.files[x].name + "\n";
                else
                    allName = allName + e.dataTransfer.files[x].name  + "\n";
                }

                if(confirm("you are about to upload: \n" + allName + "\n" +"Do you confirm the upload ?"))
                    upload(e.dataTransfer.files, 'uploadsPicture'); 

        };

        dropZonePicture.ondragover = function (){
            this.className = 'dropZone dragover';
            return false;
        };

        dropZonePicture.ondragleave = function (){
            this.className = 'dropZone';
            return false;
        };

        dropZoneFileType.ondrop = function (e){
            e.preventDefault();
            this.className = 'dropZone';
            console.log(e.dataTransfer.files);
            var allName = null;

            for(var x=0; x<e.dataTransfer.files.length; x++){
                if(allName == null)
                    allName = e.dataTransfer.files[x].name + "\n";
                else
                    allName = allName + e.dataTransfer.files[x].name  + "\n";
                }

                if(confirm("you are about to upload: \n" + allName + "\n" +"Do you confirm the upload ?"))
                    upload(e.dataTransfer.files, 'uploadsFilesType'); 
        };

        dropZoneFileType.ondragover = function (){
            this.className = 'dropZone dragover';
            return false;
        };

        dropZoneFileType.ondragleave = function (){
            this.className = 'dropZone';
            return false;
        };

        
    }());


</script>


<footer> 
        <!-- jQuery pulls this -->
    </footer>
</body>

</html>
    