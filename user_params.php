<?php

  session_start();

 if (!isset($_SESSION['userID'])) // check if the userID is already SET FOR THIS SESSION
 { 
    $_SESSION['userID'] = $_POST["userID"];  
       
 }

else if(!($_SESSION['full_name']) && isset($_SESSION['userID'])) 
{ 
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


} 


if ($_POST["kill_session"]) // if kill_session is returned true then kill the session
{
   
    session_unset();
    session_destroy();
    

}
 
// From now on when I want the userID call it with $_SESSION['userID'] 
/************************** */







