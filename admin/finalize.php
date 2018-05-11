<?php
session_start();
$oid = $_POST['Final'];
$name = $_SESSION['name'];
$msg = "";
$_SESSION["Order_to_finalize"] = $oid;
if (!isset($_SESSION['name'])) {
    header("location: ../admin.php");
    exit();
}
$i = 0;
$color = array("active", "success", "info", "warning", "danger");
if (isset($_POST['Final'])) {
    $Err = 0;
    $db = mysqli_connect('localhost', 'root', '', 'cd') or die('connection failed');
    $PID = $_SESSION["Product_to_finalize"];
    $Stat = $_SESSION["Sale_status"];
    $OID = $_SESSION["Order_to_finalize"];
    if ($Stat == 1) {
        $msg = $msg . "Order Already Completed<br>";
        //echo "Order Already Completed<br>";
        //echo "<title> Please Try Again !</title>";
    } else {
        $query = "SELECT amount,quantity from ordersbid where OrderId=$OID";
        $result = mysqli_query($db, $query) or die('No fetch Data');
        while ($row = mysqli_fetch_array($result)) {
            $qty = $row['quantity'];
            $amt = $row['amount'];
        }

        $query = "UPDATE ordersbid set status=1 where OrderId=$OID";
        $result = mysqli_query($db, $query) or die('Could not sell');

        $query = "UPDATE productbid set minbid=maxbid, maxbid=maxbid+$amt, currBid=0 where productId=$PID;";
        $result2 = mysqli_query($db, $query) or die('Could not Update');
        if ($result2 && $result) {
            //echo "<title> Success !</title>";
            $msg = "Successfully Sold and Updated";
            //echo "Successfully Sold and Updated";
        }
    }
    //echo "<form action='Seller_orders.php'><button action='Seller_orders.php'>Go Back</button></form>";

}
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
      <form method="POST" action="finalize.php">
        <table class="table" width="1000px" style="border-radius:10px; background: rgba(0,0,0,0.4)">
          <thead>
            <tr style="color: #ffffff">
                 <th>Order Id</th>
                <th>Product Id</th>
                <th>Buyer</th>
                 <th>Amount</th>
                 <th>Quantity</th>
              <th>Address</th>
                 <th>Status</th>
            </tr>
          </thead>
          <tbody>
            <?php
include '../scripts/connect.php';
$query = "SELECT * FROM ordersbid where OrderId=$oid;";
mysqli_query($con, $query);
$result = mysqli_query($con, $query);
while ($row = mysqli_fetch_array($result)) {
    $id = $row['OrderId'];
    $productid = $row['productId'];
    $user = $row['BuyerUsr'];
    $amount = $row['Amount'];
    $quatity = $row['Quantity'];
    $addr = $row['Address'];
    if ($row['status'] == 0) {
        $status = 'Not Sold';
    } else {
        $status = 'Sold ';
    }
    $_SESSION["Sale_status"] = $row['status'];
    $_SESSION["Product_to_finalize"] = $row['productId'];

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
                <?php echo $addr; ?>
              </td>
              <td>
                <?php echo $status; ?>
              </td>
            </tr>
            <?php
}
?>
          </tbody>
        </table>
        <button id='sumbit' type='submit' name='submit' value='6'>Finalize</button>
        </form>
        <td colspan="2" align="center">
                    <?php echo $msg ?>
        </td>
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

