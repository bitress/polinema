<?php

include_once 'connection.php';

if (isset($_SESSION['isLoggedIn']) && isset($_SESSION['admin'])){

    $id = $_SESSION['id'];

    $sql = "SELECT * FROM users WHERE users.id = '$id'";
    $result = mysqli_query($con, $sql);
    $row = mysqli_fetch_assoc($result);

} else {
    header("Location: index.php");
}

    if (isset($_POST['addProduct'])){

        $product_name = $_POST['product_name'];
        $product_price = $_POST['product_price'];

        if(isset($_FILES['product_image'])){
            $error = "";
            $file_name = $_FILES['product_image']['name'];
            $file_tmp = $_FILES['product_image']['tmp_name'];

            // Get file extension
            $array = explode('.', $_FILES['product_image']['name']);
            $file_ext=strtolower(end($array));

            $extensions= array("jpeg","jpg","png");

            if(in_array($file_ext,$extensions)=== false){
                $error ="Please choose a JPEG or PNG file.";
            }

            if($error == "") {
                $product_image = "products/".$file_name;
                move_uploaded_file($file_tmp,"products/".$file_name);

                $sql = "INSERT INTO products (product_name, product_price, product_image) VALUES ('$product_name', '$product_price', '$product_image')";
                mysqli_query($con, $sql);
                header("Location: admin.php");

            }else{
                print_r($error);
            }
        }

    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Admin | ShopOn-it</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous"></head>
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" type="text/css">
    <script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" type="text/javascript"></script>
<body>

<nav class="navbar navbar-expand-lg bg-light">
    <div class="container-fluid">
        <a class="navbar-brand" href="admin.php">ShopOn-it</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="admin.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" aria-current="page" href="logout.php">Logout</a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<header >
    <div class="container-fluid text-sm-center p-5 bg-light">
        <h1 class="display-6">Welcome admin</h1>
        <p class="lead">Have fun managing!</p>
    </div>
</header>

<div class="container pt-4">
    <div class="row">

        <div class="col-lg-2 col-md-3">
            <div class="list-group list-group-borderless">
                <a href="admin.php" class="list-group-item list-group-item-action ">
                    Manage Products
                </a>

                <a href="manage-customer.php" class="list-group-item list-group-item-action ">
                    Manage Customers
                </a>
            </div>
        </div>


        <div class="col-md-9 col-lg-10 mt-2">
            <div>
                <a class="btn btn-success d-block d-sm-inline-block"
                   id="btn-show-user-modal"
                   data-bs-toggle="modal" data-bs-target="#addProduct">
                    Add Products
                </a>
            </div>

            <table class="table" id="myTable">
                <thead>
                    <th>Product Image</th>
                    <th>Product ID</th>
                    <th>Product Name</th>
                    <th>Product Price</th>
                    <th>Actions</th>
                </thead>
                <tbody>
                <?php

                $sql = "SELECT * FROM products";
                $result = mysqli_query($con, $sql);
                if (mysqli_num_rows($result) > 0){
                while($product = mysqli_fetch_assoc($result)){
                ?>
                    <tr>
                        <td><img width="50px" src="<?php echo $product['product_image']?>"></td>
                        <td><?php echo $product['id']?></td>
                        <td><?php echo $product['product_name']?></td>
                        <td><?php echo $product['product_price']?></td>
                        <td><div class="btn-group">
                                <a class="btn btn-primary">Edit</a>
                                <a class="btn btn-danger" href="delete-product.php?id=<?php echo $product['id']?>">Delete</a>
                            </div></td>
                    </tr>
                <?php
                 }
                }
                ?>
                </tbody>
            </table>
    </div>
</div>


    <div class="modal fade" id="addProduct" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Add Product</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form enctype="multipart/form-data" action="admin.php" method="post">
                <div class="modal-body">
                        <div class="mb-3">
                            <label>Product Image</label>
                            <input type="file" name="product_image" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label>Product Name</label>
                            <input type="text" name="product_name" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label>Product Price</label>
                            <input type="number" name="product_price" class="form-control">
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" name="addProduct" class="btn btn-primary">Save changes</button>
                </div>
                </form>
            </div>
        </div>
    </div>


    <script>
    const dataTable = new simpleDatatables.DataTable("#myTable", {
    })
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" ></script>
</body>
</html>