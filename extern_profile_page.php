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
                    data[i].product_price, true, data[i].product_name, data[i].product_id);
                            }
        }

        function createProfile(data){
            for(var i = 0; i < data.length; i++){
                createProfileTable(data[i].profile_pic_link, data[i].name, data[i].mail, data[i].seller_rating);
            }
        }

        function createProfileTable(picture, name, mail, rating){
            if(picture == "")
            {document.getElementById("picProfileImg").setAttribute("src", "source/icones/profileIcon.png");}
            else 
            {document.getElementById("picProfileImg").setAttribute("src", picture);}

            document.getElementById("myTable").rows[1].cells.item(0).innerHTML = name;
            document.getElementById("myTable").rows[2].cells.item(0).innerHTML = mail;
            document.getElementById("myTable").rows[3].cells.item(0).innerHTML = rating +"/5";
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
                newLikeIcone.src = "source/icones/groupe_22_filled.png";
            } else {
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
        <table id="myTable">
            <tr>
                <td id="picProfile">
                    <img id="picProfileImg" src="" >
                    fuck you
                </td>
            </tr>
            <tr>
                <td id="fullName">
                    fuck you
                </td>
            </tr>
            <tr>
                <td id="fullMail">
                    fuck you
                </td>
            </tr>
            <tr>
                <td id="profileRating">
                    fuck you
                </td>
            </tr>
        </table>
    </div>
    <div id="containerExternalProfileSideRight">

    </div>

</div>



<?php
        if(isset($_GET['userId']))
            $_SESSION['userId'] = $_GET['userId']; 

        $sqlExternProfile = "select full_name, email, profile_pic_link, seller_rating from users where id =" .$_SESSION['userId'].";";
        $sqlExternProduct = "select * from sales_item where sales_item_posterID = " .$_SESSION['userId'].";";
        
        $conn = mysqli_connect($servername, $username, $password, $dbname);    //start

        $resultExternProfile = mysqli_query($conn, $sqlExternProfile);
        $resultCheckExternProfile = mysqli_num_rows($resultExternProfile);

        mysqli_close($conn); // close connection
        $conn = mysqli_connect($servername, $username, $password, $dbname); 

        $resultExternProduct = mysqli_query($conn, $sqlExternProduct);
        $resultCheckExternProduct = mysqli_num_rows($resultExternProduct);

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
        console.log(jsonJsProducts);
        console.log(jsonJsProfile);
        appendMyJson(jsonJsProducts); 
        createProfile(jsonJsProfile);

    </script>
    <footer>
      <!-- jQuery pulls this -->
    </footer>
</body>

</html>