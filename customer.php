<?php

include_once 'connection.php';

if (isset($_SESSION['isLoggedIn'])){
    $id = $_SESSION['id'];


    $sql = "SELECT * FROM users INNER JOIN user_details ON users.id = user_details.user_id WHERE users.id = '$id'";
    $result = mysqli_query($con, $sql);
    $row = mysqli_fetch_assoc($result);

} else {
    header("Location: index.php");
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
        header("Location: customer.php");
    } else {
        // Item is not in the cart, insert new row
        mysqli_query($con, "INSERT INTO `cart` (product_id, user_id, quantity) VALUES ('$product', '$user_id', '$quantity')");
        header("Location: customer.php");
    }
}



?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Home | ShopOn-it</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous"></head>
    <link rel="stylesheet" href="css/style.css">
<body>

<nav class="navbar navbar-expand-lg bg-light">
    <div class="container-fluid">
        <a class="navbar-brand" href="customer.php">ShopOn-it</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="customer.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="modal" data-bs-target="#myCart" href="#">My Cart</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<header >
    <div class="container-fluid text-sm-center p-5 bg-light">
        <h1 class="display-6">Welcome <?php echo $row['firstname'] .' ' . $row['middlename'] . ' '. $row['lastname'] ?></h1>
        <p class="lead">Have fun shopping!</p>
    </div>
</header>

<div class="container py-5">
    <div class="row">

        <?php

            $sql = "SELECT * FROM products";
            $result = mysqli_query($con, $sql);
            if (mysqli_num_rows($result) > 0){
            while($product = mysqli_fetch_assoc($result)){
        ?>

        <div class="col-md-4">
                <div class="card card-product-grid">
                    <form action="customer.php" method="post">
                        <input type="hidden" name="product_id" value="<?php echo $product['id']?>">
                    <div class="img-wrap">
                        <img src="<?php echo $product['product_image']?>">
                    </div>
                    <div class="info-wrap">
                        <div class="fix-height">
                            <p class="title"><?php echo $product['product_name']?></p>
                            <div class="price-wrap mt-2">
                                <span class="price"> &#8369;<?php echo $product['product_price']?></span>
                            </div>
                        </div>
                        <div class="quantity">
                            <label>How many?</label>
                            <input type="number" id="quantity" name="quantity" value="1" title="quantity" class="form-control">
                        </div>
                        <div class="mt-3">
                            <input type="submit"  name="addtocart" id="addtocart" class="btn btn-block btn-primary addtocart" value="Add to Cart">
                        </div>
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


<!-- Modal -->
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
                        <td>  <img width="100px" src="<?php echo $cart['product_image']?>"></td>
                        <td><?php echo $cart['product_name']?></td>
                        <td><?php echo $cart['quantity']?></td>
                        <td><?php echo $cart['product_price']?></td>
                        <td><?php echo $cart['product_price'] * $cart['quantity']; ?></td>
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
                        <td colspan="1" style="text-align: right"><?php echo $total_price; ?></td>
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