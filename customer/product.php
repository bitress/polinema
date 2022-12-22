<?php

include_once '../includes/connection.php';

if (isset($_GET['id'])){
    $id = $_GET['id'];

    $sql = "SELECT * FROM `products` LEFT JOIN `category` ON `category`.category_id = products.category WHERE products.id = '$id'";
    $result = mysqli_query($con, $sql);
    $res = mysqli_fetch_assoc($result);
}

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
        header("Location: product.php?id=". $product);
    } else {
        // Item is not in the cart, insert new row
        mysqli_query($con, "INSERT INTO `cart` (product_id, user_id, quantity) VALUES ('$product', '$user_id', '$quantity')");
        header("Location: product.php?id=". $product);
    }
}

if (isset($_POST['checkout'])){
    $checkBox = implode(',', $_POST['product']);
    echo $checkBox;
}


if (isset($_POST['editProfile'])){

    $id = $row['id'];
    $firstname = $_POST['firstname'];
    $middlename = $_POST['middlename'];
    $lastname = $_POST['lastname'];
    $address = $_POST['address'];
    $password = $_POST['password'];

    if ($password == ""){
        // Dont change password
        $newpassword = $row['password'];
    } else {
        $newpassword = md5($password);
    }

    $sql = "UPDATE users SET password = '$newpassword', firstname = '$firstname', middlename = '$middlename', lastname = '$lastname', address = '$address' WHERE id = '$id'";
    $result = mysqli_query($con, $sql);

    if ($result === TRUE){

        header("Location: index.php?success=Profile edit success!");

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

                <button data-bs-toggle="modal" data-bs-target="#myCart" href="#" class="btn btn-outline btn-sm" type="button">
                    <i class="bi-cart-fill me-1"></i>
                    Cart
                    <span class="badge bg-dark text-white ms-1 rounded-pill"><?php echo countCart($con, $row['id'])?></span>
                </button>

                <button data-bs-toggle="modal" data-bs-target="#myProfile" href="#" class="btn btn-outline-dark btn-sm" type="button">
                    <i class="bi-person me-1"></i>
                    Profile
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
    <form action="product.php" method="post">
        <input type="hidden" name="product_id" value="<?php echo $res['id']?>">
    <div class="container px-4 px-lg-5 my-5">
        <div class="row gx-4 gx-lg-5 align-items-center">
            <div class="col-md-6"><img class="card-img-top mb-5 mb-md-0" src="<?php echo WEBSITE_DOMAIN . $res['product_image']?>" alt="..." /></div>
            <div class="col-md-6">
                <div class="small mb-1"><?php echo $res['category_name']; ?></div>
                <h1 class="display-5 fw-bolder"><?php echo $res['product_name']; ?></h1>
                <div class="fs-5 mb-5">
                    <span>₱<?php echo number_format($res['product_price'])?></span>
                </div>
                <div class="d-flex">
                    <input class="form-control text-center me-3" name="quantity" type="text" value="1" style="max-width: 3rem" />
                    <input type="submit"  name="addtocart" id="addtocart" class="btn btn-outline-dark flex-shrink-0 addtocart" value="Add to Cart">
                </div>
            </div>
        </div>
    </div>
    </form>

</section>
<!-- Related items section-->
<section class="py-5 bg-light">
    <div class="container px-4 px-lg-5 mt-5">
        <h2 class="fw-bolder mb-4">Related products</h2>
        <div class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center">

            <?php
            $category = $res['category_id'];
            $id = $res['id'];
            $sql = "SELECT * FROM products LEFT JOIN category ON category.category_id = products.category WHERE category = '$category' AND NOT id = '$id' LIMIT 4";
            $result = mysqli_query($con, $sql);
            if (mysqli_num_rows($result) > 0){
            while($product = mysqli_fetch_assoc($result)){
            ?>
            <div class="col mb-5">
                <div class="card h-100" >
                    <form action="product.php" method="post">
                        <input type="hidden" name="product_id" value="<?php echo $product['id']?>">
                        <!-- Product image-->
                        <div class="img-wrap">
                            <img  width="450px" height="300px" class="card-img-top" src="<?php echo WEBSITE_DOMAIN . $product['product_image']?>" alt="..." />
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
                            <label>How many?</label>
                            <input type="number" id="quantity" name="quantity" value="1" title="quantity" class="form-control">

                        </div>
                        <!-- Product actions-->
                        <div class="card-footer p-4 pt-0 border-top-0 bg-transparent">

                            <div class="btn-group btn-group-sm">
                                <input type="submit"  name="addtocart" id="addtocart" class="btn btn-outline-dark btn-sm addtocart" value="Add to Cart">
                                <a class="btn btn-outline-dark btn-sm" href="product.php?id=<?php echo $product['id']?>">View options</a>
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
            <form action="checkout.php" method="post">

            <div class="modal-body">

                <div class="table-responsive">
                    <table class="table">
                        <thead>
                        <th>Select</th>
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
                        $count = 0;
                        if (mysqli_num_rows($result) > 0){
                            while($cart = mysqli_fetch_assoc($result)){
                                $count += 1;

                                $total_price += $cart['product_price'] * $cart['quantity'];

                                ?>

                                <tr>
                                    <td>
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" name="product[]" value="<?php echo $cart['product_id']; ?>" class="custom-control-input">
                                            <input type="hidden" value="<?php echo $cart['quantity']?>" name="quantity[]">
                                        </div>
                                    </td>
                                    <td>  <img width="100px" src="<?php echo WEBSITE_DOMAIN . $cart['product_image']?>" alt=""></td>
                                    <td><?php echo $cart['product_name']?></td>
                                    <td><?php echo $cart['quantity']?></td>
                                    <td>₱<?php echo number_format($cart['product_price'])?></td>
                                    <td>₱<?php echo number_format($cart['product_price'] * $cart['quantity']); ?></td>
                                    <td><a href="delete_cart.php?product_id=<?php echo $cart['product_id']; ?>&customer_id=<?php echo $cart['user_id'];?>" class="btn btn-sm btn-danger">Delete</a></td>
                                </tr>



                                <?php

                            }


                        } else {
                            echo "<tr><td colspan='8'>Your cart is empty</td></tr>";
                        }

                        ?>

                        <tr>
                            <td colspan="5" style="text-align: right">Total Price:</td>
                            <td colspan="1" style="text-align: right">₱<?php echo number_format($total_price); ?></td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <?php
                if ($count > 0){
                ?>
                <button type="submit" name="checkout" class="btn btn-success">Checkout</button>
                <?php
                }
                ?>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
            </form>
        </div>
    </div>
</div>


<!-- Modal-->
<div class="modal fade" id="myProfile" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">My Profile</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <button class="btn btn-primary mb-2" data-bs-target="#editProfile" data-bs-toggle="modal" type="button">Edit Profile</button>

                <table class="table table-bordered">
                    <tr>
                        <td>Firstname</td>
                        <td><?php echo $row['firstname']; ?></td>
                    </tr>
                    <tr>
                        <td>Middlename</td>
                        <td><?php echo $row['middlename']; ?></td>
                    </tr>
                    <tr>
                        <td>Lastname</td>
                        <td><?php echo $row['lastname']; ?></td>
                    </tr>
                    <tr>
                        <td>Username</td>
                        <td><?php echo $row['username']; ?></td>
                    </tr>
                    <tr>
                        <td>Address</td>
                        <td><?php echo $row['address']; ?></td>
                    </tr>
                </table>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal-->
<div class="modal fade" id="editProfile" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">My Profile</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <form method="post" action="index.php">

                    <div class="row">
                        <div class="col-md-4">
                            <label>Enter you firstname</label>
                            <input type="text" class="form-control" name="firstname" value="<?php echo $row['firstname']; ?>">
                        </div>

                        <div class="col-md-4">
                            <label>Enter you middlename</label>
                            <input type="text" class="form-control" name="middlename" value="<?php echo $row['middlename']; ?>">
                        </div>

                        <div class="col-md-4">
                            <label>Enter you lastname</label>
                            <input type="text" class="form-control" name="lastname" value="<?php echo $row['lastname']; ?>">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label>Enter you address</label>
                        <input type="text" class="form-control" name="address" value="<?php echo $row['address']; ?>">
                    </div>

                    <div class="mb-3">
                        <label>Enter your new password</label>
                        <input type="password" class="form-control" name="password" value="">
                    </div>

                    <div class="mb-3">
                        <button type="submit" name="editProfile" class="btn btn-success">Save</button>
                    </div>

                </form>


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