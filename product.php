<?php
session_start();
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
$id = "";
if (isset($_GET['id'])) {
    $id = preg_replace('#[^0-9]#i', '', $_GET['id']);
} else {
    header("location: index.php");
}
include_once 'scripts/connect.php';
$sql = "SELECT * FROM `product` where id='$id' LIMIT 1 ";
?>
<?php
$id = "";
$product_price = "";
if ($query_run = mysqli_query($con, $sql)) {
    while ($row = mysqli_fetch_assoc($query_run)) {
        $id = $row['id'];
        $product_name = $row['name'];
        $product_description = $row['description'];
        $product_price = $row['price'];
        $product_quantity = $row['quantity'];
        $status = $row['status'];
        $sales = $row['sales'];
    }
}
?>
<head>
  <title>
    <?php echo $product_name; ?>
  </title>
  <link rel="stylesheet" href="css/product_style.css"/>
</head>
<div class="middle">
  <div class="label" style="top:513px; left:0px; padding-bottom: 20px;">
    <?php if ($status == 0 && $product_quantity == 0) {
    ?>
    <h3>
      <?php echo $product_name; ?>(Out of Stock)
    </h3>
    <?php } else {
    ?>
    <h3>
      <?php echo $product_name; ?>
    </h3>
    <?php }?>
  </div>
  <div class="cl">
  </div>
  <br/>
  <table class="table" >
    <tr>
      <td style="padding-left:800px; " colspan="2" >Price:
        <?php echo $product_price; ?>
      </td>
    </tr>
    <tbody>
      <tr style="margin-bottom: 1px;">
        <td>
          <?php echo $product_description; ?>
        </td>
        <td>
          <img height="200" width="200" style="float:right; margin-bottom: 1px; border-radius: 10px;" src="products/<?php echo $id ?>.jpg" alt="<?php echo $product_name; ?>"/>
        </td>
      </tr>
      <tr style="padding: 0px;">
        <td>
        </td>
        <td colspan= align="right">
          <form action="add_to_cart.php" method="post" >
            <input type="hidden" name="product_id" value="<?php echo $id ?>"/>
            <input type="hidden" name="product_price" value="<?php echo $product_price; ?>"/>
            <input type="hidden" name="product_quantity" value="<?php echo $product_quantity; ?>"/>
            <input type="hidden" name="sales" value="<?php echo $sales; ?>"/>
            <?php if ($status == 0) {?>
            <input  disabled="disabled" type="submit" id="cart_btn" value="Add to cart"/>
            <?php } else {?>
            <input  type="submit" id="cart_btn" value="Add to cart"/>
            <?php }?>
          </form>
          <form action="favorite.php" method="post" >
            <input type="hidden" name="product_id" value="<?php echo $id ?>"/>
            <input type="hidden" name="product_quantity" value="<?php echo $product_quantity; ?>"/>
            <input  type="submit" id="cart_btn" value="Add to favorite"/>
          </form>
        </td>
      </tr>
    </tbody>
  </table>
  <div class="cl">
  </div>
</div>

<div class="middle">
  <div class="label" style="top:887px; left:0px; padding-bottom: 20px;">
    <h3>Reviews on Product
    </h3>
  </div>
  <div class="cl">
  </div>
  <?php
$sql = "SELECT * FROM reviews where product_id='$id'  ";
if ($query_run = mysqli_query($con, $sql)) {
    $row = mysqli_fetch_assoc($query_run);
    $con = mysqli_num_rows($query_run);
    ?>
  <table class="table_review" >
    <?php
if ($con == 0) {
        ?>
    <tr>
      <td>
        <br/>
        <br/>Be the first to write review for
        <?php echo $product_name; ?>
        <?php if (!isset($_SESSION['id'])) {
            echo "<h3>(Note: Please login to write a review!)</h3>";
        }
        ?>
        <br/>
      </td>
    </tr>
    <?php
} else {
        include 'scripts/connect.php';
        $query_run = mysqli_query($con, $sql);
        while ($row = mysqli_fetch_array($query_run)) {
            $user_name = $row['user_name'];
            $review_time = $row['review_date'];
            $review = $row['review'];
            ?>
    <tr>
      <td>
        <br/>
        <strong>
          <span style="font-size: 17px; color:#67b168; ">
            <?php echo $user_name; ?>
          </span>
        </strong> &nbsp;
        <?php echo $review_time; ?>
      </td>
    </tr>
    <tr>
      <td>
        <?php echo $review; ?>
      </td>
    </tr>
    <?php
}
    }
}
?>
    <?php
if (isset($_SESSION['id'])) {
    ?>
    <form action="review.php" method="post">
      <tr>
        <td>
          <textarea name="review" id="review" cols="60" rows="10">
          </textarea>
          <input type="hidden" name="p_id" value="<?php echo $id; ?>"/>
        </td>
      </tr>
      <tr>
        <td colspan="2">
          <input type="submit" value="Add a Review" id="btn"/>
        </td>
      </tr>
    </form>
    <?php
}
?>
    <tr>
      <td>
        <br/>
      </td>
    </tr>
  </table>
  <div class="cl">
  </div>
</div>
<div id="content">
        <!-- All Products -->
        <div class="products-holder">

            <div class="middle">
                <div class="label">
                    <h3>Products Suggest</h3>
                </div>
                <div class="cl"></div>
                <?php
include 'scripts/connect.php';
$sql = "SELECT * FROM `product` ORDER BY RAND() LIMIT 4";
if ($query_run = mysqli_query($con, $sql)) {
    while ($row = mysqli_fetch_assoc($query_run)) {
        $id = $row['id'];
        $product_name = $row['name'];
        $product_description = $row['description'];
        $product_price = $row['price'];
        $product_quantity = $row['quantity'];
        $status = $row['status'];
        ?>
                        <div class="product">
                            <a  title="Details" href="product.php?id=<?php echo $id; ?>"><img height="152" width="185" id="img" src="products/<?php echo $id ?>.jpg" alt="<?php echo $product_name; ?>" /></a>
                            <div class="desc">
                                <p class="name"><?php echo $product_name; ?></p>
                                <p>Status: <span>
                       <?php if ($status == 0) {
            echo "UnAvailable";} else {
            echo "Available";
        }?>
                    </span></p>
                                <p>Quantity: <span><?php echo $product_quantity ?></span></p>
                                <p>Product code: <span><?php echo $id ?></span></p>
                            </div>
                            <div class="price-box">
                                <p><span class="price">  <?php echo $product_price; ?></span></p>
                                <p class="per-piece">Per Piece</p>
                            </div>
                            <div class="cl"></div>
                        </div>


                    <?php }
}
?>


                <div class="cl"></div>
            </div>
        </div>
    </div>
<div id="footer-push">
</div>
<?php include_once 'templates/footer.php';?>