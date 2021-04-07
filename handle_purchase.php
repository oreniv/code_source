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
  }
  mysqli_close($conn);
}