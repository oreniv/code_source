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


    <script>
        function appendMyJson(data, dataFavorite){
            for(var i = 0; i< data.length; i++){
                var isFavorite = false;
                        for(var j = 0; j<dataFavorite.length; j++){
                            if (dataFavorite[j].sales_itemID == data[i].product_id)
                            {isFavorite = true;}
                        }
                createMyCard("containerExternalProfileSideRight", data[i].item_pic_link, data[i].product_description, 
                    data[i].product_price, isFavorite, data[i].product_name, data[i].product_id, "a");
                            }
        }

        function createProfile(data){
                createProfileTable(data["profile_pic_link"], data["name"], data["mail"], data["seller_rating"]);
        }

        function createProfileTable(picture, name, mail, rating){
            if(picture == "")
            {document.getElementById("picProfileImg").setAttribute("src", "source/icones/profileIcon.png");}
            else 
            {document.getElementById("picProfileImg").setAttribute("src", picture);}

            document.getElementById("fullName").innerHTML = name;
            document.getElementById("fullMail").innerHTML = mail;
            document.getElementById("profileRating").innerHTML = rating +"/5";
        }

        function createMyCard(tabName, image, description, price, liked, productName, id, doubleTag){
            const newCard = document.createElement("div");
            newCard.classList.add("card");
            const newPicture = document.createElement("img");
            newPicture.classList.add("img_card");
            var firstImage = image.split(",");
            newPicture.src = firstImage[0];
            const newNameProduct = document.createElement("h3");
            newNameProduct.innerHTML = productName;
            const newDescription = document.createElement("p");
            newDescription.classList.add("card_product_description");
            newDescription.innerHTML = description;
            const newContainerBottomCard = document.createElement("div");
            newContainerBottomCard.classList.add("container");
            newContainerBottomCard.classList.add("card_bottom");
            const newPrice = document.createElement("p");
            newPrice.classList.add("price");
            newPrice.innerHTML = "$" + price;
            const newLikeParagraph = document.createElement("p");
            const newLikeButton = document.createElement("button");
            newLikeButton.classList.add("heart_button")
            const newLikeIcone = document.createElement("img");
            newLikeIcone.classList.add("icon_heart");
            newLikeIcone.id = doubleTag + id;
            if (liked == true) {
                newLikeIcone.src = "source/icones/groupe_22_filled.png";
            } else if (liked == false){
                newLikeIcone.src = "source/icones/groupe_22.png";
            }

            newCard.appendChild(newPicture);
            newCard.appendChild(newNameProduct);
            newCard.appendChild(newDescription);
            newCard.appendChild(newContainerBottomCard);
            newContainerBottomCard.appendChild(newPrice);
            newContainerBottomCard.appendChild(newLikeParagraph);
            newLikeParagraph.appendChild(newLikeButton);
            newLikeButton.appendChild(newLikeIcone);

            document.getElementById(tabName).appendChild(newCard);

            $(newPicture).wrap("<a href=product_page.php?productID="+id+"></a>");
        }


        function changeFavorite(element, myHeartsLastList, myId, cleanId, type){
            
            
            console.log(element.childNodes[0].id);
            console.log(document.getElementById(myId).src);
            
            var notExist = true;

            if(document.getElementById(myId).src.includes("source/icones/groupe_22_filled.png")){
                document.getElementById(myId).src = "source/icones/groupe_22.png";  
            }
            else
            {
                document.getElementById(myId).src = "source/icones/groupe_22_filled.png";
            }

            obj = {
                "id" : myId,
                "src" : document.getElementById(myId).src,
                "type" : type
            };

            for(var i =0; i<myHeartsLastList.length; i++){
                if(myHeartsLastList[i].id == myId){
                    ajaxCall(cleanId, true, type);
                    myHeartsLastList.splice(i, 1);
                    notExist = false;
                }
            }
            if(notExist){
                myHeartsLastList.push(obj);
                ajaxCall(cleanId, false, type);
            }
           

        }

        function ajaxCall(id, action, type) {
            type = false;

            $.ajax({
            type: 'POST',
            url: 'favoriteC_changes_to_sql.php',
            dataType: 'json',
            data: {
                id: id,
                action: action,
                type: type
                },
            success: function(response) {
                alert(response);
            }
            });
        }
    </script>

</head>

<body>

<!--  jQuery loading header and footer -->
<script>
 
 $(document).ready(function(){
   $(".header_class").load("header.php");
   $("footer").load("footer.html");
 });
 
</script>
<!-- -------------------------------------------- -->


<header class="header_class">
  <!-- Header is loaded with jQuery -->
</header>

