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
        function appendMyJson(data, dataRecommended){
            for(var i = 0; i< data.length; i++){
                createMyCard("myProducts", "source/produits/onepieceluffy.jpg", data[i].product_description, data[i].product_price, true, data[i].product_name, data[i].product_id);
                    }
            for(var i = 0; i< data.length; i++){
                createMyCard("myProjects", "source/produits/onepieceluffy.jpg", data[i].product_description, data[i].product_price, true, data[i].product_name, data[i].product_id);
            }
            for(var i = 0; i<data.length; i++){
                createMyCard("recommendation", "source/produits/onepieceluffy.jpg", dataRecommended[i].product_description, dataRecommended[i].product_price, true, dataRecommended[i].product_name, dataRecommended[i].product_id);
            }
        }

        function appenedHistoryCard(data){
            for(var i = 0; i< data.length; i++){
                createMyHistoryCard("historicalContainerId", "source/produits/pikachu_ninja.jpg", data[i].history_id, data[i].item_id, 
                                    data[i].seller_id, data[i].address, data[i].timestamp, data[i].price_item, data[i].amount, data[i].delivery_status);
            }
        }

        function createMyHistoryCard(tabName, picture, commandNumber, itemId, sellerId, address, timestamp, price, amount, delivery){
            const newCard = document.createElement("div");
            newCard.classList.add("historicalCard");

            const firstBand = document.createElement("div");
            firstBand.classList.add("firstBand");

            const dateCommand = document.createElement("p");
            dateCommand.classList.add("dateCommand");
            dateCommand.innerHTML = "Command done the: <br/>" + timestamp;

            const totalCommand = document.createElement("p");
            totalCommand.classList.add("totalCommand");
            var total = price * amount;
            totalCommand.innerHTML = "Total:<br/>" + total;

            const addressCommand = document.createElement("p");
            addressCommand.classList.add("addressCommand");
            addressCommand.innerHTML = "Send to:<br/>" + address;

            const bill = document.createElement("div");
            bill.classList.add("bill");

            const idCommand = document.createElement("p");
            idCommand.classList.add("idCommand");
            idCommand.innerHTML = "N° command: " + commandNumber;

            const seeBill = document.createElement("button");
            seeBill.classList.add("seeBill");
            seeBill.innerHTML = "See bill";

            const secondBand = document.createElement("div");
            secondBand.classList.add("secondBand");

            const pictureProduct = document.createElement("img");
            pictureProduct.classList.add("pictureProduct");
            pictureProduct.src = picture;

            const secondContainerSecondBand = document.createElement("div");
            secondContainerSecondBand.classList.add("secondContainerSecondBand");

            const dateCommandDelivery = document.createElement("p");
            dateCommandDelivery.classList.add("dateCommandDelivery");
            dateCommandDelivery.innerHTML = "Status delivery: " + delivery;

            const descriptionCommand = document.createElement("p");
            descriptionCommand.classList.add("descriptionCommand");
            descriptionCommand.innerHTML = "sa gentille race m'a bien usée";

            const secondContainerButton = document.createElement("div");
            secondContainerButton.classList.add("secondContainerButton");

            const buyAgain = document.createElement("button");
            buyAgain.classList.add("secondContainerButton");
            buyAgain.innerHTML = "Buy again";

            const seeProductAgain = document.createElement("button");
            seeProductAgain.classList.add("seeProductAgain");
            seeProductAgain.innerHTML = "See product";

            const lastContainerSecondBand = document.createElement("div");
            lastContainerSecondBand.classList.add("lastContainerSecondBand");


            const buttonRankSeller = document.createElement("button");
            buttonRankSeller.innerHTML = "Rank seller";

            const buttonSeeSeller = document.createElement("button");
            buttonSeeSeller.innerHTML = "See seller";

            const buttonProblem = document.createElement("button");
            buttonProblem.innerHTML = "Problem";

            newCard.appendChild(firstBand);
            newCard.appendChild(secondBand);
            
            firstBand.appendChild(dateCommand);
            firstBand.appendChild(totalCommand);
            firstBand.appendChild(addressCommand);
            firstBand.appendChild(bill);
            bill.appendChild(idCommand);
            bill.appendChild(seeBill);

            secondBand.appendChild(pictureProduct);
            secondBand.appendChild(secondContainerSecondBand);
            secondBand.appendChild(lastContainerSecondBand);

            secondContainerSecondBand.appendChild(dateCommandDelivery);
            secondContainerSecondBand.appendChild(descriptionCommand);
            secondContainerSecondBand.appendChild(secondContainerButton);

            secondContainerButton.appendChild(buyAgain);
            secondContainerButton.appendChild(seeProductAgain);

            lastContainerSecondBand.appendChild(buttonRankSeller);
            lastContainerSecondBand.appendChild(buttonSeeSeller);
            lastContainerSecondBand.appendChild(buttonProblem);

            document.getElementById(tabName).appendChild(newCard);

        }

        function createMyCard(tabName, image, description, price, liked, productName, id){
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

            $(newPicture).wrap("<a href=product_page.php?productID="+id+"></a>");
        }
            
    </script>

</head>

<script>
$(document).ready(function(){
   $(".header_class").load("header.php");
   $("footer").load("footer.html");
 });
</script>




