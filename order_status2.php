<?php
session_start();
if (!isset($_SESSION['last_id'])) {
    header("location: filladdress.php");
    exit();
}
?>
<?php include_once 'templates/header_top.php';?>
<!-- Navigation -->
<?php
include 'templates/navigation.php';
?>
<!-- END Navigation -->
<?php
include 'scripts/connect.php';
$status_order = "WTF";
$last_id = $_SESSION['last_id'];
if (isset($_POST['full_name'])) {
    $full_name = $_POST['full_name'];
    $country = $_POST['country'];
    $city = $_POST['city'];
    $state = $_POST['state'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $zipcode = $_POST['zipcode'];



    // if ((!$carts)) {
    //     $status_order = "Sorry! You have an empty cart. Please add some item(s) to your cart!";
    // } else {
        include_once "scripts/connect.php";
      //  $sql = mysqli_query($con, "UPDATE orders(full_name,country,city,state,phone,address,zipcode) VALUES('$full_name','$country','$city','$state','$phone','$address','$zipcode') WHERE id = rrd_lastupdate");
    //    $sql = "UPDATE orders SET full_name='$full_name',country='$country',city='$city',state='$state',phone='$phone',address='$address',zipcode='$zipcode' WHERE id= 57";
        $sql = mysqli_query($con, "UPDATE orders2 SET full_name='$full_name',country='$country',city='$city',state='$state',phone='$phone',address='$address',zipcode='$zipcode' WHERE id = $last_id");
        // $sql = mysqli_query($con, "delete from cart where mem_id='$user_id'");
        $status_order = "Order Successfully placed!";
    // }
}
?>
<!-- Including Slider... -->
<?php
include 'templates/slider.php';
?>
<!--slider end -->
<div id="content">
  <div class="products-holder" style="background: rgba(0,0,0,.4); border-radius: 10px; width: 990px; margin: 0 auto;">
    <div class="middle"style="background: transparent">
      <div class="label">
        <h3>Order Status
        </h3>
      </div>
      <div class="cl">
      </div>
      <p style="margin-top: 15px; color: #ffffff;font-size: 16px; font-style: italic;">
        <?php echo $status_order;

        ?>
      </p>
    </div>
  </div>
</div>
<div id="footer-push">
</div>
