<?php

    function countCart($con, $user){
        $query = "SELECT COUNT(*) as count FROM cart WHERE user_id = '$user'";
        $result = mysqli_query($con, $query);
        $row = mysqli_fetch_assoc($result);
        return $row['count'];
    }

