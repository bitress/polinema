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




<?php

include_once '../includes/modal.php';

?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" ></script>
<script src="https://code.jquery.com/jquery-3.6.3.min.js" integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU=" crossorigin="anonymous"></script>
</body>
</html>