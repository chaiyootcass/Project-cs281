<head>
  <title>
    Shopping Cart
  </title>
  <link rel="stylesheet" href="css/cart_style.css"/>
</head>
<?php
session_start();
$i = 0;
$color = array("success", "error", "info", "warning");
if (!isset($_SESSION['id'])) {
    header("location: index.php");
    exit();
}
if (isset($_POST['cancelcart'])) { 

  $con = mysqli_connect("localhost", "root", "","cd"); 
  $mem_id = $_SESSION['id']; 

  $sql = "SELECT cart FROM cart WHERE mem_id = '$mem_id'"; 
  $run_query = mysqli_query($con,$sql); 
  $data = mysqli_fetch_assoc($run_query); 
  $data = $data["cart"]; 
  $token = explode(",",$data); 

  if(!is_array($token)) { 
    $token = array_push($token,$data); 
  } 

  foreach ($token as $key){ 

    $sql = "SELECT quantity FROM product WHERE id = '$key'"; 
    $run_query = mysqli_query($con,$sql); 
    $qty = mysqli_fetch_assoc($run_query); 
    $qty = $qty['quantity']; 

    $qty += 1; 

    $sql = "UPDATE product SET quantity = '$qty' WHERE id = '$key'"; 
    $run_query = mysqli_query($con,$sql); 
  } 

  $sql = "DELETE FROM cart WHERE mem_id = '$mem_id'"; 
  $run_query = mysqli_query($con,$sql); 

}

?>
<?php
include 'templates/header_top.php';
?>
<!-- Navigation -->
<?php
include 'templates/navigation.php';
?>
<!-- END Navigation -->
<!-- Including Slider... -->
<?php
include 'templates/slider.php';
?>
<!--slider end -->
<?php
include 'scripts/connect.php';
$user_id = $_SESSION['id'];
$sql = "SELECT cart.id,cart.cart,cart.mem_id,cart.quantity,cart.total FROM users JOIN cart ON users.id=cart.mem_id where users.id='$user_id'";
$cart = array();
$total = 0;
if ($query_run = mysqli_query($con, $sql)) {
    $row = mysqli_fetch_assoc($query_run);
    $con = mysqli_num_rows($query_run);
    if ($con == 1) {
        $id = $row['id'];
        $mem_id = $row['mem_id'];
        $carts = $row['cart'];
        $total = $row['total'];
        $carts = $carts . "";
        $_SESSION['total'] = $total;
        $cart = explode(",", $carts);
        $_SESSION['quantity'] = count($cart);
    } else {
        $carts = "You have a empty cart right now!";
    }
}
?>
<div id="cart" >
  <div class="label" style="margin-left:0px;margin-top: 510px;">
    <h3>Shopping Cart
    </h3>
  </div>
  <div class="cl">
  </div>
  <div id="cart_content">
    <table class="table" width="1000px" cellspacing="0" style="color: #ffffff; margin-top:60px;border-radius:10px; background: rgba(0,0,0,0.4)">
      <?php if ($total != 0) {?>
      <thead>
        <tr style="padding:80px; font-size:15px;">
          <th>Product
          </th>
          <th>Product Name
          </th>
          <th>Quantity
          </th>
          <th>Total
          </th>
        </tr>
      </thead>
      <?php }?>
      <tbody style="font-size: 15px;">
        <?php
include 'scripts/connect.php';
$sortedCart = array_count_values($cart);
foreach ($sortedCart as $value => $count) {
    $sql = "SELECT * FROM `product` where id='$value' LIMIT 1 ";
    if ($query_run = mysqli_query($con, $sql)) {
        while ($row = mysqli_fetch_assoc($query_run)) {
            $id = $row['id'];
            $product_name = $row['name'];
            $product_description = $row['description'];
            $product_price = $row['price'];
            $product_quantity = $row['quantity'];
            $status = $row['status'];
        }
    }
    if ($total != 0) {
        ?>
        <tr>
          <td align="center"  >
            <img src="products/<?php echo $id; ?>.jpg" height="40" width="40" alt="" style="border-radius: 5px; "/>
          </td>
          <td align="center" style="border-bottom: 1px white solid;">
            <?php echo $product_name; ?>
          </td>
          <td align="center" style="border-bottom: 1px white solid;">
            <?php echo $count; ?>
          </td>
          <td align="center"  style="border-bottom: 1px white solid;">
            <?php echo $count * $product_price; ?>
          </td>
        </tr>
        <?php
}
}
?>
        <tr>
          <td>
          </td>
          <td>
          </td>
          <td>
          </td>
          <td  align="center"  style="color:#026a84; margin-right: 10px;">
            <?php
$shipping = 0;
$vat = $total*0.07;

if ($total == 0) {
    echo "<h2 style='color: white; padding: 20px;'>" . $carts . "</h2>";
} else
{

  echo "sub-total =" . $total . "<br>";
  if($total >= 499)
  {
  $shipping = 0;
  }
  else
  {
  $shipping = 50;
  }
  $sum = $total+$vat+$shipping;
  echo "vat (7%) =";
  echo number_format($vat, 2, '.', '');
  echo "<br>";
  echo "Shipping  =" . $shipping . "<br>";
  echo "total     =";
  echo  number_format($sum, 2, '.', '');

}
?>
          </td>
        </tr>
        <tr>
          <td>
          </td>
          <td>
          </td>
          <td align="right" colspan="2" style="left: 100px;" >
            <?php
if ($total != 0) {?>
            <!-- ยกเลิกรายการทั้งหมด -->
    <form action="cart.php" method="post">
    <input type="submit" name="cancelcart" value="CancelCart"/>
    
</form>

            <br>
            <form action="checkout.php" method="post">
              <input type="submit" id="checkout" value="Checkout"/>
            </form>
            <?php }?>
          </td>
        </tr>
        <tr >
          <td style="padding-left: 10px; padding-bottom: 10px; ">
            <a style="color: white;" href="shop_history.php">View Shopping History
            </a>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
  <div class="cl">
  </div>
</div>
<div id="footer-push">
</div>
<?php include_once 'templates/footer.php';?>
