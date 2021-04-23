<?php
session_start();
include_once 'dbconnection.php';
include_once 'user_params.php';


?>

<head>
    <meta charset="utf-8" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
    <link rel="stylesheet" href="styleSheet.css" />
    <title>Oray</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script> 
    <!-- for icon support -->
    <script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>


</head>


<script>
 // this section deals with updating the cart item count
 


if (<?= $_SESSION['userID']  ?> == -1 ){
    
    /*  Make the profile pic disappear then put a 'Register' button instead */


    var registerButton =  document.createElement("button");
    registerButton.setAttribute("class","btn btn-info h-50 d-inline-block ");
    registerButton.setAttribute("type","button");
    registerButton.setAttribute("data-bs-toggle","modal");
    registerButton.setAttribute("data-bs-target","#registerModal");
    registerButton.innerHTML = "Register";
    document.getElementsByClassName("profile_container")[0].appendChild(registerButton);
    
   


    var loginButton = document.createElement("button");
    loginButton.setAttribute("class","btn btn-success h-50 d-inline-block ");
    loginButton.setAttribute("type","button");
    loginButton.setAttribute("data-bs-toggle","modal");
    loginButton.setAttribute("data-bs-target","#loginModal");
    loginButton.innerHTML = "Login";
    document.getElementsByClassName("profile_container")[0].appendChild(loginButton);


}
else 
{

    var logoutButton = document.createElement("button");
    logoutButton.setAttribute("class","btn btn-info h-50 d-inline-block ");
    logoutButton.setAttribute("type","button");
    logoutButton.setAttribute("onclick","logout()");
    logoutButton.innerHTML = "Logout";
    document.getElementsByClassName("profile_container")[0].appendChild(logoutButton);

    var pfp_link = document.createElement("a")
    pfp_link.setAttribute("id","profile_link");
    pfp_link.setAttribute("href","profile_page.php")
    var mask_circle = document.createElement("div");
    mask_circle.setAttribute("class","mask_circle");
    var img_profile = document.createElement("img");
    img_profile.setAttribute("class","img_profile");
    <?php
      $sqlProfile = "SELECT * FROM users WHERE users.id =".$_SESSION['userID'];
      $resultProfile = mysqli_query($conn, $sqlProfile);
      $resultCheckProfile = mysqli_num_rows($resultProfile);
      if($resultCheckProfile > 0)
            {
                $row = mysqli_fetch_assoc($resultProfile);
                    $dataProfile = array(
                        "profile_pic_link" => $row['profile_pic_link']
                    );   
            }
      else{
        $dataProfile = "";
      }
    ?>
    var linkToPicture = <?php echo json_encode($dataProfile["profile_pic_link"], JSON_HEX_TAG); ?>;
    if(linkToPicture == "")
    {img_profile.setAttribute("src","source/icones/profileIcon.png");}
    else
    {img_profile.setAttribute("src",linkToPicture);}

    var cart_container = document.createElement("div");
    cart_container.setAttribute("class","cart_container");
    var cartLink = document.createElement("a");
    cartLink.setAttribute("class","cart_link");
    cartLink.setAttribute("href","#");
    var number_item = document.createElement("span");
    number_item.setAttribute("class","number_item");
    number_item.innerHTML = 0 ;
    var cart_img = document.createElement("img");
    cart_img.setAttribute("class","cart_img");
    cart_img.setAttribute("src","source/icones/cart.png");  
         
    pfp_link.appendChild(mask_circle);
    mask_circle.appendChild(img_profile);
    cart_container.appendChild(cartLink);
    cartLink.appendChild(number_item);
    cartLink.appendChild(cart_img);
    cartLink.setAttribute("href","checkout.php");
    
    document.getElementsByClassName("profile_container")[0].appendChild(pfp_link);
    document.getElementsByClassName("profile_container")[0].appendChild(cartLink);


   
    


    document.getElementsByClassName("number_item")[0].innerHTML = <?= $_SESSION['cart_item_count'] ?>;
  
}
  function logout()
    {
      var xhttp = new XMLHttpRequest();  // using AJAX 
      xhttp.open("POST","user_params.php",false);
      xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
      xhttp.send("kill_session="+true); 
      window.location.assign("index.php");
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

</div>


 

<!-- Login Modal -->
<div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="loginModalLabel">Login</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form method="POST" action="user_params.php" >
      <div class="modal-body">
        
    <div class="mb-3">
        <label for="email_input" class="form-label">Email address:</label>
        <input name="email" type="email" class="form-control" id="email_input" >
    </div>
    <div class="mb-3">
        <label for="password_input" class="form-label">Password:</label>
        <input name="password" type="password" class="form-control" id="password_input" >
        <input name="login_req" class="form-control" type="hidden" value="true"  > 
    </div>
    
    </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button submit" class="btn btn-primary">Login</button>
      </div>
      </form>
    </div>
  </div>
</div>

<!--Register Modal  -->
<div class="modal fade" id="registerModal" tabindex="-1" aria-labelledby="registerModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="registerModalLabel">Register</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form method="POST" action="user_params.php" enctype="multipart/form-data" >
      <div class="modal-body">        
    <div class="mb-3">
        <label for="name_input" class="form-label">Full name:</label>
        <input name="full_name" type="text" class="form-control" id="full_name" >
        <label for="email_input" class="form-label">Email:</label>
        <input name="email" type="email" class="form-control" id="email_input" >
        <label for="birthday_input" class="form-label">Birthday:</label>
        <input name="birthday" type="date" class="form-control" id="birthday_input" >
        <label for="password_input" class="form-label">Password:</label>
        <input name="password" type="password" class="form-control" id="password_input" >        
        <label for="profile_pic" class="form-label">Profile picture: (Optional)</label>
        <input name="profile_pic" type="file" class="form-control" id="profile_pic" >  
        <label for="payment_details" class="form-label">Credit card num:(Optional)</label>
        <input name="payment_details" type="text" class="form-control" id="payment_details" > 
        <label for="address" class="form-label">Full address: (Optional)</label>
        <textarea name="address" type="text" class="form-control" rows="3" id="address" > </textarea>
        <input name="register" class="form-control" type="hidden" value="true"> 
    </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button submit" class="btn btn-primary">Submit</button>
      </div>
      </form>
    </div>
  </div>
</div>









