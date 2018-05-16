<head>
  <title>
    Auction
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
<div id="cart" >
  <div class="label" style="margin-left:0px;margin-top: 541px;">
    <h3>Auction
    </h3>
  </div>

  <div id="cart_content">
    <table class="table" width="1000px" cellspacing="0" style="color: #ffffff; margin-top:60px;border-radius:10px; background: rgba(0,0,0,0.4)">
        <form method="POST" action="orderbid.php">
      <thead>
        <tr style="padding:80px; font-size:15px;">
          <th>Product Image</th>
          <th>Product Name</th>
          <th>Minimum Bid</th>
          <th>Current Bid</th>
          <th>Description</th>
          <th>Stock</th>
          <th>Seller</th>
          <th>Time Left</th>
        </tr>
      </thead>

      <tbody style="font-size: 15px;">
      <?php
include 'scripts/connect.php';
$query = "SELECT * FROM productbid;";
mysqli_query($con, $query);
$result = mysqli_query($con, $query);
while ($row = mysqli_fetch_array($result)) {
    $id = $row['productId'];
    echo '<tr>';
    echo '<td align="center"><img src="products/bid/' . $row['productName'] . '.jpg" height="60" width="60" alt="" style="border-radius: 5px; "/> </td>';
    echo '<td align="center" style="border-bottom: 1px white solid;">' . $row['productName'] . '</td>';
    echo '<td align="center" style="border-bottom: 1px white solid;">' . $row['minbid'] . '</td>';

    if ($row['currBid'] == 0) {
        echo '<td align="center" style="border-bottom: 1px white solid;">NEW</td>';
    } else {
        echo '<td align="center" style="border-bottom: 1px white solid;">' . $row['currBid'] . '</td>';
    }

    echo '<td align="center" style="border-bottom: 1px white solid;">' . $row['descp'] . '</td>';

    if ($row['quantity'] > 5) {
        echo '<td align="center" style="border-bottom: 1px white solid;">Available</td>';
    } else if ($row['quantity'] > 0) {
        echo '<td align="center" style="border-bottom: 1px white solid;">Few Left</td>';
    } else {
        echo '<td align="center" style="border-bottom: 1px white solid;">Out of Stock</td>';
    }

    echo '<td align="center" style="border-bottom: 1px white solid;"> admin </td>';

    $d1 = date_create($row['expiry']);
    $d2 = date_create(date('d-m-Y'));

    $diff = date_diff($d2, $d1);

    if ($diff->format("%R%a") < 0) {
        echo '<td align="center" style="border-bottom: 1px white solid;">Expired<td>';
        $row['productId'] = -1;
    } else if ($diff->format("%R%a") == 0) {
        echo '<td align="center" style="border-bottom: 1px white solid;">Last Day<td>';
    } else {
        echo '<td align="center" style="border-bottom: 1px white solid;">' . $diff->format("%a") . ' days left<td>';
    }

    $_SESSION['timeleft'] = $diff->format("%a");
    echo "<td> <button type='submit' name='NewBid' value=" . $id . ">Bid</button></td>";
    echo '</tr>';
}
?>
      </tbody>
    </table>
    </form>
  </div>
  <div class="cl">
  </div>
</div>
<div id="footer-push">
</div>
<?php include_once 'templates/footer.php';?>
