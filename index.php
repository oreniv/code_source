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
    
    <script>
        var slideIndex = 1;
        showSlides(slideIndex);

        // Next/previous controls
        function plusSlides(n) {
            showSlides(slideIndex += n);
        }

        // Thumbnail image controls
        function currentSlide(n) {
            showSlides(slideIndex = n);
        }

        function showSlides(n) {
            var i;
            var slides = document.getElementsByClassName("mySlides");
            var dots = document.getElementsByClassName("dot");
            if (n > slides.length) { slideIndex = 1 }
            if (n < 1) { slideIndex = slides.length }
            for (i = 0; i < slides.length; i++) {
                slides[i].style.display = "none";
            }
            for (i = 0; i < dots.length; i++) {
                dots[i].className = dots[i].className.replace(" active", "");
            }
            slides[slideIndex - 1].style.display = "block";
            dots[slideIndex - 1].className += " active";
        }



        function myTimer() {
            document.getElementById("next_slide_auto").click();
        }

        /**-------------------------------------------------------------------------------------------------*/

        var actualTabName;


        function openTab(tabName, elmnt) {

            actualTabName = tabName;
            // Hide all elements with class="tabcontent" by default */
            var i, tabcontent, tablinks;
            tabcontent = document.getElementsByClassName("tabcontent");
            for (i = 0; i < tabcontent.length; i++) {
                tabcontent[i].style.display = "none";
            }

            // Remove the background color of all tablinks/buttons
            tablinks = document.getElementsByClassName("tablink");
            for (i = 0; i < tablinks.length; i++) {
                tablinks[i].style.color = "";
            }

            // Show the specific tab content
            document.getElementById(tabName).style.display = "flex";
            elmnt.style.color = '#E68235';

        }

        // Get the element with id="defaultOpen" and click on it
        document.getElementById("defaultOpen").click();

        /**----------------------------------------------------------------------------------*/
        

        function appendAllMyJson(dataProduct, dataProject, dataTopTenProject, dataTopTenProduct, dataTopTenSeller, dataSellers){
                    for(var i = 0; i< dataProject.length; i++){
                        createNewCardTopTenProduct("project_link_card_happened","source/produits/project4.jpg", dataProject[i].project_description, dataProject[i].project_budget, true, dataProject[i].project_name,dataProject[i].project_id,"project");
                    }
                    for(var i = 0; i< dataProduct.length; i++){
                        createNewCardTopTenProduct("product_link_card_happened","source/produits/onepieceluffy.jpg", dataProduct[i].product_description, dataProduct[i].product_price, true, dataProduct[i].product_name,dataProduct[i].product_id,"product");
                    }
                    for(var i = 0; i< dataTopTenProject.length; i++){
                        createNewCardTopTenProduct("top_ten_project_card_happened","source/produits/project4.jpg", dataTopTenProject[i].project_description, dataTopTenProject[i].project_budget, true, dataTopTenProject[i].project_name,dataTopTenProject[i].project_id,"project");
                    }
                    for(var i = 0; i< dataTopTenProduct.length; i++){
                        createNewCardTopTenProduct("top_ten_card_happened","source/produits/onepieceluffy.jpg", dataTopTenProduct[i].product_description, dataTopTenProduct[i].product_price, true, dataTopTenProduct[i].product_name,dataTopTenProduct[i].product_id,"product");
                    }
                    for(var i = 0; i< dataTopTenSeller.length; i++){
                        createNewCardTopTenProduct("top_ten_sellers_card_happened","source/produits/person3.jfif", dataTopTenSeller[i].address, dataTopTenSeller[i].seller_rating, true, dataTopTenSeller[i].name,dataTopTenSeller[i].id,"user");
                    }

                    for(var i = 0; i< dataSellers.length; i++){
                        createNewCardTopTenProduct("sellers_link_card_happened","source/produits/person3.jfif", dataSellers[i].address, dataSellers[i].seller_rating, true, dataSellers[i].name,dataSellers[i].id,"user");
                    }
        }

        function createNewCardTopTenProduct(tabName, picture, description, price, liked, productName,id,postType) {
            
            const newCard = document.createElement("div");
            newCard.classList.add("card");
            const newPicture = document.createElement("img");
            newPicture.classList.add("img_card");
            newPicture.src = picture;
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
            if(tabName == "sellers_link_card_happened" || tabName == "top_ten_sellers_card_happened" )
            newPrice.innerHTML = "Rating: " + price;
            else
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

            // using jquery to give every picture a link
           // $(newPicture).wrap("<a href=test.html></a>");
          
          //Only product items currently have a working page 
          if (tabName == "top_ten_card_happened" || tabName == "product_link_card_happened") // this means the current item is a product
            $(newPicture).wrap("<a href=product_page.php?productID="+id+"></a>");
            



            document.getElementById(tabName).appendChild(newCard);
        }
         
        function login()
        {
            var userID = window.prompt("Enter userID:","19");    
            var xhttp = new XMLHttpRequest(); // using AJAX 
            xhttp.open("POST","index.php",true);
            xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhttp.send("userID="+userID); 
            location.reload();

        }
        function logout()
        {
            var xhttp = new XMLHttpRequest();  // using AJAX 
            xhttp.open("POST","index.php",true);
            xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhttp.send("kill_session="+true); 
            location.reload();
        }
         
    </script>

