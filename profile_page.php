<?php 
include_once 'dbconnection.php';
session_start();

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
    <script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>

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
            if(profileData["profile_pic_link"] == "")
            {   document.getElementById("profile_picture_principal").src = "source/icones/profileIcon.png";}
            else
            {document.getElementById("profile_picture_principal").src = profileData["profile_pic_link"];}
                }

        /**------------------------------------------------------------------------------------ */

        function createMyCharts(myTitle, dataImported, specificContainer){
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
        function appendJsonMyProjectParticipation(dataBiding){
            for(var i = 0; i< dataBiding.length; i++){
                {createMyParticipationCard(dataBiding[i].part_pic, 
                dataBiding[i].projectID, dataBiding[i].item_description, dataBiding[i].item_type, 
                dataBiding[i].price, dataBiding[i].project_itemID, dataBiding[i].item_status);}
            }
        }

        function appendJsonMyFavorite(dataFavorite){
            for(var i = 0; i< dataFavorite.length; i++){
                createMyCard("favoriteInnerTab", dataFavorite[i].item_pic_link, 
                dataFavorite[i].product_description, dataFavorite[i].product_price, true, dataFavorite[i].product_name, 
                dataFavorite[i].product_id, "t");
            }
        }

        function appendJsonTopTenProduct(dataRecommended, dataFavorite){
            var isFavorite = null;

            for(var i = 0; i<dataRecommended.length; i++){
                isFavorite = false;
                if(typeof dataFavorite != 'undefined')
                        {for(var j = 0; j<dataFavorite.length; j++){

                            if (dataFavorite[j].product_id == dataRecommended[i].product_id)
                            isFavorite = true;
                        }}
                createMyCard("recommendation", dataRecommended[i].item_pic_link, dataRecommended[i].product_description, 
                dataRecommended[i].product_price, isFavorite, dataRecommended[i].product_name, 
                dataRecommended[i].product_id, "a");
            }
        }

        function appenedHistoryCard(data){
            for(var i = 0; i< data.length; i++){
                createMyHistoryCard("historyInnerTab", data[i].item_pic_link, data[i].history_id, data[i].item_id, 
                                    data[i].seller_id, data[i].address, data[i].timestamp, data[i].price_item, data[i].amount, 
                                    data[i].delivery_status, data[i].item_description);
            }
        }

        function appendJsonMyProduct(data){
            for(var i = 0; i< data.length; i++){
                createMyCard("myProducts", data[i].item_pic_link, data[i].product_description, 
                data[i].product_price, null, data[i].product_name, 
                data[i].product_id, null);
                    }
        }

        function appendProjects(dataProjects){
            for(var i = 0; i< dataProjects.length; i++){
                createMyProjectCard("projectsInnerTab", dataProjects[i].id, dataProjects[i].project_name, dataProjects[i].project_description,
                dataProjects[i].project_pic_link, dataProjects[i].project_status, dataProjects[i].deadline, dataProjects[i].budget, 
                dataProjects[i].bid_count);
            }
        }


        function buyNow()
        {
        if (validate())
        {
            var str = $("#buy_now_form").serialize(); // use jQuery to turn the form into a big array
            var xhttp = new XMLHttpRequest(); // using AJAX 
            xhttp.open("POST","handle_purchase.php",true); // call this page again with a POST variable that indicates which item to add to cart
            xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhttp.send(str); // POST that big array
            location.reload();
            
            window.alert("Thank you for your purchase!");
        }
        }

        function validate()
        {
            var form =  document.getElementById("buy_now_form");
        if (form.full_name.value.length <= 6 )
        {
                window.alert("Full name needs to be at least 6 characters long");
                return false;
        }
        if (form.buyer_email.value.length <= 5 || form.buyer_email.value.search("@") == -1  || form.buyer_email.value.search(".") == -1)
        {
            window.alert("Email is invalid, makes sure it includes @ and . " ) ;
            return false;
        } 
        if (form.shipping_address.value.length <= 10)
        {
            window.alert("shipping address is too short. Make sure it's at least 10 characters long");
            return false;
        }
            if (form.credit_card.value.length <= 16)
            {
            window.alert("credit card needs to be at least 16 digits long");
            return false;
            }
    
            return true;

        }

        function createMyParticipationCard (picture, 
                projectId, descriptionItem, itemType, price, itemId, status){

                    const newRow = document.createElement("div");
                    newRow.classList.add("itemProjectRow");
                    newRow.classList.add(status);

                    const imageItemProject = document.createElement("img");
                    imageItemProject.classList.add("imgItemProject");

                    const descriptionItemProject = document.createElement("p");
                    descriptionItemProject.innerHTML = descriptionItem;
                    descriptionItemProject.classList.add("desc_item_fq");
                    const priceItemProject = document.createElement("p");

                    if(status == 'pending')
                    priceItemProject.innerHTML = "You proposed: " + price + "$";
                    else
                    priceItemProject.innerHTML = "Accepted: " + price + "$";

                    const typeItemProject = document.createElement("p");
                    typeItemProject.innerHTML = itemType;

                    const columnProject = document.createElement("div");
                    columnProject.classList.add("columnButtonProject");

                    const seeItemProject = document.createElement("button");
                    seeItemProject.classList.add("button_history");
                    seeItemProject.innerHTML = "See item";

                    const seeProject = document.createElement("button");
                    seeProject.classList.add("button_history");
                    seeProject.innerHTML = "See project";

                    newRow.appendChild(imageItemProject);
                    newRow.appendChild(descriptionItemProject);
                    newRow.appendChild(typeItemProject);
                    newRow.appendChild(priceItemProject);
                    newRow.appendChild(columnProject);
                    columnProject.appendChild(seeItemProject);
                    columnProject.appendChild(seeProject);

                    document.getElementById("myProjectsParticipation").appendChild(newRow);
                    $(seeProject).wrap("<a href=project_page.php?projectID="+projectId+"></a>");
                    $(seeItemProject).wrap("<a href=bid_item_page.php?itemID="+itemId+"></a>");

                }

        function createMyProjectCard(tabName, id, name, description, picture, status, deadline, budget, bidCount){
            const newCard = document.createElement("div");
            newCard.classList.add("historicalCard");

            const firstBand = document.createElement("div");
            firstBand.classList.add("firstBand");

            const dateCommand = document.createElement("p");
            dateCommand.classList.add("dateCommand");
            dateCommand.innerHTML = "Project created the: <br/>";

            const totalCommand = document.createElement("p");
            totalCommand.classList.add("totalCommand");
            totalCommand.innerHTML = "Budget:<br/>" + budget;

            const addressCommand = document.createElement("p");
            addressCommand.classList.add("addressCommand");
            addressCommand.innerHTML = "Price propositions:<br/>" + bidCount;

            const bill = document.createElement("div");
            bill.classList.add("bill");

            const idCommand = document.createElement("p");
            idCommand.classList.add("idCommand");
            idCommand.innerHTML = "N° project: " + id;

            const seeBill = document.createElement("button");
            seeBill.classList.add("seeBill");
            seeBill.classList.add("button_history");
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
            dateCommandDelivery.innerHTML = "Deadline: " + deadline;

            const descriptionCommand = document.createElement("p");
            descriptionCommand.classList.add("descriptionCommand");
            descriptionCommand.innerHTML = description;

            const secondContainerButton = document.createElement("div");
            secondContainerButton.classList.add("secondContainerButton");

            const seeProductAgain = document.createElement("button");
            seeProductAgain.classList.add("seeProductAgain");
            seeProductAgain.classList.add("button_history");
            seeProductAgain.innerHTML = "See project";

            const lastContainerSecondBand = document.createElement("div");
            lastContainerSecondBand.classList.add("lastContainerSecondBand");


            const buttonRankSeller = document.createElement("button");
            buttonRankSeller.classList.add("button_history");
            buttonRankSeller.innerHTML = "Share project";

            const buttonSeeSeller = document.createElement("button");
            buttonSeeSeller.classList.add("button_history");
            buttonSeeSeller.innerHTML = "See bider";

            const buttonProblem = document.createElement("button");
            buttonProblem.classList.add("button_history");
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

            secondContainerButton.appendChild(seeProductAgain);

            lastContainerSecondBand.appendChild(buttonRankSeller);
            lastContainerSecondBand.appendChild(buttonSeeSeller);
            lastContainerSecondBand.appendChild(buttonProblem);

            document.getElementById(tabName).appendChild(newCard);
            $(seeProductAgain).wrap("<a href=project_page.php?projectID="+id+"></a>");
        }

        function createMyHistoryCard(tabName, picture, commandNumber, itemId, sellerId, address, timestamp, price, amount, delivery, description){
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
            seeBill.classList.add("button_history");
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
            descriptionCommand.innerHTML = description;

            const secondContainerButton = document.createElement("div");
            secondContainerButton.classList.add("secondContainerButton");

            const buyAgain = document.createElement("button");
            buyAgain.classList.add("buyAgain");
            buyAgain.classList.add("button_history");
            buyAgain.innerHTML = "Buy again";

            const seeProductAgain = document.createElement("button");
            seeProductAgain.classList.add("seeProductAgain");
            seeProductAgain.classList.add("button_history");
            seeProductAgain.innerHTML = "See product";

            const lastContainerSecondBand = document.createElement("div");
            lastContainerSecondBand.classList.add("lastContainerSecondBand");


            const buttonRankSeller = document.createElement("button");
            buttonRankSeller.classList.add("button_history");
            buttonRankSeller.innerHTML = "Rank seller";

            const buttonSeeSeller = document.createElement("button");
            buttonSeeSeller.classList.add("button_history");
            buttonSeeSeller.innerHTML = "See seller";

            const buttonProblem = document.createElement("button");
            buttonProblem.classList.add("button_history");
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

            $(pictureProduct).wrap("<a href=product_page.php?productID="+itemId+"></a>");
            seeProductAgain.onclick = function() { window.location.href='product_page.php?productID='+itemId; };
            buyAgain.setAttribute("data-bs-toggle", "modal");
            buyAgain.setAttribute("data-bs-target", "#buy_now_modal");

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
            
            var newLikeIcone = null;
            var newLikeParagraph;
            var newLikeButton;
            
            var newLikeIcone = null;
            if(liked != null)
            {
                newLikeParagraph = document.createElement("p");
                newLikeButton = document.createElement("button");
                newLikeButton.classList.add("heart_button");
                newLikeIcone = document.createElement("img");
                newLikeIcone.classList.add("icon_heart");
                newLikeIcone.id = doubleTag + id;

                if (liked == true) {
                    newLikeIcone.src = "source/icones/groupe_22_filled.png"
                } else {
                    newLikeIcone.src = "source/icones/groupe_22.png"
                }
            }

            newCard.appendChild(newPicture);
            newCard.appendChild(newNameProduct);
            newCard.appendChild(newDescription);
            newCard.appendChild(newContainerBottomCard);
            newContainerBottomCard.appendChild(newPrice);
            
            if(liked != null)
            {
                newContainerBottomCard.appendChild(newLikeParagraph);
                newLikeParagraph.appendChild(newLikeButton);
                newLikeButton.appendChild(newLikeIcone);
            }

            document.getElementById(tabName).appendChild(newCard);

            $(newPicture).wrap("<a href=product_page.php?productID="+id+"></a>");
            if(liked != null)
            {
                newLikeIcone.onclick = function(){
                    if(newLikeIcone.src == "source/icones/groupe_22_filled.png"){
                        newLikeIcone.src ="source/icones/groupe_22.png";
                    } else {
                        newLikeIcone.src = "source/icones/groupe_22_filled.png";
                    }
                }
            }
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
                                Name
                            </th>
                            <td id="fullName">
                            </td>
                        </tr>
                        <tr>
                            <th>
                                UserName
                            </th>
                            <td id="username">
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
                            </td>
                        </tr>
                        <tr>
                            <th>
                                Address
                            </th>
                            <td id="userAddress">
                            </td>
                        </tr>
                        <tr>
                            <th id="last_row" rowspan="2">
                                Payment method
                            </th>
                            <td id="creditCard">
                            </td>
                        <tr>
                            <td id="payPalAccount">
                            </td>
                        </tr>

                        </tr>
                    </table>

                </div>

                <img id="profile_picture_principal" src="source/icones/profileIcon.png">
            </div>

            <div class="form-popup" id="myForm">
                <form method="post" action="editProfileToSql.php" class="form-container" enctype="multipart/form-data">
                    <label for="nameEdit"><b>Name:</b></label>
                    <input type="text" placeholder="Enter name" name="nameEdit"><br/>

                    <label for="email"><b>Email:</b></label>
                    <input type="text" placeholder="Enter Email" name="email"><br/>

                    <label for="start"><b>Birthday:</b></label>
                    <input type="date" id="start" name="start" min="1920-01-01"><br/>

                    <label for="Address"><b>Address:</b></label>
                    <input type="text" placeholder="Enter Address" name="Address"><br/>

                    <label for="filename"><b>Change profile picture</b></label>
                    <input type="file" id="filename" name="filename"><br/>

                    <button type="submit" class="my_button_edit saveclose">Save changes</button><br/>
                    <p class="my_button_edit saveclose" id="closeformbutton" onclick="closeForm()">Close</p>
                </form>
            </div>
            <button class="my_button_edit" id="edit_button" onclick="openForm()">Edit</button>
        
        </div>
            
        <div id="buyer_profile" class="tabcontent">
            <div class="containerBuyerProfile">
                <div class="sideLeftBuyerProfile">
                    <div id="recommendation" class="recommendationContainer" onMouseOver="pauseDiv()" onMouseOut="resumeDiv()">

                    </div>
                    <button class="withdraw_button innerBuyerTabContent" id="projectInnerButton" onclick="window.location.href='create_new_project_page.php';">Create new project</button>
                </div>
                <div class="historicContainer" id="historicalContainerId">

                    <div class="innerTab">
                        <button id="defaultOpenProductsHistory" class="innertablink" onclick="openTab('historyInnerTab', this, 'innerBuyerTabContent')">Products history</button>
                        <button id="projectsProfileHistory" class="innertablink" onclick="openTab('projectsInnerTab', this, 'innerBuyerTabContent')">Projects</button>
                        <button id="favoriteProfileHistory" class="innertablink" onclick="openTab('favoriteInnerTab', this, 'innerBuyerTabContent')">Products you liked</button>
                    </div>

                    <div id="historyInnerTab" class="innerBuyerTabContent">

                    </div>

                    <div id="projectsInnerTab" class="innerBuyerTabContent">

                    </div>

                    <div id="favoriteInnerTab" class="innerBuyerTabContent row">

                    </div>

                </div>
            </div>

            <!-- Modal window -->

            <div id="buy_now_modal" class="modal " tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Purchase details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                <form id="buy_now_form" >   
                    <div class="mb-3">
                        <label for="full_name" class="form-label">Full name:</label>
                        <input type="text" class="form-control" name="full_name"  id="full_name" required>
                    </div> 
                    <div class="mb-3">
                        <label for="buyer_email" class="form-label">Your email:</label>
                        <input type="email" class="form-control" name="buyer_email" id="buyer_email" required 
                        aria-describedby="seller_amount_reminder">
                        <div id="email_comment" class="form-text">
                            We'll never share your email with anyone else besides the seller.
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="quantity" class="form-label">Select amount:</label>
                        <input type="number" class="form-control" name="quantity" id="quantity" min="1" value="1" required
                        aria-describedby="seller_amount_reminder">
                        <div id="seller_amount_reminder" class="form-text"> 
                            Please keep in mind the seller might take a while to produce a large order
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="shipping_address" class="form-label">Your full address:</label>
                        <textarea class="form-control" name="shipping_address" id="shipping_address" style="height: 50px" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="credit_card" class="form-label">Credit card num:</label>
                        <input type="text" class="form-control" name="credit_card" id="credit_card" required>
                    </div>   
            
                </div>    
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" onclick="buyNow()" class="btn btn-warning">Confirm</button>
                    </form>
                </div>
                </div>
            </div>
            </div>

            <!-------------------------> 
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
                        <button class="my_button_add_product" onclick="showProjectParticipationAccepted()">In progress</button>
                        <button class="my_button_add_product" onclick="showProjectParticipationInProcess()">Price proposition</button>
                        <div id="myProjectsParticipation" class="personalProduct row">
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

            $sqlMyHistory = "SELECT transaction_history.*,sales_item.item_pic_link,sales_item.item_link, sales_item.item_description FROM transaction_history 
                             INNER JOIN sales_item ON sales_item.id = transaction_history.sales_itemID 
                             WHERE buyerID =".$_SESSION['userID'];

            $sqlMyFavorite ="SELECT * FROM fav_posts
                             INNER JOIN sales_item ON sales_item.id = fav_posts.sales_itemID 
                             WHERE userID =".$_SESSION['userID'];

            $sqlMyProjects ="SELECT * FROM project WHERE posterID =" .$_SESSION['userID'];

            $sqlProjectsParticipation = "SELECT projectID, part_pic, item_description, item_type, item_status, price, note, project_itemID FROM project_item 
                                         INNER JOIN project_item_bids ON project_item_bids.project_itemID = project_item.id
                                         where bidderID =".$_SESSION['userID'];

            $resultMyProjects = mysqli_query($conn, $sqlMyProjects);
            $resultCheckMyProjects = mysqli_num_rows($resultMyProjects);

            $resultFavorite = mysqli_query($conn, $sqlMyFavorite);
            $resultCheckFavorite = mysqli_num_rows($resultFavorite);

            $resultHistory = mysqli_query($conn, $sqlMyHistory);
            $resultCheckHistory = mysqli_num_rows($resultHistory);

            $resultProjectsParticipation = mysqli_query($conn, $sqlProjectsParticipation);
            $resultCheckProjectsParticipation = mysqli_num_rows($resultProjectsParticipation);

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
            }else {$jsonEarningData = 0;
                    $jsonEarning = 0;}

            if($resultCheckMyProjects > 0){
                $mainDataMyProjects  = array();
                while($row = mysqli_fetch_assoc($resultMyProjects)){
                    $dataMyProjects  = array(
                        "id" => $row['id'],
                        "project_name" => $row['project_name'],
                        "project_description" => $row['project_description'],
                        "project_pic_link" => $row['project_pic_link'],
                        "project_status" => $row['project_status'],
                        "deadline" => $row['deadline'],
                        "budget" => $row['budget'],
                        "bid_count" => $row['bid_count']
                    );   
                    array_push($mainDataMyProjects , $dataMyProjects );
                    unset($dataMyProjects );                
                }
                $jsonMyProjects = json_encode($mainDataMyProjects ); 
            } else $jsonMyProjects = 0;


            if($resultCheckProjectsParticipation > 0){
                $mainDataProjectsParticipation  = array();
                while($row = mysqli_fetch_assoc($resultProjectsParticipation)){
                    $dataProjectsParticipation  = array(
                        "projectID" => $row['projectID'],
                        "note" => $row['note'],
                        "item_description" => $row['item_description'],
                        "part_pic" => $row['part_pic'],
                        "item_status" => $row['item_status'],
                        "item_type" => $row['item_type'],
                        "price" => $row['price'],
                        "project_itemID" => $row['project_itemID']
                    );   
                    array_push($mainDataProjectsParticipation , $dataProjectsParticipation );
                    unset($dataProjectsParticipation );                
                }
                $jsonProjectsParticipation = json_encode($mainDataProjectsParticipation ); 
            } else $jsonProjectsParticipation = 0;

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
                        "delivery_status" => $row['transaction_status'],
                        "item_pic_link" => $row['item_pic_link'],
                        "item_description" => $row['item_description']
                    );   
                    array_push($mainDataHistory , $dataHistory );
                    unset($dataHistory );                
                }
                $jsonHistory  = json_encode($mainDataHistory ); 
            }else $jsonHistory = 0;

            if($resultCheckFavorite > 0){
                $mainDataMyFavorite = array();
                while($row = mysqli_fetch_assoc($resultFavorite)){
                    $dataMyFavorite  = array(
                        "product_name" => $row['item_name'],
                        "product_id" => $row['id'],
                        "product_price" => $row['price'],
                        "product_description" => $row['item_description'],
                        "item_pic_link" => $row['item_pic_link']
                    );   
                    array_push($mainDataMyFavorite , $dataMyFavorite );
                    unset($dataMyFavorite );                
                }
                $jsonMyFavorite  = json_encode($mainDataMyFavorite ); 
            }else $jsonMyFavorite = 0;

            if($resultCheckSqlMyProduct > 0){
                $mainDataMyProduct  = array();
                while($row = mysqli_fetch_assoc($resultSqlMyProduct)){
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
            }else $jsonMyProduct = 0;

            if($resultCheckTopTenProduct > 0){
                $mainDataTopTenProduct  = array();
                while($row = mysqli_fetch_assoc($resultTopTenProduct)){
                    $dataTopTenProduct  = array(
                        "product_name" => $row['item_name'],
                        "product_id" => $row['id'],
                        "product_price" => $row['price'],
                        "product_description" => $row['item_description'],
                        "item_pic_link" => $row['item_pic_link']
                    );   
                    array_push($mainDataTopTenProduct , $dataTopTenProduct );
                    unset($dataTopTenProduct );                
                }
                $jsonTopTenProduct  = json_encode($mainDataTopTenProduct ); 
            }else $jsonTopTenProduct = 0;

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
                        "address" => $row['address'],
                        "profile_pic_link" => $row['profile_pic_link']
                    );   
            }
        ?>

        <script>

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
            if(tabName == "historyInnerTab")
            document.getElementById(tabName).style.flexDirection = "column";

        // Removed so the links don't stay 'highlighted' after switching
       //     elmnt.style.color = '#E68235';
       //     document.getElementById(tabName).style.color = '#707070';

            if(tabName=="seller_profile"){
                document.getElementById("defaultProductOpen").click();
                document.getElementById(tabName).style.color = '#707070';
            }

            if(tabName =="projectsInnerTab" && window.innerWidth >= 1000){
                document.getElementById("projectInnerButton").style.display = "block";
            }

            if(tabName=="buyer_profile"){
                document.getElementById("defaultOpenProductsHistory").click();
                document.getElementById(tabName).style.color = '#707070';
            }

            if(tabName == "projectParticipated"){
                showAllProjectParticipation();
            }
            }

            // Get the element with id="defaultOpen" and click on it
            document.getElementById("defaultOpen").click();
            document.getElementById("principal_profile").style.color = '#707070';

            jsonJsProfile = {
                        "name" : <?php echo json_encode($dataProfile["name"], JSON_HEX_TAG); ?>,
                        "id" : <?php echo json_encode($dataProfile["id"], JSON_HEX_TAG); ?>,
                        "mail" :  <?php echo json_encode($dataProfile["mail"], JSON_HEX_TAG); ?>,
                        "birthday" :  <?php echo json_encode($dataProfile["birthday"], JSON_HEX_TAG); ?>,
                        "credit" :  <?php echo json_encode($dataProfile["credit"], JSON_HEX_TAG); ?>,
                        "bankAccount" :  <?php echo json_encode($dataProfile["bank_account"], JSON_HEX_TAG); ?>,
                        "seller_rating" :  <?php echo json_encode($dataProfile["seller_rating"], JSON_HEX_TAG); ?>,
                        "address" :  <?php echo json_encode($dataProfile["address"], JSON_HEX_TAG); ?>,
                        "profile_pic_link" :  <?php echo json_encode($dataProfile["profile_pic_link"], JSON_HEX_TAG); ?>
                    };   
            appendData(jsonJsProfile);

            var jsonJsMyFavorite;
            var jsonJsMyProduct;
            var jsonJsMyProjects;
            var jsonEarningDataJs;
            var jsonTentative;
            var jsonJsHistory;
            var jsonJSProjectsParticipation


            if(<?php echo json_encode($jsonMyFavorite); ?> != 0)
                jsonJsMyFavorite = <?= $jsonMyFavorite; ?>;






            if(<?php echo json_encode($jsonMyProduct); ?> != 0)
                jsonJsMyProduct = <?= $jsonMyProduct; ?>;







            if(<?php echo json_encode($jsonMyProjects); ?> != 0)
            {jsonJsMyProjects = <?= $jsonMyProjects; ?>;
            appendProjects(jsonJsMyProjects);}








            if(<?php echo json_encode($jsonEarningData); ?> != 0)
                jsonEarningDataJs = <?= $jsonEarningData; ?>;












            if(<?php echo json_encode($jsonEarning); ?> != 0)
                jsonTentative = <?= $jsonEarning; ?>;











            if(<?php echo json_encode($jsonProjectsParticipation); ?> != 0)
            {
                jsonJSProjectsParticipation = <?= $jsonProjectsParticipation; ?>;
            }

            if(<?php echo json_encode($jsonEarning); ?> != 0)
            {
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
                }
            
            var jsonJsTopTenProduct = <?= $jsonTopTenProduct; ?>;

            if(typeof jsonJsMyProduct != 'undefined')
            appendJsonMyProduct(jsonJsMyProduct);

            if(typeof jsonJsTopTenProduct != 'undefined')
            appendJsonTopTenProduct(jsonJsTopTenProduct, jsonJsMyFavorite);

            if(typeof jsonJsMyFavorite != 'undefined')
            appendJsonMyFavorite(jsonJsMyFavorite);

            if(typeof jsonJSProjectsParticipation != 'undefined')
            appendJsonMyProjectParticipation(jsonJSProjectsParticipation);

            if(<?php echo json_encode($jsonHistory); ?> != 0)
            {jsonJsHistory = <?= $jsonHistory; ?>;
            appenedHistoryCard(jsonJsHistory);}



           
            
            

            
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

                function openForm() {
                    document.getElementById("myForm").style.display = "flex";
                    document.getElementById("edit_button").style.display = "none"
                }

                function closeForm() {
                    document.getElementById("myForm").style.display = "none";
                    document.getElementById("edit_button").style.display = "block"
                    document.getElementById('closeformbutton').preventDefault();
                }

            //    closeForm();
            /**------------------------------------------------------- */
            function showProjectParticipationAccepted(){
                var list = document.getElementsByClassName("pending");
                for(var i = 0; i<list.length; i++){
                    list[i].style.display = "none"
                }
                 var list2 = document.getElementsByClassName("approved");
                 for(var i = 0; i<list2.length; i++){
                     list2[i].style.display = "flex";
                 }
            }
            function showProjectParticipationInProcess(){
                var list = document.getElementsByClassName("pending");
                for(var i = 0; i<list.length; i++){
                    list[i].style.display = "flex"
                }
                 var list2 = document.getElementsByClassName("approved");
                 for(var i = 0; i<list2.length; i++){
                     list2[i].style.display = "none";
                 }
            }

            function showAllProjectParticipation(){
                var list = document.getElementsByClassName("itemProjectRow");
                for(var i = 0; i<list.length; i++){
                    list[i].style.display = "flex"
                }
            }


            /**---------------------------------------------------- */

            const myHearts = document.querySelectorAll(".heart_button");
            var myHeartsInitList = [];
            var myHeartsLastList = [];
            
            myHearts.forEach((e) => {
                var myId = e.childNodes[0].id;
                var mySrc = document.getElementById(myId).src;

                var type = "'seller'";
                var realId = myId.replace("a", "");
                realId = realId.replace("t", "");

                if(myId.includes("t"))
                    var secondId = "a"+realId;
                else
                    var secondId = "t"+realId;

                var check =false;

                type = "'sales_itemID'";
                 
                if(type == "'sales_itemID'")
                {
                    if(typeof jsonJsMyFavorite != 'undefined')
                    {
                        for(var i =0; i<jsonJsTopTenProduct.length; i++){
                            for(var j =0; j<jsonJsMyFavorite.length; j++){
                                if(jsonJsTopTenProduct[i].product_id == jsonJsMyFavorite[j].product_id && jsonJsTopTenProduct[i].product_id == realId)
                                check = true;
                            }
                        }
                    }
                }
              
                myObj = {
                    "id":myId,
                    "src":mySrc,
                    "type":type
                };
                myHeartsInitList.push(myObj);

                if(mySrc.includes("source/icones/groupe_22_filled.png"))
                {myHeartsLastList.push(myObj);}


                e.addEventListener('click', function() {changeFavorite(e, myHeartsLastList, myId, realId, type, secondId, check);});
                
            })


            function changeFavorite(element, myHeartsLastList, myId, cleanId, type, secondId, checked){
            
            
            
            var notExist = true;

            if(document.getElementById(myId).src.includes("source/icones/groupe_22_filled.png")){
                document.getElementById(myId).src = "source/icones/groupe_22.png";
                if(checked)
                document.getElementById(secondId).src = "source/icones/groupe_22.png";
            }
            else
            {
                document.getElementById(myId).src = "source/icones/groupe_22_filled.png";
                if(checked)
                document.getElementById(secondId).src = "source/icones/groupe_22_filled.png";
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
            if(type == "'projectID'")
            type = true;
            else if(type == "'sales_itemID'") 
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

        <footer>

        </footer>

</body>

</html>