<?php 
include_once 'dbconnection.php';
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
    <link rel="stylesheet" href="styleSheet.css" />
    <title>Oray</title>

    
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
        

        function appendAllMyJson(dataProduct, dataProject, dataTopTenProject, dataTopTenProduct){
                    for(var i = 0; i< dataProject.length; i++){
                        createNewCardTopTenProduct("project_link_card_happened","source/produits/project4.jpg", dataProject[i].project_description, dataProject[i].project_budget, true, dataProject[i].project_name);
                    }
                    for(var i = 0; i< dataProduct.length; i++){
                        createNewCardTopTenProduct("product_link_card_happened","source/produits/onepieceluffy.jpg", dataProduct[i].product_description, dataProduct[i].product_price, true, dataProduct[i].product_name);
                    }
                    for(var i = 0; i< dataTopTenProject.length; i++){
                        createNewCardTopTenProduct("top_ten_project_card_happened","source/produits/project4.jpg", dataProject[i].project_description, dataProject[i].project_budget, true, dataProject[i].project_name);
                    }
                    for(var i = 0; i< dataTopTenProduct.length; i++){
                        createNewCardTopTenProduct("top_ten_card_happened","source/produits/onepieceluffy.jpg", dataProduct[i].product_description, dataProduct[i].product_price, true, dataProduct[i].product_name);
                    }
                    
              
        }



        function createNewCardTopTenProduct(tabName, picture, description, price, liked, productName) {

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
        }

    </script>

</head>

<body>
    <header class="header_class">

        <div>
            <img class="logo" src="source/icones/logo.png">
        </div>

        <div class="header_link">
            <a id="current_page" class="header_specific_link" href="index.html">Home</a>
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
            $sqlTopTenProject = "SELECT * FROM project ORDER BY project.bid_count DESC LIMIT 10";
            $sqlTopTenProduct = "SELECT * FROM sales_item LIMIT 10;";


            $resultProject = mysqli_query($conn, $sqlProject);
            $resultCheckProject = mysqli_num_rows($resultProject);

            $resultProduct = mysqli_query($conn, $sqlProducts);
            $resultCheckProduct = mysqli_num_rows($resultProduct);

            $resultTopTenProject = mysqli_query($conn, $sqlTopTenProject);
            $resultCheckTopTenProject = mysqli_num_rows($resultTopTenProject);

            $resultTopTenProduct = mysqli_query($conn, $sqlTopTenProduct);
            $resultCheckTopTenProduct = mysqli_num_rows($resultTopTenProduct);

            

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

            

            appendAllMyJson(jsonJsProduct, jsonJsProject, jsonJsTopTenProject, jsonJsTopTenProduct);
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