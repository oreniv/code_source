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
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/variable-pie.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    <script src="https://code.highcharts.com/modules/export-data.js"></script>
    <script src="https://code.highcharts.com/modules/accessibility.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script> 

    <script>
        
        

        /**------------------------------------------------------------------------ */

        function appendData(profileData){

            document.getElementById("fullName").innerHTML = profileData["name"];
            document.getElementById("birthday").innerHTML = profileData["birthday"];
            document.getElementById("usermail").innerHTML = profileData["mail"];
            document.getElementById("userAddress").innerHTML = profileData["address"];
            if(profileData["bankAccount"] == null)
            document.getElementById("creditCard").innerHTML = "none yet";
            else
            document.getElementById("creditCard").innerHTML = profileData["bankAccount"];

            document.getElementById("payPalAccount").innerHTML = "none yet";
                }
        /**------------------------------------------------------------------------------------ */

        function createMyCharts(myTitle, dataImported, specificContainer){
            console.log(dataImported);
            Highcharts.chart(specificContainer, {
                chart: {
                backgroundColor: '#E4F2FB',
                type: 'variablepie'
                },
                credits:{
                    enabled: false
                },
                title: {
                text: myTitle,
                floating: false,
                align: 'center',
                verticalAlign: 'middle',
                },
                tooltip: { 
                headerFormat: '',
                pointFormat: '<span style="color:{point.color}">\u25CF</span> <b> {point.name}</b><br/>' +
                    'Money you made: <b>{point.y}</b><br/>' +
                    'Count: <b>{point.z}</b><br/>'
                },
                exporting: {
                    buttons: {
                        contextButton: {
                            enabled: false
                        }
                    }
                },
                plotOptions: {
                    variablepie: {
                        dataLabels: {
                            enabled: false
                        },
                        showInLegend: false
                    }
                },
                series: [{
                minPointSize: 1,
                innerSize: '60%',
                zMin: 0,
                name: 'products',
                data: dataImported
                }]
            });
        }

        function createMyLegend(data){
            var legend = document.getElementById("myLegend");
            var mySentence=null;
            for (i = 0; i < data.length; i++) {
                if(i==0)
                mySentence = data[i].name + ":   "+data[i].y +"$</br>"
                else
                mySentence = mySentence + data[i].name + ":   "+data[i].y +"$</br>"
            }
            legend.innerHTML = mySentence
        }

        /**-------------------------------------------------------- */
        function appendMyJson(data){
            for(var i = 0; i< data.length; i++){
                createMyCard("myProducts", "source/produits/onepieceluffy.jpg", data[i].product_description, data[i].product_price, true, data[i].product_name);
                    }
            for(var i = 0; i< data.length; i++){
                createMyCard("myProjects", "source/produits/onepieceluffy.jpg", data[i].product_description, data[i].product_price, true, data[i].product_name);
            }
        }

        function createMyCard(tabName, image, description, price, liked, productName){
            const newCard = document.createElement("div");
            newCard.classList.add("card");
            const newPicture = document.createElement("img");
            newPicture.classList.add("img_card");
            newPicture.src = "source/produits/onepiece.jpeg";
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
    <header>
        <header class="header_class">
            <div>
                <img class="logo" src="source/icones/logo.png">
            </div>

            <div class="header_link">
                <a class="header_specific_link" href="index.php">Home</a>
                <a class="header_specific_link" href="#">Shop</a>
                <a class="header_specific_link" href="#">Forum</a>
                <a class="header_specific_link" href="#">Partner</a>
            </div>

            <div class="profile_container">
                <div class="mask_circle">
                    <img class="img_profile" src="source/produits/profil_picture.jpg">
                </div>
                <div class="cart_container">
                    <a class="cart_link" href="#"><span class="number_item">0</span><img class="cart_img"
                            src="source/icones/cart.png"></a>
                </div>
            </div>
        </header>


        <div class="head_button">
                <button id="defaultOpen" class="tablink" onclick="openTab('principal_profile', this, 'tabcontent')">Your profile</button>
                <button id="buyer_profile_link" class="tablink" onclick="openTab('buyer_profile', this, 'tabcontent')">Your buyer profile</button>
                <button id="seller_profile_link" class="tablink" onclick="openTab('seller_profile', this, 'tabcontent')">Your seller profile</button>
        </div>


        <div id="principal_profile" class="profile_container_data tabcontent">
            
            <div  class="profile_container">

                <div class="profile_table">

                    <table id="table_data">
                        <tr>
                            <th id="first_row">
                                name
                            </th>
                            <td id="fullName">
                            </td>
                        </tr>
                        <tr>
                            <th>
                                UserName
                            </th>
                            <td id="username">
                                YohannBe
                            </td>
                        </tr>
                        <tr>
                            <th>
                                Birthday
                            </th>
                            <td id="birthday">
                                
                            </td>
                        </tr>
                        <tr>
                            <th>
                                Mail
                            </th>
                            <td id="usermail">
                                Belhassen.yohann@gmail.com
                            </td>
                        </tr>
                        <tr>
                            <th>
                                Address
                            </th>
                            <td id="userAddress">
                                25 rue jules david les lilas 93260
                            </td>
                        </tr>
                        <tr>
                            <th id="last_row" rowspan="2">
                                Payment method
                            </th>
                            <td id="creditCard">
                                Credit card: xxxxxxxx1993
                            </td>
                        <tr>
                            <td id="payPalAccount">
                                Paypal: Belhassen.yohann@gmail.com
                            </td>
                        </tr>

                        </tr>
                    </table>

                </div>

                <img id="profile_picture_principal" src="source/produits/profil_picture.jpg">
            </div>

            <button class="my_button_edit" onclick="window.location.href='#';">Edit</button>
        
        </div>
            
        <div id="buyer_profile" class="tabcontent">
            <p>fuck you</p>
        </div>

        <div id="seller_profile" class="tabcontent">

            
            <div class="myChartDiv">
                <div class="side_container">
                    <figure class="highcharts-figure">
                        <div id="principalChartContainer"></div>
                        <div class="second_side_container">
                        <p  id="myLegend"></p>
                    </div>
                    </figure>    
                </div>

                <div class="side_container">
                    <figure class="highcharts-figure ">
                    <div id="creditContainer"></div>
                        <div class="second_side_container">
                            <p>Withdraw money:</p>
                            <div class="withdraw_container">
                                <input type="number" placeholder="$" class="withdraw_number" min="0">
                                <button class="withdraw_button" type="submit">Send</button>
                            </div>
                        </div>
                    </figure>
                </div>
            </div>

            <div class="product_project_container">
                <div class="innerTab">
                    <button id="defaultProductOpen" class="innertablink" onclick="openTab('myOwnProductDefault', this, 'innerTabContent')">Products</button>
                    <button id="project_link" class="innertablink" onclick="openTab('projectParticipated', this, 'innerTabContent')">Projects</button>
                </div>

                <div id="myOwnProductDefault" class="innerTabContent">
                    <button class="my_button_add_product" onclick="window.location.href='#';">Add product</button>
                    <div id="myProducts" class="personalProduct row">
                    </div>
                </div>

                <div id="projectParticipated" class="innerTabContent">
                    <div id="myProjects" class="product row">
                        <button class="my_button_add_product" onclick="window.location.href='#';">In progress</button>
                        <button class="my_button_add_product" onclick="window.location.href='#';">Price proposition</button>
                        <div id="myProjects" class="personalProduct row">
                        </div>
                    </div>
                </div>
            </div>
            

        </div>

        <?php

        
            $sqlProfile = "SELECT * FROM users WHERE users.id =".$_SESSION['userID']  ;

         
            $sqlTopTenProduct = "SELECT * FROM sales_item WHERE sales_item.sales_item_posterID = 19;";
            $sqlEarning = "CALL get_seller_total_sold_items(19);";

            $resultEarning = mysqli_query($conn, $sqlEarning);
            $resultCheckEarning = mysqli_num_rows($resultEarning);

            mysqli_close($conn);
            $conn = mysqli_connect($servername, $username, $password, $dbname);


            $resultProfile = mysqli_query($conn, $sqlProfile);
            $resultCheckProfile = mysqli_num_rows($resultProfile);

            $resultTopTenProduct = mysqli_query($conn, $sqlTopTenProduct);
            $resultCheckTopTenProduct = mysqli_num_rows($resultTopTenProduct);

            mysqli_close($conn);
            $conn = mysqli_connect($servername, $username, $password, $dbname);

            if($resultCheckEarning > 0){
                $twoDSketch = 0;
                $twoDSketchCount = 0;
                $treeDSchema = 0;
                $treeDSchemaCount = 0;
                $physical = 0;
                $physicalCount = 0;
                $mainDataEarning  = array();
                while($row = mysqli_fetch_assoc($resultEarning)){
                    $dataEarning  = array(
                        "type" => $row['item_type'],
                        "count" => $row['amount_sold'],
                        "product_price" => $row['price'],
                        "credit" => $row['credit']
                    );   
                    array_push($mainDataEarning , $dataEarning );
                    
                    if($row['item_type'] == "2D-Sketch"){
                        $twoDSketch +=  ($row['amount_sold']*$row['price']) ;
                        $twoDSketchCount+= $row['amount_sold'];
                    }else if($row['item_type'] == "3D-Schema"){
                        $treeDSchema +=  ($row['amount_sold']*$row['price']);
                        $treeDSchemaCount+= $row['amount_sold'];
                    } else if($row['item_type'] == "Physical-item"){
                        $physical +=  ($row['amount_sold']*$row['price']);
                        $physicalCount += $row['amount_sold'];
                    }
                    unset($dataEarning );
                }
                $jsonEarning  = json_encode($mainDataEarning ); 

                
                $earning2dSketch = array(
                    "name"=> '2D-Sketch', 
                    "y"=> $twoDSketch,
                    "z"=>  $twoDSketchCount
                );
                $earning3dSchema = array (
                    "name"=> '3D-Schema', 
                    "y"=> $treeDSchema,
                    "z"=>$treeDSchemaCount
                );
                $earningPhysical = array(
                    "name" => 'Physical-item', 
                    "y"=> $physical,
                    "z"=> $physicalCount
                );
    
                $myfuckingArray = array($earning2dSketch, $earning3dSchema, $earningPhysical);
                $jsonEarningData = json_encode($myfuckingArray);
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

            if($resultCheckProfile > 0)
            {
                $row = mysqli_fetch_assoc($resultProfile);
                    $dataProfile = array(
                        "name" => $row['full_name'],
                        "id" => $row['id'],
                        "mail" => $row['email'],
                        "birthday" => $row['birthdate'],
                        "credit" => $row['credit'],
                        "bankAccount" => $row['bank_account'],
                        "seller_rating" => $row['seller_rating'],
                        "address" => $row['address']
                    );   
            }
        ?>

        <script>
            jsonJsProfile = {
                        "name" : <?php echo json_encode($dataProfile["name"], JSON_HEX_TAG); ?>,
                        "id" : <?php echo json_encode($dataProfile["id"], JSON_HEX_TAG); ?>,
                        "mail" :  <?php echo json_encode($dataProfile["mail"], JSON_HEX_TAG); ?>,
                        "birthday" :  <?php echo json_encode($dataProfile["birthday"], JSON_HEX_TAG); ?>,
                        "credit" :  <?php echo json_encode($dataProfile["credit"], JSON_HEX_TAG); ?>,
                        "bankAccount" :  <?php echo json_encode($dataProfile["bank_account"], JSON_HEX_TAG); ?>,
                        "seller_rating" :  <?php echo json_encode($dataProfile["seller_rating"], JSON_HEX_TAG); ?>,
                        "address" :  <?php echo json_encode($dataProfile["address"], JSON_HEX_TAG); ?>
                    };   
            console.log(jsonJsProfile);
            appendData(jsonJsProfile);

            var jsonJsTopTenProduct = <?= $jsonTopTenProduct; ?>;
            console.log(jsonJsTopTenProduct);

            appendMyJson(jsonJsTopTenProduct);
            jsonEarningDataJs = <?= $jsonEarningData?>;

            jsonTentative = <?=$jsonEarning?>;
            console.log(jsonEarningDataJs);

            console.log(jsonTentative);

            var myTitle = 'Total:</br>';
            var myTotal = 0;
            var myTitleCredit = 'Total credit:</br>';
            var myTotalCredit = 0;
            myTotalCredit = jsonTentative[0].credit;

            
            for(var i = 0; i< jsonEarningDataJs.length; i++){
                myTotal = myTotal + jsonEarningDataJs[i].y;
            }

           
            var myTotalString = myTotal.toString();
            myTitle += myTotalString;
            myTitle += '$';
            myTotalCreditString =  myTotalCredit.toString();
            myTitleCredit += myTotalCreditString;
            myTitleCredit += '$';

            createMyCharts(myTitleCredit, jsonEarningDataJs, 'creditContainer');
            createMyCharts(myTitle, jsonEarningDataJs, 'principalChartContainer');
            createMyLegend(jsonEarningDataJs);
            

            function openTab(tabName, elmnt, tab) {

                // Hide all elements with class="tabcontent" by default */
                var i, tabcontent, tablinks;
                tabcontent = document.getElementsByClassName(tab);
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
                document.getElementById(tabName).style.color = '#707070';

                if(tabName=="seller_profile"){
                    document.getElementById("defaultProductOpen").click();
                    document.getElementById(tabName).style.color = '#707070';
                }
            }

                // Get the element with id="defaultOpen" and click on it
                document.getElementById("defaultOpen").click();
                document.getElementById("principal_profile").style.color = '#707070';
        </script>

        <footer>
            <div class="img_footer">
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