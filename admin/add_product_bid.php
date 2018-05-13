<?php
session_start();
$msg = "";
$name = 'gas';
if (isset($_POST['submit'])) {
    $Err = 0;
    $idee = $_POST['submit'];
    $db = mysqli_connect('localhost', 'root', '', 'cd') or die('connection failed');

    if ($idee == 1) {
        $pname = $descp = '';
        $minbid = $maxbid = $Qty = $Exp = 0;
        $descp = $_POST['desc'];
        if ($_POST['name'] != "") {
            $pname = $_POST['name'];
        } else {
            $msg = "Please Enter Product Name<br>";
            $Err++;
        }

        if ($_POST['minbid'] != "") {
            if (is_numeric($_POST['minbid'])) {
                $minbid = $_POST['minbid'];
            } else {
                $msg = $msg . "Bid must be numeric<br>";
                //echo "Bid must be numeric<br>";
                $Err++;
            }
        } else {
            //echo "Please Enter Minimum Bid<br>";
            $msg = $msg . " Please Enter Minimum Bid<br>";
            $Err++;
        }

        $d1 = date_create($_POST['expiry']);
        $d2 = date_create(date('d-m-Y'));
        $diff = date_diff($d2, $d1);
        if ($diff->format("%R%a") < 0) {
            $msg = $msg . "Enter Date in future<br>";
            //echo "Enter Date in future<br>";
            $Err++;
        } else {
            $Exp = date_format($d1, 'Y-m-d');
        }

        if ($_POST['maxbid'] != "") {
            if (is_numeric($_POST['maxbid'])) {
                if ($_POST['maxbid'] > $minbid) {
                    $maxbid = $_POST['maxbid'];
                } else {
                    $msg = $msg . "Maximum Bid must be greater than Minimum Bid<br>";
                    //echo "Maximum Bid must be greater than Minimum Bid<br>";
                    $Err++;
                }
            } else {
                $msg = $msg . "Bid must be numeric<br>";
                //echo "Bid must be numeric<br>";
                $Err++;
            }
        } else {
            $msg = $msg . "Please Enter Maximum Bid<br>";
            //echo "Please Enter Maximum Bid<br>";
            $Err++;
        }
        if ($_POST['qty'] != "") {
            $temp = (float) $_POST['qty'] - (int) $_POST['qty'];
            if (is_numeric($_POST['qty']) && $temp == 0) {
                $Qty = (int) $_POST['qty'];
            } else {
                $msg = $msg . "Quantity must be an Integer<br>";
                // echo "Quantity must be an Integer<br>";
                $Err++;
            }
        } else {
            $msg = $msg . "Please Enter Quantity<br>";
            //echo "Please Enter Quantity<br>";
            $Err++;
        }
        if ($Err == 0) {
            if ($_FILES['fileField']['tmp_name'] != "") {
                $maxfilesize = 1000000;
                if ($_FILES['fileField']['size'] > $maxfilesize) {
                    $msg = '<p class="errror_message">Your image was too large, please try again.</p>';
                    unlink($_FILES['fileField']['tmp_name']);
                } else if (!preg_match("/\.(gif|jpg|png)$/i", $_FILES['fileField']['name'])) {
                    $msg = '<p class="errror_message">Your image was not one of the accepted formats, please try again.</p>';
                    unlink($_FILES['fileField']['tmp_name']);
                } else {
                    $newname = $_POST['name'] . ".jpg";
                    $place_file = move_uploaded_file($_FILES['fileField']['tmp_name'], "../products/bid/" . $newname);
                    $msg = "Product Successfully added! " . $newname;
                    $_FILES['fileField']['tmp_name'] = "";
                }
            }
            $max = "SELECT MAX(productId) as \"lastId\" from productbid ";
            $max = mysqli_query($db, $max) or die("query failed");
            $max = mysqli_fetch_array($max);
            $max = $max['lastId'] + 1;

            $query = "INSERT into productbid VALUES($max,'$pname',$maxbid,$minbid,$Qty,'$name','$descp','0','$Exp');";
            $result = mysqli_query($db, $query) or die("could not add");
            if ($result) {
                // echo "<title> Successfully Added Product</title>";
                $msg = $msg . "Successfully Added Product";
                //echo "Successfully Added Product";
            }
        } else {
            //echo "<title> Failed to Add Product</title>";
            $msg = $msg . "Failed to Add Product . Try Again";
            //echo "Failed to Add Product . Try Again";
        }
        //$msg = $msg . "<form action='add_product_bid.php'><button action='add_product_bid.php'>Go Back</button></form>";
        //echo "<form action='add_product_bid.php'><button action='add_product_bid.php'>Go Back</button></form>";
    }

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

            $query = "INSERT into ordersbid VALUES($max,'$name','$seller',$Bid,'$address',$Pid,$Quantity,$status);";
            $result = mysqli_query($db, $query) or die("could not add");

            $updateQ = "update productbid set quantity=quantity-$Quantity,currBid=$Bid where productId=$Pid;";
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

    if ($idee == 5) {
        $PID = $_SESSION['Product_to_delete'];
        $query = "DELETE from productbid where productId=$PID;";
        $result = mysqli_query($db, $query) or die("Delete Failed");
        $query = "DELETE from ordersbid where productId=$PID;";
        $result2 = mysqli_query($db, $query) or die("Delete Failed");
        if ($result && $result2) {
            // echo "<title> Deleted Product !</title>";
            $msg = $msg . "Deleted Successfully";
            //   echo "Deleted Successfully";
        }
        //$msg = $msg . "<form action='add_product_bid.php'><button action='add_product_bid.php'>Go Back</button></form>";
        // echo "<form action='add_product_bid.php'><button action='add_product_bid.php'>Go Back</button></form>";
    }

    if ($idee == 6) {
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

}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Product</title>
    <link rel="stylesheet" href="style/style.css"/>
    <link rel="stylesheet" href="style/forms.css"/>
</head>
<body>
<div id="main_wrapper">
    <div id="header">
    <?php include_once '../templates/admin_header.php';?>
    <a id="logout"href="admin_logout.php"> <div class="btn btn-default logout">Logout</div></a>
    <?php include_once '../templates/admin_nav.php';?>
    </div>
    <section id="main_content">
        <br/>
        <form name='add_product' action="add_product_bid.php" enctype="multipart/form-data" method="post">
            <table cellpadding="5" cellspacing="5" border="0">

                <tr>
                    <td align="left" colspan="2">
                        <h2>Add a new Bid Product </h2>
                    </td>
                </tr>
                <tr>
                    <td align="right"><label>Product Name:</label></td>
                    <td align="left"><input autofocus type="text" name="name" placeholder="Enter Product name..." class="text_input add" maxlength="100"/></td>
                </tr>
                <tr>
                    <td align="right"><label>Minimum Bid:</label></td>
                    <td align="left"><input autofocus type="text" name="minbid" placeholder="Enter Product name..." class="text_input add" maxlength="100"/></td>
                </tr>
                <tr>
                    <td align="right"><label>Maximum Bid:</label></td>
                    <td align="left"><input autofocus type="text" name="maxbid" placeholder="Enter Product name..." class="text_input add" maxlength="100"/></td>
                </tr>
                <tr>
                    <td align="right"><label>Quantity:</label></td>
                    <td align="left"><input type="text" name="qty" maxlength="7" placeholder="Enter Product quantity..." class="text_input add" /></td>
                </tr>
                <tr>
                    <td align="right"><label>Description:</label></td>
                    <td align="left"><Textarea  style="height: 80px; width: 300px;padding: 5px;resize: none;" name="desc" placeholder="Enter  description..." class="text_input add" ></textarea></td>
                </tr>
                <tr>
                    <td align="right"><label>Expiry:</label></td>
                    <td align="left">&nbsp;&nbsp;&nbsp;<input  type="date" name="expiry" value=""/></td>
                </tr>
                <tr>
                    <td align="right"><label>Product Image:</label></td>
                    <td align="left">
                        <div id="files"> <input type="file" name="fileField" id="fileField"    class="formFields" /></div>
                        <input   type="hidden" name="parse_var" value="pho1" />
                    </td>
                </tr>
                <tr >
                    <td  colspan="2" align="center">
                        <button id="submit" type="submit" name="submit" value='1'> Add Product </button>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" align="center">
                    <?php echo $msg ?>
                    </td>
                </tr>
            </table>

        </form>
    </section>

</div>


</body>
</html>