<?php
$message = '';
if(isset($_GET["action"]))
{
 if($_GET["action"] == "delete")
 {
  $cookie_data = stripslashes($_COOKIE['shopping_cart']);
  $cart_data = json_decode($cookie_data, true);
  foreach($cart_data as $keys => $values)
  {
   if($cart_data[$keys]['item_id'] == $_GET["id"])
   {
    unset($cart_data[$keys]);
    $item_data = json_encode($cart_data);
    setcookie("shopping_cart", $item_data, time() + (86400 * 30));
    header("location:cart.php?remove=1");
   }
  }
 }
 if($_GET["action"] == "clear")
 {
  setcookie("shopping_cart", "", time() - 3600);
  header("location:cart.php?clearall=1");
 }
}

if(isset($_GET["success"]))
{
 $message = '
 <div class="alert alert-success alert-dismissible">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    Item Added into Cart
 </div>
 ';
}

if(isset($_GET["remove"]))
{
 $message = '
 <div class="alert alert-success alert-dismissible">
  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
  Item removed from Cart
 </div>
 ';
}
if(isset($_GET["clearall"]))
{
 $message = '
 <div class="alert alert-success alert-dismissible">
  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
  Your Shopping Cart has been clear...
 </div>
 ';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="ie=edge">
<meta name="Description" content="Enter your description here"/>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.0/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<link rel="stylesheet" href="assets/css/style.css">
<title>Title</title>
</head>
<body>
    <div class="container">
        <?php
                if(isset($_COOKIE["shopping_cart"])){
                    ?>
                <div class="table-responsive">
                <?php echo $message; ?>
                <div align="right">
                    <a href="cart.php?action=clear"><b>Clear Cart</b></a>
                </div>
                <table class="table table-bordered">
                    <tr>
                    <th width="40%">Item Name</th>
                    <th width="10%">Quantity</th>
                    <th width="20%">Price</th>
                    <th width="15%">Total</th>
                    <th width="5%">Action</th>
                    </tr>
                <?php
                if(isset($_COOKIE["shopping_cart"]))
                {
                    $total = 0;
                    $cookie_data = stripslashes($_COOKIE['shopping_cart']);
                    $cart_data = json_decode($cookie_data, true);
                    foreach($cart_data as $keys => $values)
                    {
                ?>
                    <tr>
                    <td><?php echo $values["item_name"]; ?></td>
                    <td><?php echo $values["item_quantity"]; ?></td>
                    <td>&#8377; <?php echo $values["item_price"]; ?></td>
                    <td>&#8377; <?php echo number_format($values["item_quantity"] * $values["item_price"], 2);?></td>
                    <td><a href="cart.php?action=delete&id=<?php echo $values["item_id"]; ?>"><span class="text-danger">Remove</span></a></td>
                    </tr>
                <?php 
                    $total = $total + ($values["item_quantity"] * $values["item_price"]);
                    }
                ?>
                    <tr>
                    <td colspan="3" align="right">Total</td>
                    <td align="right"><p>&#8377; <?php echo number_format($total, 2); ?></p></td>
                    <td></td>
                    </tr>
                <?php
                }
                else
                {
                    echo '
                    <tr>
                    <td colspan="5" align="center"><a href="index.php">Continue Shopping</a></td>
                    </tr>
                    ';
                }
                ?>
                </table>
                <a href="order.php" class="btn btn-primary">Place Order</a>
                </div>
                <?php

                }else{
                    ?>
                
                    <h4 class="text-center text-danger"><a href="menu.php">Continue Shopping</a></h4>
                    <?php
                }
                ?>
    </div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.1/umd/popper.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.0/js/bootstrap.min.js"></script>
</body>
</html>