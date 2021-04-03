<?php 
include_once 'dbconnection.php';
session_start();
echo "Current userID: ",$_SESSION['userID']," ||","  " , $_SESSION['full_name']; 
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <link rel="stylesheet" href="styleSheet.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
    <title>Oray</title>
    <script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/variable-pie.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    <script src="https://code.highcharts.com/modules/export-data.js"></script>
    <script src="https://code.highcharts.com/modules/accessibility.js"></script>

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
            elmnt.style.color = '#E68235';
            document.getElementById(tabName).style.color = '#707070';

        }

        // Get the element with id="defaultOpen" and click on it
        document.getElementById("defaultOpen").click();
        document.getElementById("principal_profile").style.color = '#707070';

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
            
        </div>

        <div id="seller_profile" class="tabcontent">

            
            <div class="myChartDiv">
                <div class="side_container">
                    <figure class="highcharts-figure">
                        <div id="principalChartContainer"></div>
                    </figure>
                    <div class="second_side_container">
                        <p  id="myLegend">hello there</p>
                    </div>
                </div>

                <div class="side_container">
                    <figure class="highcharts-figure ">
                    <div id="creditContainer"></div>
                    </figure>
                    <div class="second_side_container">
                        <p>Withdraw money:</p>
                        <div class="withdraw_container">
                            <input type="number" placeholder="$" class="withdraw_number">
                            <button class="withdraw_button" type="submit">Send</button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="product_project_container">
                <div class="innerTab">
                    <button id="defaultProductOpen" class="innertablink" onclick="openTab('myOwnProduct', this, 'innerTabContent')">Products</button>
                    <button id="project_link" class="innertablink" onclick="openTab('projectParticipated', this, 'innerTabContent')">Projects</button>
                </div>

            </div>
            

        </div>

        <?php
        
            $sqlProfile = "SELECT * FROM users WHERE users.id =".$_SESSION['userID']  ;
            $resultProfile = mysqli_query($conn, $sqlProfile);
            $resultCheckProfile = mysqli_num_rows($resultProfile);

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

            $dataTentative1 = array(
                "name" => "3D products",
                "y" => 200,
                "z" => 28
            );
            $dataTentative2 = array(
                "name" => "3D schemes",
                "y" => 450,
                "z" => 35
            );
            $dataTentative3 = array(
                "name" => "projects",
                "y" => 1250,
                "z" => 12
            );

            $dataTentative4 = array(
                "name" => "3D products",
                "y" => 59,
                "z" => 13
            );
            $dataTentative5 = array(
                "name" => "3D schemes",
                "y" => 35,
                "z" => 9
            );
            $dataTentative6 = array(
                "name" => "projects",
                "y" => 720,
                "z" => 3
            );
            
            

            $earningData = array($dataTentative1, $dataTentative2, $dataTentative3);
            $creditData = array($dataTentative4, $dataTentative5, $dataTentative6);

            $jsonEarningData = json_encode($earningData); 
            $jsonCreditData = json_encode($creditData); 

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


            var myTitle = 'Total:</br>';
            var myTotal = 0;
            var myTitleCredit = 'Total credit:</br>';
            var myTotalCredit = 0;

            jsonEarningData = <?= $jsonEarningData?>;
            jsonCreditData = <?= $jsonCreditData?>;
            
            for(var i = 0; i< jsonEarningData.length; i++){
                myTotal = myTotal + jsonEarningData[i].y;
            }
            for(var i = 0; i< jsonCreditData.length; i++){
                myTotalCredit = myTotalCredit + jsonCreditData[i].y;
            }

            var myTotalString = myTotal.toString();
            myTitle += myTotalString;
            myTitle += '$';
            var myTotalCreditString = myTotalCredit.toString();
            myTitleCredit += myTotalCreditString;
            myTitleCredit += '$';

            createMyCharts(myTitleCredit, jsonCreditData, 'creditContainer');
            createMyCharts(myTitle, jsonEarningData, 'principalChartContainer');
            createMyLegend(jsonEarningData);
            

            
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