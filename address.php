<head>
    <title>Address</title>
</head>

<?php
session_start();
include 'templates/header_top.php';
?>
<?php
include_once "scripts/connect.php";
$msg = " ";
$full_name = "";
$country = "";
$city = "";
$state = "";
$phone = "";
$email = "";
$zipcode = "";
$address = "";
$ip = "";
$msg = "";
if (isset($_POST['full_name'])) {
    $full_name = $_POST['full_name'];
    $country = $_POST['country'];
    $city = $_POST['city'];
    $state = $_POST['state'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $zipcode = $_POST['zipcode'];
    $address = $_POST['address'];
    $country = preg_replace('#[^A-Za-z]#i', '', $country);
    $city = preg_replace('#[^A-Za-z]#i', '', $city);
    $state = preg_replace('#[^A-Za-z]#i', '', $state);
    $phone = preg_replace('#[^0-9]#i', '', $phone);
    $zipcode = preg_replace('#[^0-9]#i', '', $zipcode);
    $address = preg_replace('#[^A-Za-z0-9]#i', '', $address);
    $full_name = strip_tags($full_name);
    $country = strip_tags($country);
    $city = strip_tags($city);
    $state = strip_tags($state);
    $zipcode = strip_tags($zipcode);
    $full_name = stripslashes($full_name);
    $country = stripslashes($country);
    $city = stripslashes($city);
    $state = stripslashes($state);
    $zipcode = stripslashes($zipcode);
    $full_name = mysqli_real_escape_string($con, $full_name);
    $phone = $phone = stripslashes($phone);
    $email = mysqli_real_escape_string($con, $email);
    if ((!$full_name) || (!$country) || (!$city) || (!$phone) || (!$zipcode) || (!$address) || (!$email)) {
        $msg .= "Fill all the data marked with *!<br/>";
    } else {
        $email_check = mysqli_query($con, "SELECT email FROM users WHERE email='$email' LIMIT 1");
        $count_email = mysqli_num_rows($email_check);
        if (strlen($full_name) < 8) {
            $msg .= "Please insert a valid name with at least 8 charactes.<br/>";
        } else if (strlen($city) < 3) {
            $msg .= "Please insert a valid city with at least 3 charactes.<br/>";
        } else if (strlen($phone) < 9) {
            $msg .= "Please insert a valid phone number with at least 9 charactes.<br/>";
        } else if (strlen($zipcode) < 4) {
            $msg .= "Please insert a zipcode with at least 4 charactes.<br/>";
        } else if (strlen($address) < 12) {
            $msg .= "Please insert a valid address with at least 12 charactes.<br/>";
        } else if (strlen($email) < 9) {
            $msg .= "Please insert a valid email address with at least 9 charactes.<br/>";
        } else if ($count_email == 1) {
            $msg .= "That email address is already been taken.<br/>";
        } else {
            $zipcode = md5($zipcode);
            $ip = $_SERVER['REMOTE_ADDR'];
            $sql = mysqli_query($con, "INSERT INTO users(full_name, country, city, state, phone, email, zipcode, address, ip, signup) VALUES('$full_name','$country','$city','$state','$phone','$email','$zipcode','$address','$ip',now())");
            header("location: success_register.php");
            exit();
        }
    }
}
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

    <div id="content">
        <div class="products-holder" style="background: rgba(0,0,0,.4); border-radius: 10px; width: 700px; margin: 0 auto;">


            <div class="middle"style="background: transparent">
                <div class="label">
                    <h3>Fill Account</h3>
                </div>
                <div class="cl"></div>
            <form action="checkout.php" method="post" >


                    <div class="cl"></div>
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

                <tr>
                    <td align="right"><label>Email: *</label></td>
                    <td align="left"><input required type="email" name="email" placeholder="Enter Your Email Address..." class="text_input" maxlength="100"/></td>
                </tr>



                <tr>
                    <td align="right"><label>Address: *</label></td>
                    <td align="left"><Textarea required style="height: 80px; width: 300px;padding: 5px;resize: none;" name="address" placeholder="Enter  Your Address..." class="text_input" ></textarea></td>
                </tr>
                <tr>
                    <td align="right"><label>Zipcode: *</label></td>
                    <td align="left"><input required type="zipcode" name="zipcode" placeholder="Enter zipcode..." class="text_input" maxlength="50"/></td>
                </tr>

                <tr >
                    <td  colspan="2" align="center"></span><input id="submit" type="submit" value="success"/></td>

                </tr>
                <tr>
                    <td colspan="2" align="center"><?php echo "<p style='color: white; font-size: 17px;' >" . $msg . "</p>"; ?></td>
                </tr>
            </table>
            </form>
        </div>
    </div>
    <div id="footer-push"></div>
<!-- Form Styling-->

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
