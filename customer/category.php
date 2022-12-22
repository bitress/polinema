<?php

include_once '../includes/connection.php';

if (isset($_SESSION['isLoggedIn'])){
    $id = $_SESSION['id'];


    $sql = "SELECT * FROM users WHERE users.id = '$id'";
    $result = mysqli_query($con, $sql);
    $row = mysqli_fetch_assoc($result);

} else {
    header("Location: ../index.php");
}


if (isset($_POST['addtocart'])){
    $user_id = $row['id'];

    $product = $_POST['product_id'];
    $quantity = $_POST['quantity'];

    // Check if the item is already in the cart
    $result = mysqli_query($con, "SELECT * FROM cart WHERE product_id = '$product' AND user_id = '$user_id'");
    if (mysqli_num_rows($result) > 0) {
        // Item is already in the cart, update quantity
        mysqli_query($con, "UPDATE `cart` SET quantity = quantity + '$quantity' WHERE product_id = '$product' AND user_id = '$user_id'");
        header("Location: index.php");
    } else {
        // Item is not in the cart, insert new row
        mysqli_query($con, "INSERT INTO `cart` (product_id, user_id, quantity) VALUES ('$product', '$user_id', '$quantity')");
        header("Location: index.php");
    }
}



?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Home | ShopOn-it</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous"></head>
<link rel="stylesheet" href="../css/style.css">
<style>
    @media (min-width: 1025px) {
        .h-custom {
            height: 100vh !important;
        }
    }
</style>
<body>


<?php
include_once '../includes/navbar.php';
?>
<header class="bg-dark py-5">
    <div class="container px-4 px-lg-5 my-5">
        <div class="text-center text-white">
            <h1 class="display-4 fw-bolder">Welcome <?php echo $row['firstname'] .' ' . $row['middlename'] . ' '. $row['lastname'] ?></h1>
            <p class="lead fw-normal text-white-50 mb-0">Have fun shopping!</p>
        </div>
    </div>
</header>




<section class="py-5">

    <div class="container py-5">
        <div class="row">
            <div class="col-lg-3">
                <h4 class="d-flex justify-content-between align-items-center mb-3">
                    <span class="text-muted">Your cart</span>
                    <span class="badge badge-secondary badge-pill">3</span>
                </h4>
                <ul class="list-group mb-3">

                    <?php
                    $id = $row['id'];
                    $total_price = 0;

                    $sql = "SELECT * FROM cart INNER JOIN products ON products.id = cart.product_id INNER JOIN users ON users.id = cart.user_id LEFT JOIN category ON category.category_id = products.category WHERE  users.id = '$id'";
                    $result = mysqli_query($con, $sql);
                    while ($cart = mysqli_fetch_array($result)){
                        $total_price += $cart['product_price'] * $cart['quantity'];

                        ?>
                        <li class="list-group-item d-flex justify-content-between lh-condensed">
                            <div>
                                <h6 class="my-0"><?php echo $cart['product_name'] ?> (<?php echo $cart['quantity'] ?>)</h6>
                                <small class="text-muted"><?php echo $cart['category_name'] ?></small>
                            </div>
                            <span class="text-muted">₱<?php echo number_format($cart['product_price'] * $cart['quantity']) ?></span>
                        </li>
                        <?php


                    }?>

                    <li class="list-group-item d-flex justify-content-between">
                        <span>Total (PHP)</span>
                        <strong>₱<?php echo number_format($total_price) ?></strong>
                    </li>
                </ul>
            </div>

            <div class="col-lg-9">
                <div class="row">
                    <div class="col-md-12 pb-4">
                        <div class="d-flex">
                            <select id="category_select" class="form-control">
                                <option selected disabled>--- Choose a Category ---</option>
                                <?php

                                $sql = "SELECT * FROM category";
                                $result = mysqli_query($con, $sql);
                                while ($category = mysqli_fetch_assoc($result)){

                                    ?>
                                    <option value="category.php?id=<?php echo $category['category_id'] ?>&name=<?php echo $category['category_name'] ?>"><?php echo $category['category_name'] ?></option>
                                    <?php
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">

            <?php

            if (isset($_GET['id']) && isset($_GET['name'])){
                $id = $_GET['id'];
            } else {
                header("Location: index.php");
            }

            $sql = "SELECT * FROM products LEFT JOIN category ON category.category_id = products.category WHERE category_id = '$id'";
            $result = mysqli_query($con, $sql);
            if (mysqli_num_rows($result) > 0){
            while($product = mysqli_fetch_assoc($result)){
            ?>
                <div class="col-md-4">
                    <div class="card mb-4 product-wap rounded-0">
                        <div class="card rounded-0">
                            <img class="card-img rounded-0 img-fluid" src="<?php echo WEBSITE_DOMAIN . $product['product_image']?>">
                            <div class="card-img-overlay rounded-0 product-overlay d-flex align-items-center justify-content-center">

                            </div>
                        </div>

                        <form action="index.php" method="post">
                            <input type="hidden" name="product_id" value="<?php echo $product['id']?>">
                            <div class="card-body">
                                <span class="h3 text-decoration-none"><?php echo $product['product_name']?></span>
                                <ul class="w-100 list-unstyled d-flex justify-content-between mb-0">
                                    <li class="fw-light"><a href="category.php?id=<?php echo $product['category']?>&name=<?php echo urlencode($product['category_name'])?>"><?php echo $product['category_name']?></a> </li>
                                    <li class="pt-2">
                                        <span class="product-color-dot color-dot-red float-left rounded-circle ml-1"></span>
                                        <span class="product-color-dot color-dot-blue float-left rounded-circle ml-1"></span>
                                        <span class="product-color-dot color-dot-black float-left rounded-circle ml-1"></span>
                                        <span class="product-color-dot color-dot-light float-left rounded-circle ml-1"></span>
                                        <span class="product-color-dot color-dot-green float-left rounded-circle ml-1"></span>
                                    </li>
                                </ul>
                                <p class="text-center mb-0">₱<?php echo number_format($product['product_price'])?></p>
                                <div class="mb-2">
                                    <label>How many?</label>
                                    <input type="number" id="quantity" name="quantity" value="1" title="quantity" class="form-control">
                                </div>
                                <input type="submit"  name="addtocart" id="addtocart" class="btn btn-outline-dark btn-sm addtocart" value="Add to Cart">
                            </div>
                        </form>
                    </div>
                </div>
    <?php

        }
        } else {
            echo "No products to show!";
        }
        ?>


    </div>
    </div>
</section>


<?php

include_once '../includes/modal.php';

?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" ></script>
<script src="https://code.jquery.com/jquery-3.6.3.min.js" integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU=" crossorigin="anonymous"></script>
<script>
    $('#category_select').change(function() {
        window.location = $(this).val();
    });
</script>
</body>
</html>