<?php
session_start();
?>


<script>
 // this section deals with updating the cart item count
  
document.getElementsByClassName("number_item")[0].innerHTML = <?= $_SESSION['cart_item_count'] ?>;

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

