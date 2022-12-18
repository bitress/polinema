<?php

include_once 'includes/connection.php';

if (isset($_SESSION['isLoggedIn'])){
    if (isset($_SESSION['admin'])) {
        header("Location: admin/index.php");
    } else {
        header("Location: customer/index.php");
    }
}

if (isset($_POST['submit'])) {

    $username = $_POST["username"];
    $password = md5($_POST["password"]);

    $query = "SELECT * FROM users WHERE username='$username'";
    $result = mysqli_query($con, $query);
    $row = mysqli_fetch_assoc($result);
    if(mysqli_num_rows($result) > 0){

        if ($row['password'] === $password){
            if ($row['level'] == "customer") {

                $_SESSION['isLoggedIn'] = true;
                $_SESSION['id'] = $row['id'];

                header("Location: customer/index.php");
            } else if ($row['level'] == "admin") {
                $_SESSION['isLoggedIn'] = true;
                $_SESSION['admin'] = true;
                $_SESSION['id'] = $row['id'];
                header("Location: admin/index.php");
            } else {
                header("Location: index.php?error=failed");
            }
        } else {
            header("Location: index.php?error=Incorrect Password");
        }
    } else {

        header("Location: index.php?error=No user found with that username");
    }

}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Login | ShopOn-it</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous"></head>

<body>
<section class="h-100">
    <div class="container h-100">
        <div class="row justify-content-sm-center h-100">
            <div class="col-xxl-4 col-xl-5 col-lg-5 col-md-7 col-sm-9">
                <div class="text-center my-5">
                    <img src="FessItUp-1.png" alt="logo" width="100">
                </div>
                <div class="card shadow-lg">
                    <div class="card-body p-5">
                        <h1 class="fs-4 card-title fw-bold mb-4">Welcome to ShopOn-it</h1>

                        <?php
                        if (isset($_GET['error'])){
                            $error = $_GET['error'];
                        ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>Holy guacamole!</strong> <?= $error ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                        <?php } ?>

                        <?php
                        if (isset($_GET['success'])){
                            $success = $_GET['success'];
                        ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <strong>Nice!</strong> <?= $success ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                        <?php } ?>

                        <form method="POST" action="index.php">
                            <div class="mb-3">
                                <label class="mb-2 text-muted" for="username">Username</label>
                                <input id="username" type="text" class="form-control" name="username" value="" required autofocus>
                            </div>

                            <div class="mb-3">
                                <div class="mb-2 w-100">
                                    <label class="text-muted" for="password">Password</label>
                                </div>
                                <input id="password" type="password" class="form-control" name="password" required>
                            </div>

                            <div class="d-flex align-items-center">
                                <button type="submit" name="submit" class="btn btn-primary ms-auto">
                                    Login
                                </button>
                            </div>
                        </form>
                    </div>
                    <div class="card-footer py-3 border-0">
                        <div class="text-center">
                            Don't have an account? <a href="register.php" class="text-dark">Create One</a>
                        </div>
                    </div>
                </div>
                <div class="text-center mt-5 text-muted">
                    Copyright &copy; 2022 &mdash; ShopOn-it
                </div>
            </div>
        </div>
    </div>
</section>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" ></script>
</body>
</html>