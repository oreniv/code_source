<?php
include_once 'dbconnection.php';
session_start();

if($_SESSION['userID'] == -1)
{
// NOTICE THE QUOTES AT THE EDGES OF THE STRINGS  

$productID = (int)$_SESSION['productID'];
$quantity = (int)$_POST['quantity'] ; 
$credit_card = (int)$_POST['credit_card'];
$full_name = "'".$_POST['full_name']."'";
$shipping_address = "'".$_POST['shipping_address']."'";
$buyer_email = "'".$_POST['buyer_email']."'";

$sqlPurchaseData = "CALL insert_transaction_history_anonymous($productID,$quantity,$credit_card,$full_name,$shipping_address,$buyer_email)";
if (!mysqli_query($conn,$sqlPurchaseData)) {
    echo("Error description: " . mysqli_error($conn));
    $_SESSION['db_error'] = True;
  }
else 
$_SESSION['db_error'] = False;
  
mysqli_close($conn);
die();
}
// Handle purchase for a registered user 


$sqlCheckCart = "SELECT sales_itemID,project_item_bidID FROM item_in_cart WHERE cartID =".$_SESSION['cartID'];
$query = mysqli_query($conn, $sqlCheckCart);

$sale_items = array();
$project_bids = array();


while($temp = mysqli_fetch_assoc($query))
{
    
    if ($temp['sales_itemID'] != NULL)// if i'm looking at a sales_item
    { 
        array_push($sale_items,(int)$temp['sales_itemID']);
        array_pop($_SESSION['items_in_cart'][0]);
        $_SESSION['cart_item_count']-- ;
    }
    else 
    {
        array_push($project_bids,(int)$temp['project_item_bidID']);
        array_pop($_SESSION['items_in_cart'][1]);
        $_SESSION['cart_item_count']-- ;
    }
    
} ; 

$arrSize = count($sale_items);
$amount = 0;
for ($i = 0;$i<$arrSize -1 ;$i++)
{
    if ($sale_items[$i] == -1 )
        continue;
    $amount = 0;
    for ($j = $i; $j < $arrSize && $sale_items[$i] != -1 ; $j++)
        {
            if ($sale_items[$i] ==  $sale_items[$j])
            {
                $amount++;
                if ($amount > 1)
                    $sale_items[$j] = -1;
            }
            
        }
    // db insertion for each item after calculating the amount 
    $sqlPurchaseData = "CALL insert_transaction_history(".$_SESSION['userID'].",".$sale_items[$i].",$amount,'sales_item')" ; 
    mysqli_query($conn,$sqlPurchaseData); 
    mysqli_close($conn);
    $conn = mysqli_connect($servername, $username, $password, $dbname);
    

}

$amount = 1;
if ($sale_items[$arrSize - 1] != -1 ) // check if the last item is unique 
    $sqlPurchaseData = "CALL insert_transaction_history(".$_SESSION['userID'].",".$sale_items[$arrSize - 1].",$amount,'sales_item')" ; 
mysqli_query($conn,$sqlPurchaseData); 
mysqli_close($conn);
$conn = mysqli_connect($servername, $username, $password, $dbname);


$arrSize = count($project_bids);
for ($i=0;$i<$arrSize;$i++)
{
    $sqlPurchaseData = "CALL insert_transaction_history(".$_SESSION['userID'].",".$project_bids[$i].",1,'bid')" ; 
    mysqli_query($conn,$sqlPurchaseData); 
    mysqli_close($conn);
    $conn = mysqli_connect($servername, $username, $password, $dbname);
}
