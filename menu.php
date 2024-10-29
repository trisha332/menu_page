<?php require("config.php") ?>
<?php
if(isset($_POST["add_to_cart"]))
{
    if(isset($_COOKIE["shopping_cart"]))
    {
        $cookie_data = stripslashes($_COOKIE['shopping_cart']);

        $cart_data = json_decode($cookie_data, true);
    }
    else
    {
        $cart_data = array();
    }

    $item_id_list = array_column($cart_data, 'item_id');

    if(in_array($_POST["hidden_id"], $item_id_list))
    {
    foreach($cart_data as $keys => $values)
    {
    if($cart_data[$keys]["item_id"] == $_POST["hidden_id"])
    {
        $cart_data[$keys]["item_quantity"] = $cart_data[$keys]["item_quantity"] + $_POST["quantity"];
    }
    }
    }
    else
    {
    $item_array = array(
    'item_id'   => $_POST["hidden_id"],
    'item_name'   => $_POST["hidden_name"],
    'item_price'  => $_POST["hidden_price"],
    'item_quantity'  => $_POST["quantity"]
    );
    $cart_data[] = $item_array;
    }
    $item_data = json_encode($cart_data);
    setcookie('shopping_cart', $item_data, time() + (86400 * 30));
    header("location:cart.php?success=1");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restaurant Menu</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
</head>
<body>
    <?php
    require('../fixed_navber/index1.php');
    ?>

<!-- menu -->
 
    <div class="container">
        <h1>Our Menu</h1>
    </div>
    <?php
        $src="SELECT * FROM category";
        $rs=mysqli_query($con,$src)or die(mysqli_error($con));
        //echo mysqli_num_rows($rs); // show number of records in record set or database table
        ?>
    <div class="menu">
        <ul>
        <?php
            $i=0;
            while($rec=mysqli_fetch_assoc($rs)){
                if($i==0){
                    $cat_id=$rec['cat_id'];
                }
                ?>
                <a href="category.php?cat_id=<?php echo $rec['cat_id']?>"> <?php  echo $rec['cat_name']?></a>
                
                <?php
                $i++;
            }
            ?>
        </ul>
    </div>

    <?php
    $src="SELECT i.*, c.cat_name FROM item i INNER JOIN category c ON i.cat_id=c.cat_id WHERE i.cat_id=$cat_id";
    $rs=mysqli_query($con, $src) or die(mysqli_error($con));
    if(mysqli_num_rows($rs)>0){
        ?>
        <section id="starters" class="active">
        <h2></h2>
        <?php
        while($i_rec=mysqli_fetch_assoc($rs)){
         ?>
         <div class="menu-item">
            <h3><?php echo $i_rec['i_title'] ?></h3>
            <!-- <p>Fish Cutlets</p> -->
            <span><?php echo $i_rec['i_price'] ?></span>
           <div class="button">
           <form name="<?php echo $rec['i_title'] ?>" method="post">
                <input type="hidden" name="hidden_id" value="<?php echo $i_rec['i_id'] ?>">
                <input type="hidden" name="hidden_name" value="<?php echo $i_rec['i_title'] ?>">
                <input type="hidden" name="hidden_price" value="<?php echo $i_rec['i_price'] ?>">
                <input type="hidden" name="quantity" value="1">
                <input type="submit" name="add_to_cart" value="Add to Cart" class="btn btn-primary">
            </form>
             </div>
        </div>
         <?php
        }
        ?>
    </section>
        <?php
    }else{
        echo 'No Menu Item Found';
    }
    ?>
    

    
    <!-- footer -->

    <footer class="footer-distributed">
        <div class="footer-left">
            <h2>Soner <span>Hasel</span></h2>
       
        <p class="footer-links">
            <a href="../slider/index.php">Home</a>
            |
            <a href="../about us/index.php">About</a>
            |
            <a href="../contact us/index.php">Contact</a>
            
        </p>
        <p class="footer-company-name">Copyright © 2021 <strong>Soner Hasel</strong> All rights reserved </p>
    </div>
    <div class="footer-center">
        <div>
            <i class="fa fa-phone"></i>
            <p>+91 7501179463</p>
        </div>
        <div>
            <i class="fa fa-envelope"></i>
            <p><a href="#">sonerhasel78@gmail.com</a></p>
        </div>
        <div>
            <i class="fa fa-envelope"></i>
            <p><a href="#">facebook</a></p>
        </div>
        <div>
            <i class="fa fa-envelope"></i>
            <p><a href="#">instagram</a></p>
        </div>
        <div>
            <i class="fa fa-envelope"></i>
            <p><a href="#">Twiter</a></p>
        </div>
    </div>
        <div class="footer-right">
            <p class="footer-company-about">
               <span>About the company</span>
               <strong>Soner Hasel</strong> is authentic Bengali Restaurant where you can find authentic Bengali food item.</p>
            <!-- <div class="footer-icons">
                <li>
                    <a href="#"><i class="fa-brands fa-facebook"></i></a>
                    <a href="#"><i class="fa-brands fa-instagram"></i></a>
                </li>          

           

        </div> -->

        <div class="address"style="color:white"><br><b>address</b><br>
            <a href="#" style="color:white" > charabagan, near  dumdum metro station pin-700050;</a>
    </div>
    </div>
        
    </footer>

    <script src="script.js"></script>
</body>
</html