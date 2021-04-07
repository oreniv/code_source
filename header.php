<?php
session_start();
include_once 'user_params.php';

?>


<script>
 // this section deals with updating the cart item count
 
document.getElementsByClassName("number_item")[0].innerHTML = <?= $_SESSION['cart_item_count'] ?>;

if (<?= $_SESSION['userID']  ?> == -1 ){
    
    /*  Make the profile pic disappear then put a 'Register button instead' */

   var loginButton = document.getElementById("profile_link");
   loginButton.remove(); 
   loginButton =  document.createElement("button");
   loginButton.setAttribute("class","btn btn-info h-50 d-inline-block ");
   loginButton.setAttribute("type","button");
   loginButton.innerHTML = "Register";
   document.getElementsByClassName("profile_container")[0].appendChild(loginButton);
    

    
}

</script>


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
    <a id="profile_link" href="profile_page.php">
        <div class="mask_circle">
            <img class="img_profile" src="source/produits/profil_picture.jpg">
        </div>
    </a>
    <div class="cart_container">
        <a class="cart_link" href="#"><span class="number_item">0</span><img class="cart_img"
                src="source/icones/cart.png"></a>
    </div>
</div>

