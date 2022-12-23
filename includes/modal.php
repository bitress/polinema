
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
                                                <input type="checkbox" name="product[]" value="<?php echo $cart['cart_id']; ?>" class="custom-control-input">
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
