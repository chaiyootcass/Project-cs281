<head><title>
        Checkout
    </title>
    <link rel="stylesheet" href="css/checkout_style.css"/>
</head>

<?php

session_start();

if (!isset($_SESSION['id'])) {
    header("location: checkout.php");
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
$last_id ="";
$status_order = "";
$user_id = $_SESSION['id'];
if (isset($_POST['mail'])) {
    $email = $_POST['mail'];
    $phone = $_POST['phone'];
    $carts = $_POST['cart'];
    $total = $_POST['total'];
    $cnic = $_POST['cnic'];
    $verify_code = $_POST['code'];
    if ((!$carts)) {
        $status_order = "Sorry! You have an empty cart. Please add some item(s) to your cart!";
    } else {
        include_once "scripts/connect.php";
        $sql = mysqli_query($con, "INSERT INTO orders(email, phone_number, CNIC_number,verify_code, products,user_id,paid_amount) VALUES('$email','$phone','$cnic','$verify_code','$carts','$user_id','$total')");
        $last_id = mysqli_insert_id($con);
        $sql = mysqli_query($con, "delete from cart where mem_id='$user_id'");
        // $status_order = "Order Successfully placed!";

    }
}


?>
<?php


    $_SESSION['last_id']= $last_id;

?>



<div id="content">
    <div class="products-holder" style="background: rgba(0,0,0,.4); border-radius: 10px; width: 700px; margin: 0 auto;">


        <div class="middle"style="background: transparent">
            <div class="label">
                <h3>Fill Account</h3>
            </div>

            <div class="cl"></div>

        <form action="order_status.php" method="post" >


        </div>
        <table cellpadding="5" cellspacing="5" border="0">

            <tr>
                <td align="right"><label>Full Name: *</label></td>
                <td align="left"><input required  autofocus type="text" name="full_name" placeholder="Enter Full Name..." class="text_input" maxlength="255"/></td>
            </tr>

            <tr>
                <td align="right"><label>Country: *</label></td>
                <td align="left">
                    <select required name="country"  class="text_input" style="width: 315px;">
                        <option value=""></option>
                        <?php include_once 'countries.txt';?>
                    </select>
                </td>

            </tr>

            <tr>
                <td align="right"><label>City: *</label></td>
                <td align="left"><input required type="text" name="city" placeholder="Enter Your City..." class="text_input" maxlength="50"/></td>
            </tr>

            <tr>
                <td align="right"><label>State:</label></td>
                <td align="left"><input  type="text" name="state" placeholder="Enter Your State..." class="text_input" maxlength="50"/></td>
            </tr>


            <tr>
                <td align="right"><label>Phone: *</label></td>
                <td align="left"><input required type="tel" name="phone" placeholder="Enter Your Phone Number..." class="text_input" maxlength="15"/></td>
            </tr>

            <!-- <tr>
                <td align="right"><label>Email: *</label></td>
                <td align="left"><input required type="email" name="email" placeholder="Enter Your Email Address..." class="text_input" maxlength="100"/></td>
            </tr> -->



            <tr>
                <td align="right"><label>Address: *</label></td>
                <td align="left"><Textarea required style="height: 80px; width: 300px;padding: 5px;resize: none;" name="address" placeholder="Enter  Your Address..." class="text_input" ></textarea></td>
            </tr>

            <tr>
                <td align="right"><label>Zipcode: *</label></td>
                <td align="left"><input required type="tel" name="zipcode" placeholder="Enter zipcode..." class="text_input" maxlength="50"/></td>
            </tr>


            <tr >
                <td  colspan="2" align="center"></span><input id="submit" type="submit" value="success"/></td>

            </tr>


            <!-- <tr>
                <td colspan="2" align="center"><?php echo "<p style='color: white; font-size: 17px;' >" . $msg . "</p>"; ?></td>
            </tr> -->

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
