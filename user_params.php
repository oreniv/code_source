<?php
 include_once 'dbconnection.php';
session_start();

 

if ($_POST['register'] == true)
{
    
    
 
    $sqlInsertUser = "CALL insert_user(".
    "'".$_POST["full_name"]."'".",".
    "'".$_POST["email"]."'".",".
    "'".$_POST["birthday"]."'".",".
    "'".$_POST["password"]."'".",".
    "'".$_POST["profile_pic"]."'".",".
    (int)$_POST["payment_details"].",".
    "'".$_POST["address"]."'".")";
   
   if (mysqli_query($conn, $sqlInsertUser)) {
        echo "New record created successfully";
        $_POST['login_req'] = true ; 
        
        } else {
          echo "Error: " . $sql . "<br>"  . mysqli_error($conn);
        }

        mysqli_close($conn);
        $conn = mysqli_connect($servername, $username, $password, $dbname);

       
       header("Location:index.php");
        
}

if ($_POST['login_req'] == true)
{
    
    $sqlValidateUser = "SELECT users.id
                        FROM users
                        WHERE users.email = "."'".$_POST['email']."'"."AND users.passwd = "."'".$_POST['password']."'" ; 
   
    $result =  mysqli_query($conn,$sqlValidateUser);
    $result = mysqli_fetch_assoc($result)['id'] ;

    if ($result != NULL)
        $_POST["userID"] = (int)$result;
    else 
        $_POST["userID"] = -1 ;
     
     header("Location:index.php");
}


if (isset($_POST["userID"]) && $_POST["userID"] != -1  )    // check if the userID is already SET FOR THIS SESSION
 { 
    $_SESSION['userID'] = (int)$_POST["userID"];  
   
    
    // execute only if i don't know the user name AND I DO HAVE a userID
    // fetch the full_name of logged in user 
    
    // get the user name 
    $sqlLoggedInUser = "SELECT users.full_name FROM users WHERE users.id =".$_SESSION['userID']; 
    $uNameQuery = mysqli_query($conn,  $sqlLoggedInUser);
    $temp = mysqli_fetch_assoc($uNameQuery);
    $_SESSION['full_name'] = $temp['full_name']; 
    // get the user cart ID 
    $sqlMyCartID = "SELECT cart.id FROM cart WHERE cart.buyerID=".$_SESSION['userID'];
    $uCartIDQuery = mysqli_query($conn,$sqlMyCartID);
    $temp = mysqli_fetch_assoc($uCartIDQuery);
    $_SESSION['cartID'] = $temp['id'];
    
    // get the item IDs of sales_items in cart
    $sql_item_in_my_cart = "SELECT item_in_cart.sales_itemID,item_in_cart.project_item_bidID FROM item_in_cart  WHERE item_in_cart.cartID =".$_SESSION['cartID'];
    $uCartContentQuery =  mysqli_query($conn,$sql_item_in_my_cart);     
    
    $cartItem_array = array();
    $sale_items = array();
    $project_bids = array();
    
    
    while($temp = mysqli_fetch_assoc($uCartContentQuery))
    {
        if ($temp['sales_itemID'] != NULL)// if i'm looking at a sales_item
        { 
            array_push($sale_items,(int)$temp['sales_itemID']);
                
        }
        else 
        {
            array_push($project_bids,(int)$temp['project_item_bidID']);
            
        }


        
    }
    
    array_push($cartItem_array,$sale_items);
    array_push($cartItem_array,$project_bids);
     
     $_SESSION['items_in_cart'] = $cartItem_array; // 2D array of all items in cart
     $_SESSION['cart_item_count'] = count($sale_items) + count($project_bids);
die();
} 
 else if (!isset($_SESSION['userID']))
    {
        $_SESSION['userID'] = -1 ;
        $_SESSION['cart_item_count'] = 0;
        die();
    }



if ($_POST["kill_session"]) // if kill_session is returned true then kill the session
{
   
    session_unset();
    session_destroy();
    header("Location:index.php");
    
}
 
// From now on when I want the userID call it with $_SESSION['userID'] 
/************************** */







