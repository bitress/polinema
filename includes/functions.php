<?php

    function countCart($con, $user){
        $query = "SELECT COUNT(*) as count FROM cart WHERE user_id = '$user'";
        $result = mysqli_query($con, $query);
        $row = mysqli_fetch_assoc($result);
        return $row['count'];
    }


    function generateCategoryOptions($con, $product){

        $sql = "SELECT * FROM category";
            $result = mysqli_query($con, $sql);
            while ($category = mysqli_fetch_assoc($result)){

                $selected = $product == $category['category_id'] ? 'selected' : '';

             echo '<option value="'.$category['category_id'].'" '. $selected .' >'.$category['category_name'].'</option>'  ;

            }

    }
