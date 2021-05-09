<?php
include_once 'dbconnection.php';
session_start();
?>

<!DOCTYPE html>
<html>
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


<?php



if(isset($_POST['delete_item'])) // if user wants to delete an item 
{
 
  if ($_POST['item_type'] == "sales_item")
  {
    $sql_delete_sales_item_from_cart = "DELETE FROM item_in_cart WHERE
    cartID =".$_SESSION['cartID']." AND sales_itemID = ".$_POST['delete_item']." LIMIT 1 ; " ; 
    mysqli_query($conn,$sql_delete_sales_item_from_cart);    
    $temp = array_search($_POST['delete_item'] ,$_SESSION['items_in_cart'][0] ); // get the index of the deleted element
    $_SESSION['items_in_cart'][0][$temp] = -1; // set id as -1 for deleted items 
    $_SESSION['cart_item_count'] -= 1 ; // remove the item from the cart count  
  }

  else 
  {
    $sql_delete_project_bid_from_cart = "DELETE FROM item_in_cart WHERE
    cartID =".$_SESSION['cartID']." AND project_item_bidID = ".$_POST['delete_item']." LIMIT 1 ; " ; 
    mysqli_query($conn,$sql_delete_project_bid_from_cart);    
    $temp = array_search($_POST['delete_item'] ,$_SESSION['items_in_cart'][1] ); // get the index of the deleted element
    $_SESSION['items_in_cart'][1][$temp] = -1; // set id as -1 for deleted items 
    $_SESSION['cart_item_count'] -= 1 ; // remove the item from the cart count  
  }

}

  
  $sql_get_sales_item_info_for_cart = "SELECT item_name,price,delivery_price,item_pic_link FROM sales_item WHERE id =";  
  $sql_get_project_item_bid_info_for_cart ="SELECT project_item_bids.* ,project_item.part_pic,project_item.item_description,project.id AS 'parent_project_ID' FROM project_item_bids
  INNER JOIN project_item ON project_item.id = project_item_bids.project_itemID
  INNER JOIN project ON project.id = project_item.projectID
  WHERE project_item_bids.id ="; 


  
  $i = 0;
  while ($_SESSION['items_in_cart'][0][$i] == -1) // keep looping until itemID is not -1 
    $i = $i + 1;

  $result =  mysqli_query($conn,$sql_get_sales_item_info_for_cart.$_SESSION['items_in_cart'][0][$i]); 

  $sale_items = array();
  while($result != FALSE  &&  $temp = mysqli_fetch_assoc($result))
  {

      $tempArr = array (
          "Item_name" => $temp['item_name'],
          "price" => $temp['price'],
          "delivery_price" => $temp['delivery_price'],
          "pic_link" => $temp['item_pic_link'],
          "item_id" => $_SESSION['items_in_cart'][0][$i]
      );
        array_push($sale_items, $tempArr); 
        unset($tempArr);
        $i = $i + 1 ;
        while ($_SESSION['items_in_cart'][0][$i] == -1)
            $i = $i + 1;
  
      $result =  mysqli_query($conn,$sql_get_sales_item_info_for_cart.$_SESSION['items_in_cart'][0][$i]); 
    
    
  }
 


// now handle project bids



  $i = 0;

  while ($_SESSION['items_in_cart'][1][$i] == -1) // keep looping until itemID is not -1 
    $i = $i + 1;

  $result =  mysqli_query($conn,$sql_get_project_item_bid_info_for_cart.$_SESSION['items_in_cart'][1][$i]); 
  
  $project_items = array();
  while($result != FALSE  &&  $temp = mysqli_fetch_assoc($result))
  {
      $tempArr = array (
          "item_id" => $temp['id'],
          "price" => $temp['price'],
          "note" => $temp['note'],
          "parent_project_id" => $temp['parent_project_ID'],
          "part_pic" => $temp['part_pic'],
          "item_desc" => $temp['item_description']
      );

       array_push($project_items, $tempArr); 
       
       unset($tempArr);

       $i = $i + 1 ;
       while ($_SESSION['items_in_cart'][1][$i] == -1)
          $i = $i + 1;
     
      $result =  mysqli_query($conn,$sql_get_project_item_bid_info_for_cart.$_SESSION['items_in_cart'][1][$i]); 
      
  }
 

  $jsonSales_items =  json_encode($sale_items);
  $jsonProject_bids =  json_encode($project_items);
   

