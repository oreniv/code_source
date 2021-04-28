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
        function appendMyJson(data){
                    for(var i = 0; i< data.length; i++){
                        createMyCard("containerExternalProfileSideRight", data[i].item_pic_link, data[i].product_description, 
                        data[i].product_price, true, data[i].product_name, 
                        data[i].product_id);
                            }
        }

        function createProfile(data){
            for(var i = 0; i < data.length; i++){
                createProfileTable(data[i].profile_pic_link, data[i].name, data[i].mail, data[i].seller_rating)
            }
        }

        function createProfileTable(picture, name, mail, rating){
            if(picture == "")
            document.getElementById("picProfileImg").src = "source/icones/profileIcon.png";
            else 
            document.getElementById("picProfileImg").src = picture;
            document.getElementById("fullName").innerHTML = name;
            document.getElementById("fullMail").innerHTML = mail;
            document.getElementById("profileRating").innerHTML = rating +"/5";
        }

        function createMyCard(tabName, image, description, price, liked, productName, id){
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
            if (liked == true) {
                newLikeIcone.src = "source/icones/groupe_22_filled.png"
            } else {
                newLikeIcone.src = "source/icones/groupe_22.png"
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
            newLikeIcone.onclick = function(){
                if(newLikeIcone.src == "source/icones/groupe_22_filled.png"){
                    newLikeIcone.src ="source/icones/groupe_22.png";
                } else {
                    newLikeIcone.src = "source/icones/groupe_22_filled.png";
                }
            }
        }
    </script>

</head>

<body>
<header class="header_class">
  <!-- Header is loaded with jQuery -->
</header>

<div class="containerExternalProfile">

    <div class="containerExternalProfileSideLeft">
    <table>
        <tr>
            <td id="picProfile">
                <img id = "picProfileImg" >
            </td>
        </tr>
        <tr>
            <td id="fullName">
                
            </td>
        </tr>
        <tr>
            <td id="fullMail">
                
            </td>
        </tr>
        <tr>
            <td id="profileRating">
                
            </td>
        </tr>

    </table>

    </div>
    <div class="containerExternalProfileSideRight">

    </div>

</div>









<?php
        $userId = . $_GET['userID'];

        $sqlExternProfile = "select full_name, email, profile_pic_link, seller_rating from users where id =" $userId;
        $sqlExternProduct = "select * from sales_item where sales_item_posterID = " $userId;

        $resultExternProfile = mysqli_query($conn, $sqlExternProfile);
        $resultCheckExternProfile = mysqli_num_rows($resultExternProfile);

        $resultExternProduct = mysqli_query($conn, $sqlExternProduct);
        $resultCheckExternProduct = mysqli_num_rows($resultCheckExternProfile);

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
                array_push($mainDataMyProduct , $dataMyProduct );
                unset($dataMyProduct );                
            }
            $jsonMyProduct  = json_encode($mainDataMyProduct ); 
        }

        if($resultCheckExternProfile > 0)
            {
                $row = mysqli_fetch_assoc($resultCheckExternProfile);
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
        console.log(jsonJsProducts);
        appendMyJson(jsonJsProducts); 
        createProfile(jsonJsProfile);

    </script>
    <footer>
      <!-- jQuery pulls this -->
</footer>
</body>

</html>