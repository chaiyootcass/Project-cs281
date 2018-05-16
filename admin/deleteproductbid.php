<?php
session_start();
if (isset($_POST['Delete'])) {
    $oid = $_POST['Delete'];
    $_SESSION['de'] = $oid;
} else {
    $oid = $_SESSION['de'];
}
$name = $_SESSION['name'];
$msg = "";
$_SESSION["Order_to_finalize"] = $oid;
if (!isset($_SESSION['name'])) {
    header("location: ../admin.php");
    exit();
}
$color = array("active", "success", "info", "warning", "danger");
if (isset($_POST['submit'])) {
    $Err = 0;
    $idee = $_POST['submit'];
    $db = mysqli_connect('localhost', 'root', '', 'cd') or die('connection failed');
    if ($idee == 5) {
        $PID = $_SESSION['de'];
        $query = "DELETE from productbid where productId=$PID;";
        $result = mysqli_query($db, $query) or die("Delete Failed");
        $query = "DELETE from ordersbid where productId=$PID;";
        $result2 = mysqli_query($db, $query) or die("Delete Failed");
        if ($result && $result2) {
            // echo "<title> Deleted Product !</title>";
            $msg = $msg . "Deleted Successfully";
            echo "<form action='admin_productbid.php'><button action='admin_productbid.php'>Go Back</button></form>";
            //   echo "Deleted Successfully";
        }
        //$msg = $msg . "<form action='add_product_bid.php'><button action='add_product_bid.php'>Go Back</button></form>";
        // echo "<form action='add_product_bid.php'><button action='add_product_bid.php'>Go Back</button></form>";
    }
}
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <title>Admin Deleted Product
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
      <form method="POST" action="deleteproductbid.php">
        <table class="table" width="1000px" style="border-radius:10px; background: rgba(0,0,0,0.4)">
          <thead>
            <tr style="color: #ffffff">
            <th>Product Name</th>
          <th>Minimum Bid</th>
          <th>Maximum Bid</th>
          <th>Current Bid</th>
          <th>Description</th>
          <th>Stock</th>
          <th>Time Left</th>

            </tr>
          </thead>
          <tbody>
            <?php
include '../scripts/connect.php';
$query = "SELECT * FROM `productbid` where `productbid`.`productId`=$oid;";
$result = mysqli_query($con, $query);
if (!$result) {
    printf("Error: %s\n", mysqli_error($con));
    exit();
}
while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
    $id = $row['productName'];
    $productid = $row['minbid'];
    $user = $row['maxbid'];
    $amount = $row['currBid'];
    $quatity = $row['quantity'];
    $addr = $row['descp'];
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
              <?php
$d1 = date_create($row['expiry']);
    $d2 = date_create(date('d-m-Y'));

    $diff = date_diff($d2, $d1);

    if ($diff->format("%R%a") < 0) {
        echo '<td>Expired<td>';
        $row['productId'] = -1;
    } else if ($diff->format("%R%a") == 0) {
        echo '<td>Last Day<td>';
    } else {
        echo '<td>' . $diff->format("%a") . ' days left<td>';
    }

    ?>
            </tr>
            <?php
}

?>
          </tbody>
        </table>
        <button id='sumbit' type='submit' name='submit' value='5'>Delete</button>
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