<div class="containerExternalProfile">

    <div class="containerExternalProfileSideLeft">
    <img id="picProfileImg" src="" >
    <p id="fullName"></p>
    <p id="fullMail"></p>
    <p id="profileRating"></p>
    </div>
    <div id="containerExternalProfileSideRight">

    </div>

</div>



<?php
        if(isset($_GET['userId']))
            $_SESSION['userId'] = $_GET['userId']; 

        $sqlExternProfile = "SELECT full_name, email, profile_pic_link, seller_rating FROM users WHERE id =" .$_SESSION['userId'].";";
        $sqlExternProduct = "SELECT * FROM sales_item WHERE sales_item_posterID = " .$_SESSION['userId'].";";
        $sqlFavorite = "SELECT * FROM fav_posts WHERE userID = " .$_SESSION['userID']. ";";
        
        $conn = mysqli_connect($servername, $username, $password, $dbname);    //start

        $resultExternProfile = mysqli_query($conn, $sqlExternProfile);
        $resultCheckExternProfile = mysqli_num_rows($resultExternProfile);

        mysqli_close($conn); // close connection
        $conn = mysqli_connect($servername, $username, $password, $dbname); 

        $resultExternProduct = mysqli_query($conn, $sqlExternProduct);
        $resultCheckExternProduct = mysqli_num_rows($resultExternProduct);

        mysqli_close($conn); // close connection

        $conn = mysqli_connect($servername, $username, $password, $dbname); 
        $resultFavorite = mysqli_query($conn, $sqlFavorite);
        $resultCheckFavorite = mysqli_num_rows($resultFavorite);

        mysqli_close($conn); // close connection


        if($resultCheckExternProduct > 0){
            $mainDataMyProduct  = array();
            while($row = mysqli_fetch_assoc($resultExternProduct)){
                $dataMyProduct  = array(
                    "product_name" => $row['item_name'],
                    "product_id" => $row['id'],
                    "product_price" => $row['price'],
                    "product_description" => $row['item_description'],
                    "item_pic_link" => $row['item_pic_link']
                );   
                array_push($mainDataMyProduct , $dataMyProduct);
                unset($dataMyProduct );                
            }
            $jsonMyProduct  = json_encode($mainDataMyProduct); 
        }

        if($resultCheckFavorite > 0){
            $mainDataFavorite = array();
            while($row = mysqli_fetch_assoc($resultFavorite)){
                $dataFavorite = array(
                    "sales_itemID" => $row['sales_itemID']
                );   
                array_push($mainDataFavorite, $dataFavorite);
                unset($dataFavorite);                
            }
            $jsonFavorite = json_encode($mainDataFavorite); 
        } else $jsonFavorite = 0;

        if($resultCheckExternProfile > 0)
            {
                $row = mysqli_fetch_assoc($resultExternProfile);
                    $dataProfile = array(
                        "name" => $row['full_name'],
                        "mail" => $row['email'],
                        "seller_rating" => $row['seller_rating'],
                        "profile_pic_link" => $row['profile_pic_link']
                    );   
            }
    ?>

    <script>
        jsonJsProfile = {
                        "name" : <?php echo json_encode($dataProfile["name"], JSON_HEX_TAG); ?>,
                        "mail" :  <?php echo json_encode($dataProfile["mail"], JSON_HEX_TAG); ?>,
                        "seller_rating" :  <?php echo json_encode($dataProfile["seller_rating"], JSON_HEX_TAG); ?>,
                        "profile_pic_link" :  <?php echo json_encode($dataProfile["profile_pic_link"], JSON_HEX_TAG); ?>
                    };  

        var jsonJsProducts = <?= $jsonMyProduct; ?>;
        var jsonJsFavorite = <?= $jsonFavorite; ?>;
        console.log(jsonJsFavorite);
        console.log(jsonJsProducts);
        console.log(jsonJsProfile);
        appendMyJson(jsonJsProducts, jsonJsFavorite); 
        createProfile(jsonJsProfile);

        const myHearts = document.querySelectorAll(".heart_button");
            var myHeartsInitList = [];
            var myHeartsLastList = [];
            
            myHearts.forEach((e) => {
                var myId = e.childNodes[0].id;
                var mySrc = document.getElementById(myId).src;

                var type = "'sales_itemID'";
                var realId = myId.replace("a", "");


                var check =false;

                myObj = {
                    "id":myId,
                    "src":mySrc,
                    "type":type
                };
                myHeartsInitList.push(myObj);

                if(mySrc.includes("source/icones/groupe_22_filled.png"))
                {myHeartsLastList.push(myObj);}


                e.addEventListener('click', function() {changeFavorite(e, myHeartsLastList, myId, realId, type, check);});
                
            })

    </script>
    <footer>
      <!-- jQuery pulls this -->
    </footer>
</body>

</html>