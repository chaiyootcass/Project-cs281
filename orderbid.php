<head>
  <title>
    Order bid product
  </title>
  <link rel="stylesheet" href="css/cart_style.css"/>
  <link rel="stylesheet" href="style/style.css"/>
  <link rel="stylesheet" href="style/forms.css"/>
</head>
<?php
session_start();
$db = mysqli_connect('localhost', 'root', '', 'cd') or die("connection failed");
$name = $_SESSION['name'];
$i = 0;
$msg = "";
$time = $_SESSION['timeleft'];
if (isset($_POST['NewBid'])) {
    $pId = $_POST['NewBid'];
} else {
    $pId = $_SESSION['pid'];
}
$Err = 0;
$color = array("success", "error", "info", "warning");
if (!isset($_SESSION['id'])) {
    header("location: index.php");
    exit();
}
if (isset($_POST['submit'])) {
    $idee = $_POST['submit'];
    if ($idee == 4) {
        $Bid = $Quantity = 0;
        if ($_POST['Bid'] != "") {
            if ($_SESSION['CB'] != null && $_SESSION['CB'] >= $_POST['Bid']) {
                $msg = $msg . "Enter Bid Greater than Current Bid<br>";
                //echo "Enter Bid Greater than Current Bid<br>";
                $Err++;
            } else if ($_SESSION['MinBid'] > $_POST['Bid']) {
                $msg = $msg . "Enter Bid Greater than Minimum Bid<br>";
                //echo "Enter Bid Greater than Minimum Bid<br>";
                $Err++;
            } else {
                $Bid = (float) $_POST['Bid'];
            }
        } else {
            $msg = $msg . "Enter your bid amount<br>";
            // echo "Enter your bid amount<br>";
            $Err++;
        }

        if ($_POST['Qty'] != "" && $_POST['Qty'] > '0') {
            if ((int) $_SESSION['Q'] < (int) $_POST['Qty']) {
                $msg = $msg . "Please Enter Quantity Lesser than " . $_SESSION['Q'] . "<br>";
                // echo "Please Enter Quantity Lesser than " . $_SESSION['Q'] . "<br>";
                $Err++;
            } else {
                $Quantity = (int) $_POST['Qty'];
            }
        } else {
            $msg = $msg . "Enter Valid Quantity<br>";
            // echo "Enter Valid Quantity<br>";
            $Err++;
        }

        if ($_POST['addr'] != "") {
            $address = $_POST['addr'];
        } else {
            $msg = $msg . "Enter Address<br>";
            //echo "Enter Address<br>";
        }
        if ($Err == 0) {
            $status = 0;
            if ($Bid > $_SESSION['MB']) {
                //echo "<title> Order Confirmed! </title>";
                $msg = $msg . "Congrats! You are the final Bidder<br>Order Confirmed<br>";
                //echo "Congrats! You are the final Bidder<br>Order Confirmed<br>";
                $status = 1;
            }
            $max = "SELECT MAX(OrderId) as \"lastId\" from ordersbid ";
            $max = mysqli_query($db, $max) or die("query failed");
            $max = mysqli_fetch_array($max);
            $max = $max['lastId'] + 1;

            $seller = $_SESSION['name'];
            $Pid = $_SESSION['pid'];

            $query = "INSERT into ordersbid VALUES($max,'$name','gas',$Bid,'$address',$Pid,$Quantity,$status);";
            $result = mysqli_query($db, $query) or die("could not add");
            //$updateQ = "update productbid set quantity=quantity-$Quantity,currBid=$Bid where productId=$Pid;";
            $updateQ = "update productbid set currBid=$Bid where productId=$Pid;";
            $result2 = mysqli_query($db, $updateQ) or die('Could not update');
            if ($result && $result2) {
                //echo "<title> Successfully Added Product</title>";
                if ($status != 1) {
                    $msg = $msg . "Successfully Added Product<br>";
                    $msg = $msg . "Please Comeback later to check Status";
                    //echo "Successfully Added Product<br>";
                    //echo "Please Comeback later to check Status";
                }
            }
        } else {
            //echo "<title> Failed to Bid</title>";
            $msg = $msg . "Failed to Bid . Try Again";
            //echo "Failed to Bid . Try Again";
        }
        //$msg = $msg . "<form action='Listings.php'><button action='Listings.php'>Go Back</button></form>";
        //echo "<form action='Listings.php'><button action='Listings.php'>Go Back</button></form>";
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
<div id="cart" >
  <div class="label" style="margin-left:0px;margin-top: 542px;">
    <h3>Auction
    </h3>
  </div>
  <div class="cl">
  </div>
  <div id="cart_content">
    <table class="table" width="1000px" cellspacing="0" style="color: #ffffff; margin-top:60px;border-radius:10px; background: rgba(0,0,0,0.4)">
        <form method="get" action="orderbid.php">
      <thead>
        <tr style="padding:80px; font-size:15px;">
          <th>Product Image</th>
          <th>Product Name</th>
          <th>Minimum Bid</th>
          <th>Current Bid</th>
          <th>Description</th>
          <th>Stock</th>
          <th>Seller</th>
        </tr>
      </thead>

      <tbody style="font-size: 15px;">
      <?php
include 'scripts/connect.php';
$query = "SELECT * FROM productbid where productId=$pId;";
$result = mysqli_query($con, $query);
while ($row = mysqli_fetch_array($result)) {
    echo '<tr>';
    echo '<td align="center"><img src="products/bid/' . $row['productName'] . '.jpg" height="60" width="60" alt="" style="border-radius: 5px; "/> </td>';
    echo '<td align="center" style="border-bottom: 1px white solid;">' . $row['productName'] . '</td>';
    echo '<td align="center" style="border-bottom: 1px white solid;">' . $row['minbid'] . '</td>';

    if ($row['currBid'] == 0) {
        echo '<td align="center" style="border-bottom: 1px white solid;">NEW</td>';
    } else {
        echo '<td align="center" style="border-bottom: 1px white solid;">' . $row['currBid'] . '</td>';
    }

    $_SESSION['CB'] = $row['currBid'];
    $_SESSION['MB'] = $row['maxbid'];
    $_SESSION['MinBid'] = $row['minbid'];
    $_SESSION['Q'] = $row['quantity'];

    echo '<td align="center" style="border-bottom: 1px white solid;">' . $row['descp'] . '</td>';

    if ($row['quantity'] > 5) {
        echo '<td align="center" style="border-bottom: 1px white solid;">Available</td>';
    } else if ($row['quantity'] > 0) {
        echo '<td align="center" style="border-bottom: 1px white solid;">Few Left</td>';
    } else {
        echo '<td align="center" style="border-bottom: 1px white solid;">Out of Stock</td>';
    }

    echo '<td align="center" style="border-bottom: 1px white solid;">' . $row['sellerUsr'] . '</td>';
    $_SESSION['Seller'] = $row['sellerUsr'];
    $_SESSION['pid'] = $row['productId'];

}
?>
        </tr>
      </tbody>
    </table>
    </form>
  </div>
</div>

<div id="content">
    <div class="products-holder" style="background: rgba(0,0,0,.4); border-radius: 10px;  width: 950px; margin: 0 auto;">

        <div class="middle" style="background: transparent">
            <div class="label">
                <h3>Add a new Bid Product</h3>
            </div>
            <div class="cl"></div>
        </div><table width="100%" cellpadding="5" cellspacing="5" border="0" style="color:white;">
            <tr>
            <form action="orderbid.php" enctype="multipart/form-data" method="POST">
            <table cellpadding="5" cellspacing="5" border="0" style="color:white;">
                <tr>
                    <td align="right"><label>Enter your Bid:</label></td>
                    <td align="left"><input autofocus type="text" name="Bid" placeholder="Enter your Bid..." class="text_input add" maxlength="100"/></td>
                </tr>
                <tr>
                    <td align="right"><label>Enter Quantity:</label></td>
                    <td align="left"><input autofocus type="text" name="Qty" placeholder="Enter Quantity..." class="text_input add" maxlength="100"/></td>
                </tr>
                <tr>
                    <td align="right"><label>Enter Address:</label></td>
                    <td align="left"><Textarea  style="height: 80px; width: 300px;padding: 5px;resize: none;" name="addr" placeholder="Enter address..." class="text_input add" ></textarea></td>
                </tr>
                <tr>
                    <td align="right"><label>Enter Quantity:</label></td>
                    <td align="left"><input type='radio' checked>Payment-Transfer</td>
                </tr>
                <tr >
                    <td  colspan="2" align="center">
                    <input type='hidden' name='pid' value='<?php $pId?>'>
                        <button type='submit' name='submit' value='4'>Place Bid</button>
                    </td>
                </tr>
            </table>

        </form>
                <tr>
                    <td colspan="2" align="center" ><p style="color:white;">
                    <?php echo $msg ?></p>
                    </td>
                </tr>
        </table>

    </div>

</div>
<?php include_once 'templates/footer.php';?>
