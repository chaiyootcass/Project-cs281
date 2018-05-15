<head><title>
        Checkout
    </title>
    <link rel="stylesheet" href="css/checkout_style.css"/>
</head>

<?php

session_start();

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
$user_id = $_SESSION['id'];
$sql = "SELECT * FROM cart where mem_id='$user_id' limit 1 ";
$cart = array();
$carts = "";
$total = 0;
if ($query_run = mysqli_query($con, $sql)) {
    $row = mysqli_fetch_assoc($query_run);
    $con = mysqli_num_rows($query_run);
    if ($con == 1) {
        $id = $row['id'];
        $mem_id = $row['mem_id'];
        $carts = $row['cart'];
        $total = $row['total'];
        $carts = $carts . "";
        $_SESSION['total'] = $total;

        $cart = explode(",", $carts);
        $_SESSION['quantity'] = count($cart);
    } else {
        //$carts="You have a empty cart right now!";
    }

}

?>

<div id="content">
    <div class="products-holder" style="background: rgba(0,0,0,.4); border-radius: 10px; width: 700px; margin: 0 auto;">

        <div class="middle"style="background: transparent">
            <div class="label">
                <h3>Transfer Money</h3>
            </div>
            <div class="cl"></div>
            <form action="fillAddress2.php" method="post" >


                <div class="cl"></div>
        </div><table cellpadding="5" cellspacing="5" border="0">
            <tr>
                <td align="center" colspan="2"><label><h4>ธนาคารไทยพาณิชย์ (SCB)</h4> </label></td>
            </tr>

            <tr>
                <td align="center" colspan="2"><label><h5>ชื่อบัญชี: บริษัท ClothesShopByCs281 จำกัด</h5> </label></td>
            </tr>

            <tr>
                <td align="center" colspan="2"><label><h5>เลขที่บัญชี: 029 9290 281</h5> </label></td>
            </tr>

        <tr>
            <td align="center" colspan="2"><label><h4>ธนาคารกรุงไทย (KTB)</h4> </label></td>
        </tr>

        <tr>
            <td align="center" colspan="2"><label><h5>ชื่อบัญชี: บริษัท ClothesShopByCs281 จำกัด</h5> </label></td>
        </tr>

        <tr>
            <td align="center" colspan="2"><label><h5>เลขที่บัญชี: 478 1026 301</h5> <br><br></label></td>
        </tr>

        <tr>
          <td align="center" colspan="2"><label><h3>Transfer Slip</h3> </label></td>
        </tr>
            <tr>
                <td align="right"><label>Email:</label></td>
                <td align="left"><input required  type="email" name="mail" placeholder="Enter Your Email Address..." class="text_input" maxlength="80"/></td>
            </tr>
            <tr>
                <td align="right"><label>Balance:</label></td>
                <td align="left"><input required type="text" name="ิbalance" maxlength="15" placeholder="Enter Balance: 00.00 $" class="text_input" /></td>
            </tr>

            <tr>
                <td align="right"><label>Transfer Date:</label></td>
                <td align="left"><input required type="text" name="datetransfer" maxlength="15" placeholder="Enter Your Transfer Date: 01/03/2561..." class="text_input" /></td>
            </tr>

            <tr>
                <td align="right"><label>Transfer Time:</label></td>
                <td align="left"><input required type="text" name="timetransfer" maxlength="15" placeholder="Enter Your Transfer Time: 12.59 pm..." class="text_input" /></td>
            </tr>

            <tr>
                <td align="right"><label>Form the bank:</label></td>
                <td align="left"><input required type="text" name="formbank" maxlength="15" placeholder="Enter Your Bank Account ..." class="text_input" /></td>

            </tr>
            <tr>
                <td align="right"><label>To the bank:</label></td>
                <td align="left">
                    <select required name="tobank"  class="text_input" style="height:28px; width: 300px;">
                        <option value=""></option>
                        <?php include_once 'bank.txt';?>
                    </select>
                </td>
            </tr>


            <tr>
                <td align="left"><input type="hidden" name="cart"  value="<?php echo $carts; ?>" /></td>
                <td align="left"><input type="hidden" name="total"  value="<?php echo $total; ?>" /></td>
            </tr>

            <tr >
                <td  colspan="2" align="center"><input id="submit" type="submit" value="Done"/></td>

            </tr>
        </table>
        </form>
    </div>

</div>


    <div id="footer-push"></div>

<?php include_once 'templates/footer.php';?>

<!-- form styling-->

<style type="text/css">
    #submit
    {
        background: #026a84;
        padding: 10px;
        border-radius: 5px;


        color: white;
        border: 0px;
        margin-left:300px;
        background: -webkit-linear-gradient(top,#00aac9, #026a84);
    }

    #submit:hover
    {
        color: #ffffff;
        background: #026a84;
        text-shadow: 1px 1px #ffffff;
    }

    table
    {
        margin: 0 auto;
    }
    label
    {
        font-family:  arial, sans-serif;
        font-size: 16px;
        color: #ffffff;
    }
    .text_input
    {
        border-radius: 7px;
        box-shadow: #000000 2px 2px 8px;
        width: 300px;
        padding: 5px;
    }
    h2
    {
        font-size: 22px;
    }
    td
    {
        padding: 10px;
    }
</style>
