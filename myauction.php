<head>
  <title>
    Your Auction
  </title>
  <link rel="stylesheet" href="css/cart_style.css"/>
</head>
<?php
session_start();
$name = $_SESSION['name'];
$i = 0;
$color = array("success", "error", "info", "warning");
if (!isset($_SESSION['id'])) {
    header("location: index.php");
    exit();
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
?>
<div id="cart" >
  <div class="label" style="margin-left:0px;margin-top: 510px;">
    <h3>Your Auction
    </h3>
  </div>
  <div class="cl">
  </div>
  <div id="cart_content">
    <table class="table" width="1000px" cellspacing="0" style="color: #ffffff; margin-top:60px;border-radius:10px; background: rgba(0,0,0,0.4)">

      <thead>
        <tr style="padding:80px; font-size:15px;">
          <th>Order Id</th>
          <th>Product Id</th>
          <th>Seller Name</th>
          <th>Bid</th>
          <th>Quantity</th>
          <th>Address</th>
          <th>Status</th>
        </tr>
      </thead>
      <tbody style="font-size: 15px;">
      <?php
$db = mysqli_connect('localhost', 'root', '', 'cd') or die("connection failed");
$query = "SELECT * FROM ordersbid where BuyerUsr='$name';";
mysqli_query($db, $query) or die("Query Failed");
$result = mysqli_query($db, $query);
while ($row = mysqli_fetch_array($result)) {
    echo '<tr>';
    echo '<td align="center" style="border-bottom: 1px white solid;">' . $row['OrderId'] . '</td>';
    echo '<td align="center" style="border-bottom: 1px white solid;">' . $row['productId'] . '</td>';
    echo '<td align="center" style="border-bottom: 1px white solid;">' . $row['SellerUsr'] . '</td>';
    echo '<td align="center" style="border-bottom: 1px white solid;">' . $row['Amount'] . '</td>';
    echo '<td align="center" style="border-bottom: 1px white solid;">' . $row['Quantity'] . '</td>';
    echo '<td align="center" style="border-bottom: 1px white solid;">' . $row['Address'] . '</td>';
    if ($row['status'] == 0) {
        echo '<td style="border-bottom: 1px white solid;" align="center"> Not Confirmed </td>';
    } else {
        echo '<td style="border-bottom: 1px white solid;" align="center"> Confirmed </td>';
    }
    echo '</tr>';
}
mysqli_close($db);
?>
      </tbody>
    </table>
  </div>
  <div class="cl">
  </div>
</div>
<div id="footer-push">
</div>
<?php include_once 'templates/footer.php';?>