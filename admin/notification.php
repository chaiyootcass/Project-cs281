<?php
session_start();
if (!isset($_SESSION['name'])) {
    header("location: ../admin.php");
    exit();
}
include_once '../scripts/connect.php';
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="UTF-8">
    <title>Notification
    </title>
    <link rel="stylesheet" href="style/style.css">
    <link rel="stylesheet" href="style/forms.css"/>
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
      <div class="notification">
        <table width="100%" cellpadding="5" cellspacing="5"style="color: white; border-radius:10px; background: rgba(0,0,0,0.4)">
            <form action="../scripts/email.php" id="emailform" method="post">
            <tr>
                <td><p class = "special">
                    <input required="required" type="radio" name="select" value="all" checked=""> To all<br>
                    <input required="required" type="radio" name="select" value="some"> To specific person
                    </p>
                </td>
            </tr>
            <tr>
                <td>To : <input pattern="[\w.\-]+@([a-z]+(\.[a-z]+)+)(;[\w.\-]+@([a-z]+(\.[a-z]+)+))*?" type="text" name="to" size="75"><br>
                <i><b>Note: </b> split email with ;  no space</i> Ex. a@mail.com;bmail.com </td>
            </tr>
            <tr>
                <td>Subject : <input required type="text" name="subject" size="40"></td>
            </tr>
            <tr>
                <td><textarea rows="10" cols="128" name="message" form="emailform" placeholder="Enter text here..."></textarea></td>
            </tr>
            <tr>
                <td align="center"><input type="submit" value="Submit"></td>
            </tr>
            </form>
        </table>
      </div>
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