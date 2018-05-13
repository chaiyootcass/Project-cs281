<?php
session_start();
$name = 'gas';
if (!isset($_SESSION['name'])) {
    header("location: ../admin.php");
    exit();
}
$i = 0;
$color = array("active", "success", "info", "warning", "danger");
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <title>Admin Products bid
    </title>
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="style/style.css"/>
  </head>
  <body>
    <div id="main_wrapper">
      <div id="header">
        <?php include_once '../templates/admin_header.php';?>
        <a id="logout"href="admin_logout.php">
          <div class="btn btn-default logout">Logout
          </div>
        </a>
        <?php include_once '../templates/admin_nav.php';?>
      </div>
      <div class="messages">
      <form name='myproducts' method="POST" action="deleteproductbid.php" >
        <table class="table" width="1000px" style="border-radius:10px; background: rgba(0,0,0,0.4)">
          <thead>
            <tr style="color: #ffffff">
                <th>Product Id</th>
                <th>Product Name</th>
                <th>Minimum Bid</th>
                <th>Maximum Bid</th>
                <th>Current Bid</th>
                <th>Stock</th>
                <th>Description</th>
                <th>Time Left</th>
            </tr>
          </thead>
          <tbody>
            <?php
include '../scripts/connect.php';
$query = "SELECT * FROM productbid where sellerUsr='$name';";
$result = mysqli_query($con, $query);
while ($row = mysqli_fetch_array($result)) {
    $id = $row['productId'];
    $productname = $row['productName'];
    $min = $row['minbid'];
    $max = $row['maxbid'];
    $currbid = $row['currBid'];
    $quatity = $row['quantity'];
    $des = $row['descp'];
    $d1 = date_create($row['expiry']);
    $d2 = date_create(date('d-m-Y'));
    $diff = date_diff($d2, $d1);
    if ($diff->format("%R%a") < 0) {
        $diff = 'Expired';
        $row['productId'] = -1;
    } else if ($diff->format("%R%a") == 0) {
        $diff = 'Last Day';
    } else {
        $diff = $diff->format("%a") . ' days left';
    }

    ?>
            <tr class="<?php
$i++;
    echo $color[$i % 5]?>">
              <td>
                <?php echo $id; ?>
              </td>
              <td>
                <?php echo $productname; ?>
              </td>
              <td>
                <?php echo $min; ?>
              </td>
              <td>
                <?php echo $max; ?>
              </td>
              <td>
                <?php echo $currbid; ?>
              </td>
              <td>
                <?php echo $quatity; ?>
              </td>
              <td>
                <?php echo $des; ?>
              </td>
              <td>
                <?php echo $diff; ?>
              </td>
              <td> <?php
echo "<button type='submit' name='Delete' value=" . $row['productId'] . ">Delete</button>"
    ?></td>
            </tr>
            <?php
}
?>
          </tbody>
        </table>
</form>
      </div>
      <form method="post" action="admin_productbid.php">
        <select name='filter'>
         <option  value="ALL">All Orders</option>
         <option  value="Sat">Satisfied</option>
         <option  value="UnSat">Unsatisfied</option>
        </select>
        <input type="Submit" value='filter'>
        </form>
      <div class="messages">
      <form name='myorders' method="POST" action="finalize.php" >
        <table class="table" width="1000px" style="border-radius:10px; background: rgba(0,0,0,0.4)">
          <thead>
            <tr style="color: #ffffff">
                <th>Order Id</th>
                <th>Product Id</th>
                <th>Buyer Name</th>
                <th>Bid</th>
                <th>Quantity</th>
                <th>Address</th>
                <th>Status</th>
            </tr>
          </thead>
          <tbody>
            <?php
$filter = "";
if (isset($_POST['filter'])) {
    $filter = $_POST['filter'];
}

if ($filter == "ALL" || !isset($_POST['filter'])) {
    $query = "SELECT * FROM ordersbid where SellerUsr='$name';";
} else if ($filter == "MY") {
    $query = "SELECT * FROM productbid where SellerUsr='$name';";
} else if ($filter == "Sat") {
    $query = "SELECT * FROM ordersbid WHERE SellerUsr='$name' and status=1;";
} else if ($filter == "UnSat") {
    $query = "SELECT * FROM ordersbid WHERE SellerUsr='$name' and status=0;";
}
mysqli_query($con, $query) or die("Query Failed");
$result = mysqli_query($con, $query);
while ($row = mysqli_fetch_array($result)) {
    $id = $row['OrderId'];
    $productid = $row['productId'];
    $user = $row['BuyerUsr'];
    $amount = $row['Amount'];
    $quatity = $row['Quantity'];
    $address = $row['Address'];
    ?>
            <tr class="<?php
$i++;
    echo $color[$i % 5]?>">
              <td>
                <?php echo $id; ?>
              </td>
              <td>
                <?php echo $productid; ?>
              </td>
              <td>
                <?php echo $user; ?>
              </td>
              <td>
                <?php echo $amount; ?>
              </td>
              <td>
                <?php echo $quatity; ?>
              </td>
              <td>
                <?php echo $address; ?>
              </td>
              <?php
if ($row['status'] == 0) {
        echo '<td> Not Sold </td>';
    } else {
        echo '<td> Sold </td>';
    }
    echo "<td> <button id='submit' type='submit' name='Final' value=" . $row['OrderId'] . ">Finalize</button></td>";
    ?>

            </tr>
            <?php
$_SESSION["Sale_status"] = $row['status'];
    $_SESSION["Product_to_finalize"] = $row['productId'];
}
?>
          </tbody>
        </table>
      </div>
      </form>
    </div>
  </body>
</html>
<style type="text/css">
  .messages{
    margin: 20px;
  }
  #main_menu
  {
    width: 980px;
  }
</style>