<body onLoad="scrollDiv_init()">
    <header>
        <header class="header_class">
            <!-- Header is loaded with jQuery -->
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
            <div class="containerBuyerProfile">
                <div id="recommendation" class="recommendationContainer" onMouseOver="pauseDiv()" onMouseOut="resumeDiv()">

                </div>
                <div class="historicContainer" id="historicalContainerId">

                    <div class="innerTab">
                        <button id="defaultOpenProducts" class="tablink" onclick="openTab('historicalProduct', this, 'innerBuyerTabContent')">Products history</button>
                        <button id="projects_profile_created" class="tablink" onclick="openTab('historicalProject', this, 'innerBuyerTabContent')">Projects</button>
                        <button id="projects_profile_created" class="tablink" onclick="openTab('historicalLikedProduct', this, 'innerBuyerTabContent')">Products you liked</button>
                    </div>

                </div>
            </div>
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
                    <button class="my_button_add_product" onclick="window.open('add_product.php', '_blank', 'scrollbars=yes,resizable=yes');" >Add product</button>
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

        
            $sqlProfile = "SELECT * FROM users WHERE users.id =".$_SESSION['userID'];

            $sqlTopTenProduct = "CALL get_top10_sales_item_posts();";

            $sqlMyProducts = "SELECT * FROM sales_item WHERE sales_item.sales_item_posterID =".$_SESSION['userID'];

            $sqlEarning = "CALL get_seller_total_sold_items(".$_SESSION['userID'].");";

            $sqlMyHistory = "SELECT * FROM transaction_history WHERE buyerID =".$_SESSION['userID'];

            $resultHistory = mysqli_query($conn, $sqlMyHistory);
            $resultCheckHistory = mysqli_num_rows($resultHistory);

            mysqli_close($conn);
            $conn = mysqli_connect($servername, $username, $password, $dbname);

            $resultEarning = mysqli_query($conn, $sqlEarning);
            $resultCheckEarning = mysqli_num_rows($resultEarning);

            mysqli_close($conn);
            $conn = mysqli_connect($servername, $username, $password, $dbname);

            $resultTopTenProduct = mysqli_query($conn, $sqlTopTenProduct);
            $resultCheckTopTenProduct = mysqli_num_rows($resultTopTenProduct);

            mysqli_close($conn);
            $conn = mysqli_connect($servername, $username, $password, $dbname);


            $resultProfile = mysqli_query($conn, $sqlProfile);
            $resultCheckProfile = mysqli_num_rows($resultProfile);

            $resultSqlMyProduct = mysqli_query($conn, $sqlMyProducts);
            $resultCheckSqlMyProduct = mysqli_num_rows($resultSqlMyProduct);

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

            if($resultCheckHistory > 0){
                $mainDataHistory  = array();
                while($row = mysqli_fetch_assoc($resultHistory)){
                    $dataHistory  = array(
                        "history_id" => $row['id'],
                        "item_id" => $row['sales_itemID'],
                        "seller_id" => $row['sellerID'],
                        "address" => $row['address'],
                        "timestamp" => $row['transaction_timestamp'],
                        "price_item" => $row['price'],
                        "amount" => $row['amount'],
                        "delivery_status" => $row['transaction_status']
                    );   
                    array_push($mainDataHistory , $dataHistory );
                    unset($dataHistory );                
                }
                $jsonHistory  = json_encode($mainDataHistory ); 
            }

            if($resultCheckSqlMyProduct > 0){
                $mainDataMyProduct  = array();
                while($row = mysqli_fetch_assoc($resultSqlMyProduct)){
                    $dataMyProduct  = array(
                        "product_name" => $row['item_name'],
                        "product_id" => $row['id'],
                        "product_price" => $row['price'],
                        "product_description" => $row['item_description']
                    );   
                    array_push($mainDataMyProduct , $dataMyProduct );
                    unset($dataMyProduct );                
                }
                $jsonMyProduct  = json_encode($mainDataMyProduct ); 
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

            var jsonJsMyProduct = <?= $jsonMyProduct; ?>;
            console.log(jsonJsMyProduct);
            

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

            var jsonJsTopTenProduct = <?= $jsonTopTenProduct; ?>;
            console.log(jsonJsTopTenProduct);

            appendMyJson(jsonJsMyProduct, jsonJsTopTenProduct);

            var jsonJsHistory = <?= $jsonHistory; ?>;
            console.log(jsonJsHistory);

            appenedHistoryCard(jsonJsHistory);
            

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

                /**---------------------------------------------------------------------- */

                ScrollRate = 35;

                function scrollDiv_init() {
                    DivElmnt = document.getElementById('recommendation');
                    ReachedMaxScroll = false;
                    
                    DivElmnt.scrollTop = 0;
                    PreviousScrollTop  = 0;
                    
                    ScrollInterval = setInterval('scrollDiv()', ScrollRate);
                }

                function scrollDiv() {
                    
                    if (!ReachedMaxScroll) {
                        DivElmnt.scrollTop = PreviousScrollTop;
                        PreviousScrollTop++;
                        
                        ReachedMaxScroll = DivElmnt.scrollTop >= (DivElmnt.scrollHeight - DivElmnt.offsetHeight);
                    }
                    else {
                        ReachedMaxScroll = (DivElmnt.scrollTop == 0)?false:true;
                        
                        DivElmnt.scrollTop = PreviousScrollTop;
                        PreviousScrollTop--;
                    }
                }

                function pauseDiv() {
                    clearInterval(ScrollInterval);
                }

                function resumeDiv() {
                    PreviousScrollTop = DivElmnt.scrollTop;
                    ScrollInterval    = setInterval('scrollDiv()', ScrollRate);
                }
        </script>

        <footer>

        </footer>

</body>

</html>