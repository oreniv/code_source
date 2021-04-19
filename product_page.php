<?php 
include_once 'dbconnection.php';

session_start();
echo "Current userID: ",$_SESSION['userID']," ||","  " , $_SESSION['full_name']; 
 
?>

<!DOCTYPE html>
<html>

<script>

    function addToCart()
    {
        <?php 
        if (isset($_POST['add_this_item_to_cart']) && $_SESSION['userID'] != -1) // if page is called with set variable set then execute 
        {
       
        $sqlAddToCart = "CALL insert_into_cart(".$_SESSION['userID'].",".$_POST['add_this_item_to_cart'].",'sales_item')";
        $query = mysqli_query($conn,  $sqlAddToCart ); 
         
        array_push($_SESSION['items_in_cart'][0],(int)$_POST['add_this_item_to_cart']);  // push this item to cart so i don't need to ping db again
        $_SESSION['cart_item_count']++ ;  // update item counter on the fly 
        
        unset($_POST['add_this_item_to_cart']); // unset this variable so refreshing the page is possible without adding shit to cart

        mysqli_close($conn);
        
        }

        
        ?>

        if (<?=$_SESSION['userID']?> == -1)
        {
            var myModal = new bootstrap.Modal(document.getElementById('login_request_modal'),{keyboard:true});
            myModal.toggle();
        }
        else
        {
            var productID = <?=$_GET['productID']?> ;     
            var xhttp = new XMLHttpRequest(); // using AJAX 
            xhttp.open("POST","product_page.php",true); // call this page again with a POST variable that indicates which item to add to cart
            xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
            xhttp.send("add_this_item_to_cart="+productID); 
            location.reload(); // remove this when cart updates dynamically 
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
    
    function appendData(profileData){
       
        var price = profileData["price"];
        var print_duration = profileData["print_duration"];
        var delivery_price = profileData["delivery_price"];

        /** Set product title,description,author and related tags **/
       document.getElementById("product_title").innerHTML = profileData["name"] + " ";
       document.getElementById("product_desc").innerHTML ="Description: " + profileData["description"];
       document.getElementById("author").innerHTML ="Posted by: " + profileData["author"] +" ";

       if (profileData["tags"].length == 0 )
       document.getElementById("tags").innerHTML = "This post has no tags";
       else
       document.getElementById("tags").innerHTML = profileData["tags"];

       /** set prices and print duration display */
       if(!print_duration) // if no duration specified it's digital probably 
         document.getElementById("print_duration").innerHTML = "Print time: User did not specify or this is a digital item";
       else
         document.getElementById("print_duration").innerHTML = "Print time: "+print_duration+" days";    
       if(!delivery_price) // if no delivery price specified it's digital probably
       {
        document.getElementById("delivery_price").innerHTML = "Delivery price: Free";
        document.getElementById("price").innerHTML = "Total:" +price+" $";
       } 
       else
       {
          document.getElementById("delivery_price").innerHTML = "Delivery price: "+delivery_price+ " $";
        
          
          document.getElementById("price").innerHTML = "Price:" +price+"$ + " + "Delivery: " + delivery_price+"$ "
          +"\n Total price: " + (Number(price)  + Number(delivery_price) + "$");
       }
      
        
      /** Set stars ***/
       
        var author_rating = profileData["author_rating"];
        var product_rating =  profileData["rating"];
       
        for(i = 1 ; i<=  author_rating;i++) // set author stars
            document.getElementById("author").insertAdjacentHTML("beforeend","<i class='fas fa-star checked_star'></i>");
        for(i = 1 ; i<=  product_rating;i++) // set item stars
            document.getElementById("product_title").insertAdjacentHTML("beforeend","<i class='fas fa-star checked_star'></i>");
       
               
        /****************/
        
        
       


    }



    function appendReview(reviewData){
        var review_count = 0;
          
        if (!reviewData[review_count])  // if a post has no reviews let the user know.
            {
               
            const reviewPost = document.createElement("div");
            reviewPost.classList.add("review_wrapper");
            const reviewUser = document.createElement("div");
            reviewUser.classList.add("col");
            reviewUser.classList.add("comment");
            reviewUser.classList.add("review_user");
            reviewUser.innerHTML = "No reviews so far..." ; 

            reviewPost.appendChild(reviewUser);
            document.getElementById("review_section").appendChild(reviewPost); 
            }

        while(reviewData[review_count]) // build the review list with bootstrap cards
      {
       var userName =  reviewData[review_count]["review_user"] ;
       var rText = reviewData[review_count]["review"];
       var score  = reviewData[review_count]["score"];
       var timeStamp = reviewData[review_count]["timestamp"];
       review_count++;            


       const reviewPost = document.createElement("div");
       reviewPost.classList.add("card");
       reviewPost.style.width = '95%';
       const reviewCard = document.createElement("div");
       reviewCard.classList.add("card-body");
       const reviewUser = document.createElement("h5");
       reviewUser.classList.add("card-title");
       reviewUser.classList.add("text-start");
       reviewUser.innerHTML =  userName+" ";
       const reviewText = document.createElement("p");
       reviewText.classList.add("card-text");
       reviewText.classList.add("text-start");
       reviewText.innerHTML = rText ;
       reviewText.insertAdjacentHTML("beforeend", " <br> posted on: "+timeStamp);
        
       for(i=0;i<score;i++) 
            reviewUser.insertAdjacentHTML("beforeend","<i class='fas fa-star checked_star'></i>");

       reviewCard.appendChild(reviewUser);
       reviewCard.appendChild(reviewText);
       reviewPost.appendChild(reviewCard);
       document.getElementById("review_section").appendChild(reviewPost); 

           
    }
    }
        // checking if the data was written to db 
     if (   <?php  echo json_encode($_SESSION['db_error'] ) ;  ?> == true )
            window.alert("There was an error making the purchase,please try again"); 

</script>


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


<body>

 



<div class="container">
    <div class="row">
        <div class="col-4 "> <!-- Make this dynamic depending on loaded item -->
             <img src="source/produits/project3.jpg" class="img-fluid img-thumbnail">
        </div>
        <div class="col-8 ">
            <div class="d-grid gap-3">
                <div id="product_title" class="p-2 bg-light border fw-bold">Product title</div>
                <div id="author" class="p-2 bg-light border fw-bold">Author</div>
                <div id="product_desc" class="p-2 bg-light border ">Description</div>
                <div id="tags"  class="p-2 bg-light border">Tags</div>
                <div class="row">
                    <div class="col-6 "><div id="print_duration" class="p-2 bg-light border">Print duration </div> </div> 
                    <div class="col-6 "><div id="delivery_price" class="p-2 bg-light border">Delivery price </div> </div> 
                </div>
                <div id="price"  class="p-2 bg-light border">Price</div>
            
            <div class="row">
                <div class="mx-auto">
                    <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#buy_now_modal">Buy now</button>
                    <button onclick="addToCart()" type="button" class="btn btn-success">Add to cart</button>
                </div>            
            </div>


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



<div id="login_request_modal" class="modal" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p>You must be logged in to use the cart</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>




















<div class="container" id="review_section"></div>


    
</body>
    
    
    
    <?php 


            if(isset($_GET['productID']))
                 $_SESSION['productID'] = $_GET['productID'] ; // grab the product ID the user clicked on
           
             
            $sqlProductInfo ="CALL get_sales_item_page_info(".$_SESSION['productID'].")";
            $sqlFetchTags = "CALL get_tags_for_post(".$_SESSION['productID'].",'sales_item')";
            $sqlFetchReviews = "CALL get_post_reviews(".$_SESSION['productID'].")";

       
            $resultProduct = mysqli_query($conn, $sqlProductInfo); // 1st query
            $row = mysqli_fetch_assoc($resultProduct); // store 1st results
            
            
            mysqli_close($conn); // close connection
            $conn = mysqli_connect($servername, $username, $password, $dbname);    // restart
                      
            
            $tags = mysqli_query($conn, $sqlFetchTags); // tag query

            mysqli_close($conn); // close connection
            $conn = mysqli_connect($servername, $username, $password, $dbname);    // restart

            $reviews = mysqli_query($conn, $sqlFetchReviews);
           
            $productData = array(
                "name" => $row['item_name'],
                "description" => $row['item_description'],
                "type" => $row['item_type'],
                "price" => $row['price'],
                "sold" => $row['amount_sold'],
                "print_duration" => $row['print_duration'],
                "delivery_price" => $row['delivery_price'],
                "filament_type" => $row['filament_type'],
                "rating" => $row['item_rating'],
                "author" => $row['full_name'],
                "author_rating" => $row['seller_rating']
                );   
            // Now handle only tags
            $tag_array = array();
            while($row = mysqli_fetch_assoc($tags))
            {
               array_push($tag_array,$row['tag']);  
            }
            // now handle only reviews 
            $review_array = array();
            while($row = mysqli_fetch_assoc($reviews) )
            {
                $temp_review = array(
                "review_user" => $row['full_name'],
                "review" => $row['review'],
                "timestamp" => $row['review_timestamp'],
                "score" => $row['reviewer_score']
                );
                array_push($review_array, $temp_review);
                unset( $temp_review);
                
            }
            $jsonReviews = json_encode($review_array);
        ?>

<script>


    // Populate page with data 
    jsonJsProduct = {
            "name" : <?php echo json_encode($productData["name"], JSON_HEX_TAG); ?>,
            "description" : <?php echo json_encode($productData["description"], JSON_HEX_TAG); ?>,
            "type" : <?php echo json_encode($productData["type"], JSON_HEX_TAG); ?>,
            "price" : <?php echo json_encode($productData["price"], JSON_HEX_TAG); ?>,
            "sold" : <?php echo json_encode($productData["sold"], JSON_HEX_TAG); ?>,
            "print_duration" : <?php echo json_encode($productData["print_duration"], JSON_HEX_TAG); ?>,
            "delivery_price" : <?php echo json_encode($productData["delivery_price"], JSON_HEX_TAG); ?>,
            "filament_type" : <?php echo json_encode($productData["filament_type"], JSON_HEX_TAG); ?>,
            "rating" : <?php echo json_encode($productData["rating"], JSON_HEX_TAG); ?>,
            "author" : <?php echo json_encode($productData["author"], JSON_HEX_TAG); ?>,
            "author_rating" : <?php echo json_encode($productData["author_rating"], JSON_HEX_TAG); ?>,
            "tags" : <?php echo json_encode($tag_array, JSON_HEX_TAG); ?>
        };   

    var jsonReviews = <?= $jsonReviews; ?>;
    console.log(jsonReviews);
    console.log(jsonJsProduct);

   appendData(jsonJsProduct);
   appendReview(jsonReviews);
</script>




<footer>
      <!-- jQuery pulls this -->
</footer>








</html>