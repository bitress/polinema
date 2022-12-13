<?php

include_once 'connection.php';

if (isset($_POST['id'])){

    $id = $_POST['id'];

    $sql = "DELETE FROM products WHERE id = '$id'";
    mysqli_query($con, $sql);

    $sql = "DELETE FROM cart WHERE product_id = '$id'";
    mysqli_query($con, $sql);

    header("Location: admin.php");

}