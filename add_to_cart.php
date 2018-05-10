<?php
session_start();
include('scripts/connect.php');
if(isset($_POST['product_id'])) {

    $mem_id =  $_SESSION['id'];
    $id = $_POST['product_id'];
    $product_price = $_POST['product_price'];
    $sales=$_POST['sales'];
    $id = preg_replace('#[^0-9]#i', '', $id);
    $product_price = preg_replace('#[^0-9]+(\.[0-9])?$#i', '', $product_price);
    $sql = "SELECT * from cart where mem_id='$mem_id' LIMIT 1";

    if ($query_run = mysqli_query($con,$sql)) {
        $row = mysqli_fetch_assoc($query_run);
        $con = mysqli_num_rows($query_run);
        if ($con == 1) {
            $quantity = ($row['quantity']) + 1;
            $cart = $row['cart'];
            $total = $row['total'];

            $bill = $total + $product_price;

            $pro_quantity=($_POST['product_quantity']);
            if($pro_quantity>0)
            {
                $pro_quantity--;
                $sales++;
                $result2 = mysqli_query(mysqli_connect("localhost","root","","cd"),"update cart SET cart='$cart,$id',total='$bill',quantity='$quantity' WHERE mem_id='$mem_id' LIMIT 1");
                if($pro_quantity==0)
                {
                    $result3 = mysqli_query(mysqli_connect("localhost","root","","cd"),"update product SET status='0' WHERE id='$id' LIMIT 1");
                }
            }
            $result4 = mysqli_query(mysqli_connect("localhost","root","","cd"),"update product SET quantity='$pro_quantity',sales='$sales' WHERE id='$id' LIMIT 1");
            header("location: cart.php");
        } else {

            $pro_quantity=($_POST['product_quantity']);
            if($pro_quantity>0)
            {
                $pro_quantity--;
                mysqli_query(mysqli_connect("localhost","root","","cd"),"INSERT into cart(mem_id,cart,total,quantity) values ('$mem_id','$id','$product_price',1)");
                if($pro_quantity==0)
                {
                    $result3 = mysqli_query(mysqli_connect("localhost","root","","cd"),"update product SET status='0' WHERE id='$id' LIMIT 1");

                }
            }
            header("location: cart.php");
            exit();
        }


    }
}
?>

<?php
session_start();
include('scripts/connect.php');
if(isset($_POST['product_id'])) {

    $mem_id =  $_SESSION['id'];
    $id = $_POST['product_id'];
    $product_price = $_POST['product_price'];
    $sales=$_POST['sales'];
    $id = preg_replace('#[^0-9]#i', '', $id);
    $product_price = preg_replace('#[^0-9]+(\.[0-9])?$#i', '', $product_price);
    $sql = "SELECT * from cart where mem_id='$mem_id' LIMIT 1";

    if ($query_run = mysqli_query($con,$sql)) {
        $row = mysqli_fetch_assoc($query_run);
        $con = mysqli_num_rows($query_run);
        if ($con == 1) {
            $quantity = ($row['quantity']) + 1;
            $cart = $row['cart'];
            $total = $row['total'];

            $bill = $total + $product_price;

            $pro_quantity=($_POST['product_quantity']);
            if($pro_quantity>0)
            {
                $pro_quantity--;
                $sales++;
                $result2 = mysqli_query(mysqli_connect("localhost","root","","cd"),"update cart SET cart='$cart,$id',total='$bill',quantity='$quantity' WHERE mem_id='$mem_id' LIMIT 1");
                if($pro_quantity==0)
                {
                    $result3 = mysqli_query(mysqli_connect("localhost","root","","cd"),"update product SET status='0' WHERE id='$id' LIMIT 1");
                }
            }
            $result4 = mysqli_query(mysqli_connect("localhost","root","","cd"),"update product SET quantity='$pro_quantity',sales='$sales' WHERE id='$id' LIMIT 1");
            header("location: cart.php");
        } else {

            $pro_quantity=($_POST['product_quantity']);
            if($pro_quantity>0)
            {
                $pro_quantity--;
                mysqli_query(mysqli_connect("localhost","root","","cd"),"INSERT into cart(mem_id,cart,total,quantity) values ('$mem_id','$id','$product_price',1)");
                if($pro_quantity==0)
                {
                    $result3 = mysqli_query(mysqli_connect("localhost","root","","cd"),"update product SET status='0' WHERE id='$id' LIMIT 1");

                }
            }
            header("location: cart.php");
            exit();
        }


    }
}
?>

