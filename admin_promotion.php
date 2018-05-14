<?php
$msg = " ";
session_start();
if (!isset($_SESSION['name'])) {
    header("location: ../admin.php");
    exit();
}
if (isset($_POST['promocode'])) {
    $code = $_POST['promocode'];

    if (!$code) {
        $msg = "Please fill the input data!";
    } else {
        include_once "../scripts/connect.php";
        $sql = mysqli_query($con, "INSERT INTO promocode (code) VALUE ('$code') ");
        $msg = "Product Successfully updated!";
    }
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update Promotion Code</title>
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

        <form action="admin_promotion.php" enctype="multipart/form-data" method="post">
            <table cellpadding="5" cellspacing="5" border="0">
                <tr>
                    <td align="left" colspan="2">
                        <h2>Update Promotion Code</h2>
                    </td>
                </tr>
                
                
                       <tr>
                 <td align="right"><label>Promotion code : </label></td>
                <td align="left"><input required autofocus type="text" name="promocode" placeholder="Enter Promotioncode..." class="text_input add" maxlength="10"/></td></tr>


                <tr >
                    <td  colspan="2" align="center"><input id="submit" type="submit" value="Done"/></td>

                </tr>
                <tr>
                    <td colspan="2" align="center"><?php echo $msg; ?></td>
                </tr>
            </table>

        </form>
    </section>


</div>


</body>
</html>



