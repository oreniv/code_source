<?php 
include_once 'dbconnection.php';
?>

<!DOCTYPE html>
<html>

<script>
    
    
  function addDays(date, days) {

  var result = new Date(date);
  result.setDate(result.getDate() + days);
  
   return result;
}

    function appendData(profileData){
       
       document.getElementById("product_title").innerHTML = profileData["name"]+ " || "+"Rating: "+ profileData["rating"] ;
       document.getElementById("product_desc").innerHTML ="Description: " + profileData["description"];
       document.getElementById("price").innerHTML = profileData["price"]+" $";
       // document.getElementById("amount_sold").innerHTML = profileData["sold"];
     
       if(!profileData.print_duration) // if no duration specified it's digital probably 
         document.getElementById("print_duration").innerHTML = "User did not specify or this is a digital item";
       else
         document.getElementById("print_duration").innerHTML = "Delivery time: "+profileData["print_duration"]+" days";
       
         if(!profileData.delivery_price) // if no duration specified it's digital probably
         document.getElementById("delivery_price").innerHTML = "Free";
         else
            document.getElementById("delivery_price").innerHTML = profileData["delivery_price"]+ " $";
       
       
       
       // document.getElementById("filament_type").innerHTML = profileData["filament_type"];

       document.getElementById("author").innerHTML ="Author: " + profileData["author"] +" || "+" Rating: "+profileData["author_rating"];
       document.getElementById("tags").innerHTML = profileData["tags"];
    }


    </script>

<head>
    <meta charset="utf-8" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
    <link rel="stylesheet" href="styleSheet.css" />
    <title>Oray</title>



</head>


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


<body>


<div class="container">
    <div class="row">
        <div class="col-4">
        <img class="img-fluid" src="source/produits/project3.jpg">
        </div>
        <div class="col-8"> 
            <p class="product_page_text" id="product_title"></p>       
            <p class="product_page_text" id="author"></p> 
            <p class="product_page_text" id="product_desc"></p>  
            <p class="product_page_text" id="tags"></p>    
            <div class="row">
                <div class="col-6">
                <p class="product_page_text" id="delivery_price"></p>
                </div>
                <div class="col-6">
                <p class="product_page_text" id="print_duration"></p>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <p class="product_page_text" id="price"></p>
                </div>

            </div>
        </div>    
    </div>

</div>




    
    
    
    
    
    
    
    
    
            
</body>
    
    
    
    <?php 
            $sqlProductInfo ="CALL get_sales_item_page_info(64)";
            $sqlFetchTags = "CALL get_tags_for_post(64,'sales_item')";
            $sqlFetchReviews = "CALL get_post_reviews(64)";
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
</script>














</html>