<?php
include 'scripts/connect.php';
$sql = "";
if (isset($_POST['search_item'])) {
    $search_item = $_POST['search_item'];
    if (!empty($search_item)) {
        $sql = "SELECT * FROM `product` where name like '%$search_item%' ; ";
    }
    ?>
<table cellspacing="0" width="100%">
  <?php
include_once "scripts/connect.php";
    if ($query_run = mysqli_query($con, $sql)) {
        while ($row = mysqli_fetch_assoc($query_run)) {
            $id = $row['id'];
            $product_name = $row['name'];
            $product_description = $row['description'];
            $product_price = $row['price'];
            $product_quantity = $row['quantity'];
            $status = $row['status'];
            echo "
<tr style='padding-left: 10px;'>
<td align='center' >
<a style='padding-bottom: 10px; text-decoration: none; color: #fff;' title='Details' href='product.php?id=$id'><img style='border-radius: 10px;' height='50' width='50' src='products/$id.jpg'/></a>
</td>
<td align='center' >
<a style='padding-bottom: 10px; text-decoration: none; color: #fff;' title='Details' href='product.php?id=$id'>$product_name</a>
</td>
</tr>
";
        }
    }
}
?>
</table>