?>



<script>

var sales_items = <?= $jsonSales_items  ?>; 
var project_bids = <?=  $jsonProject_bids  ?>; 
var sales_size =  sales_items.length ; 
var project_bid_size = project_bids.length;
var rowNumber = 0;
var total = 0;

function build_sales_table()
{
  if (sales_size > 0)
    setAmount();
 
  
  for (i = 0 ; i< sales_size; i++)
  {
    if ( sales_items[i]['item_id'] == -1 )
        continue;
  rowNumber ++;
  var tableRow =  document.createElement("tr");
  var tableRowHeader = document.createElement("th");
  tableRowHeader.setAttribute("scope","row");
  tableRowHeader.innerHTML = rowNumber ;
  var picColumn = document.createElement("tr");
  var itemName = document.createElement("td");
  var price = document.createElement("td");
  var link = document.createElement("td");
  var button = document.createElement("button");
  button.setAttribute("class","btn btn-outline-danger btn-sm");
  button.setAttribute("type","button");
  button.innerHTML = "Remove from cart";
  var amount = document.createElement("td");
  amount.innerHTML = sales_items[i]['amount'];
  var picture = document.createElement("img");
  picture.setAttribute("class","img-thumbnail rounded");
  picture.setAttribute("style","border:1px solid #ddd; border-radius:4px; padding:5px ; width: 150px;")
  var firstImage = sales_items[i]['pic_link'].split(",")
  picture.src = firstImage[0];
  picColumn.appendChild(picture);

  removeFromCart(button,sales_items[i]['item_id'],"sales_item");



  link.innerHTML = "<a href=product_page.php?productID="+sales_items[i]['item_id']+">Go to item page</a>" ; 

  itemName.innerHTML = sales_items[i]['Item_name'];
  price.innerHTML = "$"+(sales_items[i]['price'] * sales_items[i]['amount']) +" + Delivery fee: $" + sales_items[i]['delivery_price'] ;
  total += Number((sales_items[i]['price'] * sales_items[i]['amount'])) + Number((sales_items[i]['delivery_price']));

  tableRow.appendChild(tableRowHeader);
  tableRow.appendChild(picColumn);
  tableRow.appendChild(itemName);
  tableRow.appendChild(price);
  tableRow.appendChild(amount);
  tableRow.appendChild(link);
  tableRow.appendChild(button);

  document.getElementById("cart_table").appendChild(tableRow);
  }


}

function build_project_table()
{  
  for (i=0;i<project_bid_size;i++)
  {
    if ( project_bids[i]['item_id'] == -1 )
        continue; 
  
  rowNumber ++;
  var tableRow =  document.createElement("tr");
  var tableRowHeader = document.createElement("th");
  tableRowHeader.setAttribute("scope","row");
  tableRowHeader.innerHTML = rowNumber ;
  var picColumn = document.createElement("tr");
  var itemName = document.createElement("td");
  var price = document.createElement("td");
  var link = document.createElement("td");
  var button = document.createElement("button");
  button.setAttribute("class","btn btn-outline-danger btn-sm");
  button.setAttribute("type","button");
  button.innerHTML = "Remove from cart";
  var amount = document.createElement("td");
  amount.innerHTML = 1;

  var picture = document.createElement("img");
  picture.setAttribute("class","img-thumbnail rounded");
  picture.setAttribute("style","border:1px solid #ddd; border-radius:4px; padding:5px ; width: 150px;");
  var firstImage =  project_bids[i]['part_pic'].split(",")
  picture.src = firstImage[0];
  picColumn.appendChild(picture);
  removeFromCart(button,project_bids[i]['item_id'],"project_bid");
  link.innerHTML = "<a href=project_page.php?projectID="+project_bids[i]['parent_project_id']+">Go to project page</a>" ; 
  itemName.innerHTML = project_bids[i]['item_desc'];
  price.innerHTML = "$"+project_bids[i]['price'] ;
  
  total += Number(project_bids[i]['price']);

  tableRow.appendChild(tableRowHeader);
  tableRow.appendChild(picColumn);
  tableRow.appendChild(itemName); 
  tableRow.appendChild(price);
  tableRow.appendChild(amount);
  tableRow.appendChild(link);
  tableRow.appendChild(button);

  document.getElementById("cart_table").appendChild(tableRow);

   
  }
  
  if (rowNumber == 0) // write something if cart is empty 
  {
    
     var text = document.createElement("p");
    text.setAttribute("class","fs-1");
    text.innerHTML ="Cart is empty ";   
    document.getElementById("cart_table").innerHTML = text.innerHTML;
    
  }

}

