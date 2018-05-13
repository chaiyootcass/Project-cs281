<head>
  <title>
    CS281
  </title>
  <script type="text/javascript" src="js/jquery-1.8.0.min.js" >
  </script>
  <script type="text/javascript" src="js/search.js" >
  </script>
</head>
<?php
session_start();
//testing login....
$email = "";
$password = "";
$msg_error = "";
$s_id = "";
$msg = "";
$count = 0;
function getRealUserIp()
{
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else {
        $ip = $_SERVER['REMOTE_ADDR'];
    }
    return $ip;
}
if (isset($_POST['email'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];
    if ((!$email) || (!$password)) {
        $msg_error = "<p style='color: #ffffff; font-weight: bold;'>Wrong email or password!</p>";
    } else {
//$email = mysql_real_escape_string($email);
        $password = md5($password);
        include 'scripts/connect.php';
        date_default_timezone_set("Asia/Bangkok");
        $ipaddress = getRealUserIp();
        $mysql_date_now = date("Y-m-d H:i:s");
        mysqli_query($con, "UPDATE `users` SET `activated` = '1',`last_log`='$mysql_date_now',`ip`='$ipaddress' WHERE email='$email'");
        $sql = "SELECT * FROM `users`where email='$email' and password='$password'";
        if ($query_run = mysqli_query($con, $sql)) {
            while ($row = mysqli_fetch_assoc($query_run)) {
                $s_id = $row['id'];
                $s_name = $row['full_name'];
                $s_email = $row['email'];
                $s_pass = $row['password'];
                $_SESSION['id'] = $s_id;
                $_SESSION['email'] = $s_email;
                $_SESSION['password'] = $s_pass;
                $_SESSION['name'] = $s_name;
            }
        } else {
            $msg_error = "<p style='color: #ffffff; font-weight: bold;'>Wrong email or password sql!</p>";
        }
    }
}
?>
<!-- Including top header !-->
<?php
include 'templates/header_top.php';
?>
<?php
if (!isset($_SESSION['email'])) {
    include 'templates/login.php';
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
<?php
include 'scripts/connect.php';
$sql = "SELECT * FROM `product` where category='shirts' order by sales DESC LIMIT 8 ";
$sql1 = "SELECT * FROM `product`  where category='pants' order by sales DESC LIMIT 8  ";
?>
<!-- Content -->
<div id="content">
  <div class="products-holder">
    <div class="middle">
      <div class="label">
        <h3>Top Shirts
        </h3>
      </div>
      <div class="cl">
      </div>
      <?php
if ($query_run = mysqli_query($con, $sql)) {
    while ($row = mysqli_fetch_assoc($query_run)) {
        $id = $row['id'];
        $product_name = $row['name'];
        $product_description = $row['description'];
        $product_price = $row['price'];
        $product_quantity = $row['quantity'];
        $status = $row['status'];
        ?>
      <div class="product">
        <a  title="Details" href="product.php?id=<?php echo $id; ?>">
          <img height="152" width="185" id="img" src="products/<?php echo $id ?>.jpg" alt="<?php echo $product_name; ?>" />
        </a>
        <div class="desc">
          <p class="name">
            <?php echo $product_name; ?>
          </p>
          <p>Status:
            <span>
              <?php if ($status == 0) {
            echo "UnAvailable";} else {
            echo "Available";
        }?>
            </span>
          </p>
          <p>Quantity:
            <span>
              <?php echo $product_quantity ?>
            </span>
          </p>
          <p>Product code:
            <span>
              <?php echo $id ?>
            </span>
          </p>
        </div>
        <div class="price-box">
          <p>
            <span class="price">
              <?php echo $product_price; ?>
            </span>
          </p>
          <p class="per-peace">Per Price
          </p>
        </div>
        <div class="cl">
        </div>
      </div>
      <?php }
}
?>
      <div class="cl">
      </div>
    </div>
  </div>
  <div class="products-holder">
    <div class="middle">
      <div class="label">
        <h3>Top Pants
        </h3>
      </div>
      <div class="cl">
      </div>
      <?php if ($query_run = mysqli_query($con, $sql1)) {
    while ($row = mysqli_fetch_assoc($query_run)) {
        $id = $row['id'];
        $product_name = $row['name'];
        $product_description = $row['description'];
        $product_price = $row['price'];
        $product_quantity = $row['quantity'];
        $status = $row['status'];
        ?>
      <div class="product">
        <a  title="Details" href="product.php?id=<?php echo $id; ?>">
          <img height="152" width="185" id="img" src="products/<?php echo $id ?>.jpg" alt="<?php echo $product_name; ?>" />
        </a>
        <div class="desc">
          <p class="name">
            <?php echo $product_name; ?>
          </p>
          <p>Status:
            <span>
              <?php if ($status == 0) {
            echo "UnAvailable";} else {
            echo "Available";
        }?>
            </span>
          </p>
          <p>Quantity:
            <span>
              <?php echo $product_quantity ?>
            </span>
          </p>
          <p>Product code:
            <span>
              <?php echo $id ?>
            </span>
          </p>
        </div>
        <div class="price-box">
          <p>
            <span class="price">
              <?php echo $product_price; ?>
            </span>
          </p>
          <p class="per-peace">Per Peace
          </p>
        </div>
        <div class="cl">
        </div>
      </div>
      <?php }
}
?>
      <div class="cl">
      </div>
    </div>
  </div>
</div>