</head>

<body>
     <!-- login button stuff -->
    <div class="container">
    <button class="my_button_edit" onclick="login()">log in</button>
    <button class="my_button_edit" onclick="logout()">log out</button>
    </div>
    <!-- ******************* -->
    
    <header class="header_class">

        <div>
            <img class="logo" src="source/icones/logo.png">
        </div>
        
        <div class="header_link">
        
            <a id="current_page" class="header_specific_link" href="index.php">Home</a>
            <a class="header_specific_link" href="getdata.php">Shop</a>
            <a class="header_specific_link" href="#">Forum</a>
            <a class="header_specific_link" href="#">Partner</a>
        </div>

        <div class="profile_container">
            <a href="profile_page.php">
                <div class="mask_circle">
                    <img class="img_profile" src="source/produits/profil_picture.jpg">
                </div>
            </a>
            <div class="cart_container">
                <a class="cart_link" href="#"><span class="number_item">0</span><img class="cart_img"
                        src="source/icones/cart.png"></a>
            </div>
        </div>



    </header>

    <div class="container_advertisement_image">
        <div class="mask_advertisement_image">
            <img class="advertisement_image mySlides my_fade" src="source/produits/printer.jfif">
            <img class="advertisement_image mySlides my_fade" src="source/produits/printer2.jfif">
            <img class="advertisement_image mySlides my_fade" src="source/produits/printer3.png">
            <img class="advertisement_image mySlides my_fade" src="source/produits/printer4.jpg">
            <img class="advertisement_image mySlides my_fade" src="source/produits/printer5.jfif">
            <img class="advertisement_image mySlides my_fade" src="source/produits/printer6.jfif">
            <script>showSlides(1)</script>
        </div>

        <a class="prev" onclick="plusSlides(-1)">&#10094;</a>
        <a id="next_slide_auto" class="next" onclick="plusSlides(1)">&#10095;</a>

        <div class="dot_container">
            <span class="dot" onclick="currentSlide(1)"></span>
            <span class="dot" onclick="currentSlide(2)"></span>
            <span class="dot" onclick="currentSlide(3)"></span>
            <span class="dot" onclick="currentSlide(4)"></span>
            <span class="dot" onclick="currentSlide(5)"></span>
            <span class="dot" onclick="currentSlide(6)"></span>
        </div>
        <script>setInterval(myTimer, 3000);</script>
    </div>

    <div class="search_container">
        <input type="text" placeholder="     Search.." class="search_text">
        <button class="search_button" type="submit"><img class="search_img" src="source/icones/search.png"></button>
    </div>

    <div class="tab_container">

        <div class="head_button">
            <button id="defaultOpen" class="tablink" onclick="openTab('top_ten', this)">Top ten</button>
            <button id="products_link" class="tablink" onclick="openTab('products', this)">Products</button>
            <button id="projects_link" class="tablink" onclick="openTab('projects', this)">Projects</button>
            <button id="sellers_link" class="tablink" onclick="openTab('sellers', this)">Sellers</button>
        </div>

        <div class="tab">

            <div id="top_ten" class="tabcontent">
                <div class="top_ten_container">
                    <h3 class="title_top_ten">Products</h3>
                    <div id="top_ten_card_happened" class="product row">
                    </div>
                </div>
                <div class="top_ten_container">
                    <h3 class="title_top_ten">Projects</h3>
                    <div id="top_ten_project_card_happened" class="project row">
                    </div>
                </div>
                <div class="top_ten_container">
                    <h3 class="title_top_ten">Sellers</h3>
                    <div id="top_ten_sellers_card_happened" class="sellers row">
                    </div>
                </div>

            </div>

            <div id="products" class="tabcontent">
                <div class="title_container">
                    <h3 class="title_top_ten">Products</h3>
                    <div id="product_link_card_happened" class="product row">
                    </div>
                </div>

            </div>

            <div id="projects" class="tabcontent">
                <div class="title_container">
                    <h3 class="title_top_ten">Project</h3>
                    <div id="project_link_card_happened" class="product row">
                        

                    </div>
                </div>

            </div>

            <div id="sellers" class="tabcontent">
                <div class="title_container">
                    <h3 class="title_top_ten">Sellers</h3>
                    <div id="sellers_link_card_happened" class="product row">
                       

                    </div>
                </div>

            </div>
        </div>
    </div>

    <?php
            $sqlProducts ="SELECT * FROM sales_item";
            $sqlProject = "SELECT * FROM project;";
            $sqlTopTenProduct = "CALL get_top10_sales_item_posts();";
            $sqlTopTenProject = "CALL get_top10_projects();";
            $sqlTopTenSeller ="CALL get_top10_sellers();";
            $sqlSeller ="SELECT * FROM users;";


            $resultProject = mysqli_query($conn, $sqlProject);
            $resultCheckProject = mysqli_num_rows($resultProject);

            $resultProduct = mysqli_query($conn, $sqlProducts);
            $resultCheckProduct = mysqli_num_rows($resultProduct);

            $resultTopTenProject = mysqli_query($conn, $sqlTopTenProject);
            $resultCheckTopTenProject = mysqli_num_rows($resultTopTenProject);
            // Must restart connection after a CALL.
            mysqli_close($conn);
            $conn = mysqli_connect($servername, $username, $password, $dbname);
            //****************************/
            $resultTopTenProduct = mysqli_query($conn, $sqlTopTenProduct);
            $resultCheckTopTenProduct = mysqli_num_rows($resultTopTenProduct);

            mysqli_close($conn);
            $conn = mysqli_connect($servername, $username, $password, $dbname);

            $resultSeller = mysqli_query($conn, $sqlSeller);
            $resultCheckSeller = mysqli_num_rows($resultSeller);

            $resultTopTenSeller = mysqli_query($conn, $sqlTopTenSeller);
            $resultCheckTopTenSeller = mysqli_num_rows($resultTopTenSeller);

            
            if($resultCheckProduct > 0){
                $mainDataProduct = array();
                while($row = mysqli_fetch_assoc($resultProduct)){
                    $dataProduct = array(
                        "product_name" => $row['item_name'],
                        "product_id" => $row['id'],
                        "product_price" => $row['price'],
                        "product_description" => $row['item_description']
                    );   
                    array_push($mainDataProduct, $dataProduct);
                    unset($dataProduct);                
                }
                $jsonProduct = json_encode($mainDataProduct); 
            }

            if($resultCheckTopTenProduct > 0){
                $mainDataTopTenProduct  = array();
                while($row = mysqli_fetch_assoc($resultTopTenProduct)){
                    $dataTopTenProduct  = array(
                        "product_name" => $row['item_name'],
                        "product_id" => $row['id'],
                        "product_price" => $row['price'],
                        "product_description" => $row['item_description']
                    );   
                    array_push($mainDataTopTenProduct , $dataTopTenProduct );
                    unset($dataTopTenProduct );                
                }
                $jsonTopTenProduct  = json_encode($mainDataTopTenProduct ); 
            }


            if($resultCheckProject > 0)
            {
                $mainDataProject = array();
                while($row = mysqli_fetch_assoc($resultProject)){
                    $dataProject = array(
                        "project_name" => $row['project_name'],
                        "project_id" => $row['id'],
                        "project_budget" => $row['budget'],
                        "project_description" => $row['project_description']
                    );   
                    array_push($mainDataProject, $dataProject);
                    unset($dataProject);                
                }
                $jsonProject = json_encode($mainDataProject);                
            }

            if($resultCheckTopTenProject > 0)
            {
                $mainDataTopTenProject = array();
                while($row = mysqli_fetch_assoc($resultTopTenProject)){
                    $dataTopTenProject = array(
                        "project_name" => $row['project_name'],
                        "project_id" => $row['id'],
                        "project_budget" => $row['budget'],
                        "project_description" => $row['project_description']
                    );   
                    array_push($mainDataTopTenProject, $dataTopTenProject);
                    unset($dataTopTenProject);                
                }
                $jsonTopTenProject = json_encode($mainDataTopTenProject);                
            }

            if($resultCheckSeller > 0)
            {
                $mainDataSeller = array();
                while($row = mysqli_fetch_assoc($resultSeller)){
                    $dataSeller = array(
                        "name" => $row['full_name'],
                        "id" => $row['id'],
                        "seller_rating" => $row['seller_rating'],
                        "address" => $row['address']
                    );   
                    array_push($mainDataSeller, $dataSeller);
                    unset($dataSeller);                
                }
                $jsonSeller = json_encode($mainDataSeller);                
            }


            if($resultCheckTopTenSeller > 0)
            {
                $mainDataTopTenSeller = array();
                while($row = mysqli_fetch_assoc($resultTopTenSeller)){
                    $dataTopTenSeller = array(
                        "name" => $row['full_name'],
                        "id" => $row['id'],
                        "seller_rating" => $row['seller_rating'],
                        "address" => $row['address']
                    );   
                    array_push($mainDataTopTenSeller, $dataTopTenSeller);
                    unset($dataTopTenSeller);                
                }
                $jsonTopTenSeller = json_encode($mainDataTopTenSeller);                
            }

        ?>

        <script>
            var jsonJsProduct = <?= $jsonProduct?>;
            console.log(jsonJsProduct);
            
            var jsonJsProject = <?= $jsonProject; ?>;
            console.log(jsonJsProject);

            var jsonJsTopTenProject = <?= $jsonTopTenProject; ?>;
            console.log(jsonJsTopTenProject);

            var jsonJsTopTenProduct = <?= $jsonTopTenProduct; ?>;
            console.log(jsonJsTopTenProduct);

            var jsonJsTopTenSeller = <?= $jsonTopTenSeller; ?>;
            console.log(jsonJsTopTenSeller);

            var jsonJsSeller = <?= $jsonSeller; ?>;
            console.log(jsonJsSeller)

            
            appendAllMyJson(jsonJsProduct, jsonJsProject, jsonJsTopTenProject, jsonJsTopTenProduct,jsonJsTopTenSeller, jsonJsSeller);
        </script>

 
           
    <footer>

        <div id="fuck" class="img_footer">
            <div id="about_us">
                <a class="link_footer" href="#">About us</a>
            </div>
            <div id="policy">
                <a class="link_footer" id="our_policy" href="#">Our policy</a>
                <a class="link_footer" href="#">Private policy</a>
            </div>
            <div id="contact">
                <a class="link_footer" href="#">Oray</a>
                <p>Contact number: <span id="phone"></span></p>
                <p>Contact mail: <span id="mail"></span></p>
                <p>Contact address: <span id="address"></span></p>
            </div>
        </div>


    </footer>
</body>

</html>