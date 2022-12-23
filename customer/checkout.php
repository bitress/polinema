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


if (isset($_POST['continue_checkout'])){

    $user = $_POST['user'];
    $product = $_POST['checkout_products'];

    $product = explode(',', $product);

        foreach ($product as $p){

            $sql = "INSERT INTO checkout (`user_id`, `cart_id`) VALUES ('$user', '$p')";
            $result = mysqli_query($con, $sql);
        }

        header("Location: delivery.php");
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
    <div class="container px-4 px-lg-5 mt-5">

            <div class="row">
                <div class="col-md-4 order-md-2 mb-4">
                    <h4 class="d-flex justify-content-between align-items-center mb-3">
                        <span class="text-muted">Your cart</span>
                        <span class="badge badge-secondary badge-pill">3</span>
                    </h4>
                    <ul class="list-group mb-3">

                        <?php
                        if (isset($_POST['checkout'])) {
                            $id = $row['id'];
                            $cart =  implode(',', $_POST['product']);

                            $sql = "SELECT cart.product_id, cart.user_id, cart.quantity, products.*, category.* FROM cart INNER JOIN products ON products.id = cart.product_id INNER JOIN users ON users.id = cart.user_id LEFT JOIN category ON category.category_id = products.category WHERE cart.cart_id IN ($cart) AND users.id = '$id'";
                            $result = mysqli_query($con, $sql);
                            $total_price1 = 0;
                              while ($cart = mysqli_fetch_array($result)){
                                    $total_price1 += $cart['product_price'] * $cart['quantity'];

                                ?>
                        <li class="list-group-item d-flex justify-content-between lh-condensed">
                            <div>
                                <h6 class="my-0"><?php echo $cart['product_name'] ?> (<?php echo $cart['quantity'] ?>)</h6>
                                <small class="text-muted"><?php echo $cart['category_name'] ?></small>
                            </div>
                            <span class="text-muted">₱<?php echo number_format($cart['product_price']) ?></span>
                        </li>
                        <?php

                            }
                        }?>

                        <li class="list-group-item d-flex justify-content-between">
                            <span>Total (PHP)</span>
                            <strong>₱<?php echo number_format($total_price1) ?></strong>
                        </li>
                    </ul>
                </div>
                <div class="col-md-8 order-md-1">
                    <h4 class="mb-3">Billing address</h4>
                    <form class="needs-validation" novalidate>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="firstName">First name</label>
                                <input type="text" class="form-control" id="firstName" placeholder="" value="<?php echo $row['firstname'] ?>" required>
                                <div class="invalid-feedback">
                                    Valid first name is required.
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="lastName">Last name</label>
                                <input type="text" class="form-control" id="lastName" placeholder="" value="<?php echo $row['lastname'] ?>" required>
                                <div class="invalid-feedback">
                                    Valid last name is required.
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="username">Username</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">@</span>
                                </div>
                                <input type="text" class="form-control" id="username" value="<?php echo $row['username'] ?>" placeholder="Username" required>
                                <div class="invalid-feedback" style="width: 100%;">
                                    Your username is required.
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="email">Email <span class="text-muted">(Optional)</span></label>
                            <input type="email" class="form-control" id="email" placeholder="you@example.com">
                            <div class="invalid-feedback">
                                Please enter a valid email address for shipping updates.
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="address">Address</label>
                            <input type="text" class="form-control" id="address" placeholder="" value="<?php echo $row['address'] ?>" required>
                            <div class="invalid-feedback">
                                Please enter your shipping address.
                            </div>
                        </div>


                        <div class="row">
                            <div class="col-md-5 mb-3">
                                <label for="country">Country</label>
                                <select class="custom-select d-block w-100" id="country" required>
                                    <option value="">Choose...</option>
                                    <option>Philippines</option>
                                </select>
                                <div class="invalid-feedback">
                                    Please select a valid country.
                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="state">State</label>
                                <select class="custom-select d-block w-100" id="state" required>
                                    <option value="">Choose...</option>
                                    <option>Tagudin</option>
                                </select>
                                <div class="invalid-feedback">
                                    Please provide a valid state.
                                </div>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="zip">Zip</label>
                                <input type="text" class="form-control" id="zip" placeholder="" required>
                                <div class="invalid-feedback">
                                    Zip code required.
                                </div>
                            </div>
                        </div>


                        <hr class="mb-4">

                        <h4 class="mb-3">Payment</h4>

                        <div class="d-block my-3">
                            <div class="custom-control custom-radio">
                                <input id="credit" name="paymentMethod" type="radio" class="custom-control-input" checked required>
                                <label class="custom-control-label" for="card">Debit/Credit card</label>
                            </div>
                            <div class="custom-control custom-radio">
                                <input id="debit" name="paymentMethod" type="radio" class="custom-control-input" required>
                                <label class="custom-control-label" for="cod">Cash On Delivery</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="cc-name">Name on card</label>
                                <input type="text" class="form-control" id="cc-name" placeholder="" required>
                                <small class="text-muted">Full name as displayed on card</small>
                                <div class="invalid-feedback">
                                    Name on card is required
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="cc-number">Credit card number</label>
                                <input type="text" class="form-control" id="cc-number" placeholder="" required>
                                <div class="invalid-feedback">
                                    Credit card number is required
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3 mb-3">
                                <label for="cc-expiration">Expiration</label>
                                <input type="text" class="form-control" id="cc-expiration" placeholder="" required>
                                <div class="invalid-feedback">
                                    Expiration date required
                                </div>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="cc-cvv">CVV</label>
                                <input type="text" class="form-control" id="cc-cvv" placeholder="" required>
                                <div class="invalid-feedback">
                                    Security code required
                                </div>
                            </div>
                        </div>
                    </form>

                    <hr class="mb-4">
                        <form method="post" action="checkout.php">
                       <?php

                       if (isset($_POST['checkout'])) {
                            ?>
                               <input type="hidden" name="checkout_products" value="<?php echo implode(',', $_POST['product']);?>">
                               <input type="hidden" name="user" value="<?php echo $row['id'] ?>">
                            <button class="btn btn-primary btn-lg btn-block" name="continue_checkout" type="submit">Continue to checkout</button>
                           <?php
                             }
                           ?>
                        </form>
                </div>
            </div>


        </div>

</section>



<?php

include_once '../includes/modal.php';

?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" ></script>
<script src="https://code.jquery.com/jquery-3.6.3.min.js" integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU=" crossorigin="anonymous"></script>
</body>
</html>