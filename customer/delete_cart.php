<?php
include_once '../includes/connection.php';

if (isset($_GET['product_id'])){

    $id = $_GET['product_id'];
    $customer = $_GET['customer_id'];

    $sql = "DELETE FROM cart WHERE product_id = '$id' AND user_id = '$customer'";
    mysqli_query($con, $sql);


    header("Location: index.php");


}