function setAmount()
{
 
  var amount = 0;
  for (i=0 ; i < sales_size - 1; i++)
  {
    for (j = i;j<sales_size && sales_items[i]['item_id'] != -1 ;j++)
    {
      if (sales_items[i]['item_id'] == sales_items[j]['item_id'] )
      {
        amount++ ; 
        if (amount > 1)
          sales_items[j]['item_id'] = -1;

      }
    } 
    sales_items[i]['amount'] = amount ; 
    amount = 0;
  }
  if (sales_items[sales_size -1 ]['item_id'] != -1 ) // check the last element in case it's unique
        sales_items[sales_size -1 ]['amount'] = 1; // if it's unique set the amount to 1 



}

function removeFromCart(button,id,type)
{
  button.onclick = function()
  {
    document.getElementById("delete_item").setAttribute("value",id);
    document.getElementById("item_type").setAttribute("value",type);
    document.getElementById("deletion_form").submit();
    document.getElementById("deletion_form").reset();
  };
}

function preFillForm()
{

  var full_name = <?=  json_encode($_SESSION['full_name'])  ?> ; 
  var email = <?= json_encode($_SESSION['email'])  ?> ; 
  var address = <?= json_encode($_SESSION['address']) ?> ; 

  document.getElementById("full_name").setAttribute("value",full_name);
  document.getElementById("buyer_email").setAttribute("value",email);
  document.getElementById("shipping_address").innerHTML = address ;

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
        
        window.alert("Thank you for your purchase! \nGo to your profile page to view more details");
        window.location.assign("index.php");
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
        if (sales_size == 0 && project_bid_size == 0)
        {
        window.alert("Your cart is empty, can't buy nothing");
        window.location.assign("checkout.php");
        return false;
        }
 
        return true;

    }

</script>


<script>
$(document).ready(function(){
   $(".header_class").load("header.php");
   $("footer").load("footer.html");
 });
</script>


<header class="header_class"> 
     <!-- Header is loaded with jQuery -->
</header>

<div class="container">
  <div class="row ">

  <table class="table table-bordered">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col"></th>
      <th scope="col">Item</th>
      <th scope="col">Price + shipping</th>
      <th scope="col">Amount</th>
      <th scope="col"></th>
    </tr>
  </thead>
  <tbody id="cart_table">
    <tr>
    </tr>
  </tbody>

</table>







<!-- hidden form for db deletions -->
<form id="deletion_form" hidden method="POST" action="checkout.php" >
<input type="hidden" id="delete_item" name="delete_item" >
<input type="hidden" id="item_type" name="item_type">
</form>


<div class="container">
  <div class="row">
    <div class="col">
    </div>
    <div class="col">
    </div>
    <div class="col-7">
    <button type="button" data-bs-toggle="modal" data-bs-target="#buy_now_modal" class="btn btn-success w-45 ">Proceed to payment --></button>
    </div>
  </div>
</div>
</div>
  </div>
</div>






<!-- Modal window -->

<div id="buy_now_modal" class="modal fade" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Payment details</h5>
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















           
<footer> 
        <!-- jQuery pulls this -->
</footer>


<script>

build_sales_table();
build_project_table();
preFillForm();
</script>


















</html>