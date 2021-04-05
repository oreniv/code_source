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
         window.alert("I'm adding item number "+ <?=$_GET['productID']?> +" to my cart");
        
     
        <?php 
        if (isset($_POST['add_this_item_to_cart'])) // if page is called with set variable set then execute 
        {
       
        $sqlAddToCart = "CALL insert_into_cart(".$_SESSION['userID'].",".$_POST['add_this_item_to_cart'].",'sales_item')";
        $query = mysqli_query($conn,  $sqlAddToCart ); 
         
        array_push($_SESSION['items_in_cart'][0],(int)$_POST['add_this_item_to_cart']);  // push this item to cart so i don't need to ping db again
        $_SESSION['cart_item_count']++ ;  // update item counter on the fly 
        
        unset($_POST['add_this_item_to_cart']); // unset this variable so refreshing the page is possible without adding shit to cart

        mysqli_close($conn);
        $conn = mysqli_connect($servername, $username, $password, $dbname);
        }
        ?>

        var productID = <?=$_GET['productID']?> ;     
        var xhttp = new XMLHttpRequest(); // using AJAX 
           xhttp.open("POST","product_page.php",true); // call this page again with a POST variable that indicates which item to add to cart
           xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
           xhttp.send("add_this_item_to_cart="+productID); 
           location.reload(); // remove this when cart updates dynamically 
           
    }
 
    function buyNow()
    {
        window.alert("this doesn't work yet");
    }
 




     
    function appendData(profileData){
       
        var price = profileData["price"];
        var print_duration = profileData["print_duration"];
        var delivery_price = profileData["delivery_price"];

        /** Set product title,description,author and related tags **/
       document.getElementById("product_title").innerHTML = profileData["name"] + " ";
       document.getElementById("product_desc").innerHTML ="Description: " + profileData["description"];
       document.getElementById("author").innerHTML ="Posted by: " + profileData["author"] +" ";
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

        while(reviewData[review_count]) // build the review list 
      {
       var userName =  reviewData[review_count]["review_user"] ;
       var rText = reviewData[review_count]["review"];
       var score  = reviewData[review_count]["score"];
       var timeStamp = reviewData[review_count]["timestamp"];
       review_count++;            







       
   
       const reviewPost = document.createElement("div");
       reviewPost.classList.add("review_wrapper");
       reviewPost.classList.add("border");
       reviewPost.classList.add("border-3");
       const reviewUser = document.createElement("div");
       reviewUser.classList.add("col");
       reviewUser.classList.add("comment");
       reviewUser.classList.add("review_user");
       reviewUser.innerHTML = userName ; 
       const reviewRating = document.createElement("div");
       reviewRating.classList.add("col");
       reviewRating.classList.add("review_stars");
       reviewRating.innerHTML = score ; 
       const reviewText = document.createElement("div");
       reviewText.classList.add("col");
       reviewText.classList.add("review_text");
       reviewText.innerHTML = rText ;
      
       reviewPost.appendChild(reviewUser);
 
        for (i=0;i<score;i++) // build the stars according to the rating the user left
        {
            var star = document.createElement("span");
            star.classList.add("fa");
            star.classList.add("fa-star");
            star.classList.add("checked_star");
            reviewPost.appendChild(star);
        }
 
       reviewPost.appendChild(reviewText);
       reviewPost.appendChild(document.createElement("br"));
       reviewText.appendChild(document.createElement("br"));
       reviewText.appendChild(document.createTextNode("Posted on: "+timeStamp));
       document.getElementById("review_section").appendChild(reviewPost); 
       
           
    }
    }



    </script>





<head>
    <meta charset="utf-8" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
    <link rel="stylesheet" href="styleSheet.css" />
    <!-- import stylesheet for star icons -->
    <title>Oray</title>


    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script> 
    <!-- for icon support -->
    <script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script>

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
            <ul class="list-group">
                <li id="product_title" class="list-group-item fw-bold">Product title</li>
                <li id="author" class="list-group-item fw-bold">Author</li>
                <li id="product_desc" class="list-group-item">Description</li>
                <li id="tags"  class="list-group-item">Tags</li>
                <div class="row">
                    <div class="col-6 "><li id="print_duration" class="list-group-item">Print duration </li></div>
                    <div class="col-6 "><li id="delivery_price" class="list-group-item">Delivery price </li></div>
                </div>
                <li id="price"  class="list-group-item">Price</li>
            </ul>
        </div>
    </div>
</div>

<div class="container" id="review_section"></div>







   



 
    
    
            
</body>
    
    
    
    <?php 


 
        
            $productID = $_GET['productID'] ; // grab the product ID the user clicked on
            $sqlProductInfo ="CALL get_sales_item_page_info(".$productID.")";
            $sqlFetchTags = "CALL get_tags_for_post(".$productID.",'sales_item')";
            $sqlFetchReviews = "CALL get_post_reviews(".$productID.")";

       
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