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
    <link rel="stylesheet" href="css/style.css">
    <style>
        @media (min-width: 1025px) {
            .h-custom {
                height: 100vh !important;
            }
        }
    </style>
<body>

<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container px-4 px-lg-5">
        <a class="navbar-brand" href="index.php">ShopOn-it</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="index.php">Home</a>
                </li>
                <li class="nav-item"><a class="nav-link" href="#!">About</a></li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Categories</a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="index.php">All Products</a></li>
                        <li><hr class="dropdown-divider" /></li>
                        <?php

                        $sql = "SELECT * FROM category";
                        $result = mysqli_query($con, $sql);
                        while ($category = mysqli_fetch_assoc($result)){

                        ?>
                            <li><a class="dropdown-item" href="category.php?id=<?php echo $category['category_id']?>&name=<?php echo urlencode($category['category_name'])?>"><?php echo $category['category_name']?></a></li>
                        <?php }
                        ?>
                    </ul>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="../logout.php">Logout</a>
                </li>
            </ul>

            <div class="d-flex">
                <button data-bs-toggle="modal" data-bs-target="#myCart" href="#" class="btn btn-outline-dark" type="button">
                    <i class="bi-cart-fill me-1"></i>
                    Cart
                    <span class="badge bg-dark text-white ms-1 rounded-pill"><?php echo countCart($con, $row['id'])?></span>
                </button>

            </div>
        </div>
    </div>
</nav>

<header class="bg-dark py-5">
    <div class="container px-4 px-lg-5 my-5">
        <div class="text-center text-white">
            <h1 class="display-4 fw-bolder">Welcome <?php echo $row['firstname'] .' ' . $row['middlename'] . ' '. $row['lastname'] ?></h1>
            <p class="lead fw-normal text-white-50 mb-0">Have fun shopping!</p>
        </div>
    </div>
</header>

<section class="py-5">
    <div class="container px-4 px-lg-5 mt-5">
        <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">

            <?php
            $sql = "SELECT * FROM products LEFT JOIN category ON category.category_id = products.category";
            $result = mysqli_query($con, $sql);
            if (mysqli_num_rows($result) > 0){
            while($product = mysqli_fetch_assoc($result)){
            ?>
            <div class="col mb-5">
                <div class="card h-100" >
                    <form action="index.php" method="post">
                        <input type="hidden" name="product_id" value="<?php echo $product['id']?>">
                    <!-- Product image-->
                        <div class="img-wrap">
                            <img height="300px" width="450px" class="card-img-top" src="<?php echo WEBSITE_DOMAIN . $product['product_image']?>" alt="..." />
                        </div>
                    <!-- Product details-->
                    <div class="card-body p-4">
                        <div class="text-center">
                            <!-- Product name-->
                            <h5 class="fw-bolder"><?php echo $product['product_name']?></h5>
                            <p class="text-muted"><?php echo $product['category_name']?></p>
                            <!-- Product price-->
                            ₱<?php echo number_format($product['product_price'])?>
                        </div>
                    </div>
                    <!-- Product actions-->
                    <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">
                        <label>How many?</label>
                        <input type="number" id="quantity" name="quantity" value="1" title="quantity" class="form-control">

                            <div class="text-center mt-3 btn-group btn-group-sm">
                                <input type="submit"  name="addtocart" id="addtocart" class="btn btn-outline-dark btn-sm addtocart" value="Add to Cart">
                                    <a class="btn btn-outline-dark btn-sm" href="#">View options</a>
                            </div>

                    </form>


                  </div>
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




<!-- Modal-->
<div class="modal fade" id="myCart" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">My Cart</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <table class="table">
                    <thead>
                    <th>Image</th>
                    <th>Product Name</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Sub Total</th>
                    <th>Actions</th>
                    </thead>

                    <?php

                    $id = $row['id'];

                    $total_price = 0;

                    $sql = "SELECT * FROM cart INNER JOIN products ON products.id = cart.product_id WHERE cart.user_id = '$id'";
                    $result = mysqli_query($con, $sql);
                    if (mysqli_num_rows($result) > 0){
                        while($cart = mysqli_fetch_assoc($result)){

                            $total_price += $cart['product_price'] * $cart['quantity'];

                            ?>

                            <tr>
                                <td>  <img width="100px" src="<?php echo WEBSITE_DOMAIN . $cart['product_image']?>"></td>
                                <td><?php echo $cart['product_name']?></td>
                                <td><?php echo $cart['quantity']?></td>
                                <td>₱<?php echo number_format($cart['product_price'])?></td>
                                <td>₱<?php echo number_format($cart['product_price'] * $cart['quantity']); ?></td>
                                <td><a href="delete_cart.php?product_id=<?php echo $cart['product_id']; ?>&customer_id=<?php echo $cart['user_id'];?>" class="btn btn-sm btn-danger">Delete</a></td>
                            </tr>

                            <?php

                        }

                    } else {
                        echo "<tr><td colspan='6'>Your cart is empty</td></tr>";
                    }

                    ?>

                    <tr>
                        <td colspan="5" style="text-align: right">Total Price:</td>
                        <td colspan="1" style="text-align: right">₱<?php echo number_format($total_price); ?></td>
                    </tr>
                </table>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" ></script>
</body>
</html>