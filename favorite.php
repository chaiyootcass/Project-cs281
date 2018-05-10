<?php
session_start();
include 'scripts/connect.php';
if (isset($_POST['product_id'])) {
    $mem_id = $_SESSION['id'];
    $id = $_POST['product_id'];
    $id = preg_replace('#[^0-9]#i', '', $id);
    $product_price = preg_replace('#[^0-9]#i', '', $product_price);
    $sql = "SELECT * from `favorite` where user_id='$mem_id' LIMIT 1";
    if ($query_run = mysqli_query($con, $sql)) {
        $row = mysqli_fetch_assoc($query_run);
        $con = mysqli_num_rows($query_run);
        if ($con == 1) {
            $quantity = ($row['quantity']) + 1;
            $cart = $row['products'];
            $pro_quantity = ($_POST['product_quantity']);
            if ($pro_quantity > 0) {
                $pro_quantity--;
                $result2 = mysqli_query(mysqli_connect("localhost", "root", "", "cd"), "update `favorite` SET products='$cart,$id',quantity='$quantity' WHERE user_id='$mem_id' LIMIT 1");
            }
            header("location: favorite.php");
        } else {
            $pro_quantity = ($_POST['product_quantity']);
            if ($pro_quantity > 0) {
                $pro_quantity--;
                mysqli_query(mysqli_connect("localhost", "root", "", "cd"), "INSERT INTO `favorite` (`products`, `user_id`) VALUES ('$id', '$mem_id');");
            }
            header("location: favorite.php");
            exit();
        }
    }
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
include_once 'scripts/connect.php';
$user_id = $_SESSION['id'];
$sql = "SELECT favorite.id,favorite.products,favorite.user_id,favorite.quantity FROM users JOIN favorite ON users.id=favorite.user_id where users.id='$user_id'";
$cart = array();
if ($query_run = mysqli_query($con, $sql)) {
    $row = mysqli_fetch_assoc($query_run);
    $con = mysqli_num_rows($query_run);
    if ($con == 1) {
        $id = $row['id'];
        $mem_id = $row['user_id'];
        $carts = $row['products'];
        $carts = $carts . "";
        $cart = explode(",", $carts);
        $_SESSION['quantity'] = count($cart);
    } else {
        $carts = "You have a empty farvorite right now!";
    }
}
?>
<head>
  <title>
    Favorite
  </title>
</head>
<div id="farvoite" >
  <div class="label" style="margin-left:0px;margin-top: 510px;">
    <h3>Favorite
    </h3>
  </div>
  <div class="cl">
  </div>
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
    ?>
  <div class="product">
    <a  title="Details" href="product.php?id=<?php echo $id; ?>">
      <img height="152" width="185" id="img" src="products/<?php echo $id ?>.jpg" alt="<?php echo $product_name; ?>" />
    </a>
    <div class="desc">
      <p class="name">
        <?php echo $product_name; ?>
      </p>
      <p>Status:
        <span>
          <?php if ($status == 0) {
        echo "UnAvailable";} else {
        echo "Available";
    }?>
        </span>
      </p>
      <p>Quantity:
        <span>
          <?php echo $product_quantity ?>
        </span>
      </p>
      <p>Product code:
        <span>
          <?php echo $id ?>
        </span>
      </p>
    </div>
    <div class="price-box">
      <p>
        <span class="price">
          <?php echo $product_price; ?>
        </span>
      </p>
      <p class="per-peace">Per price
      </p>
    </div>
    <div class="cl">
    </div>
  </div>
  <?php
}
?>
</div>
<div class="cl">
</div>
</div>
<div id="footer-push">
</div>
<?php include_once 'templates/footer.php';?>
