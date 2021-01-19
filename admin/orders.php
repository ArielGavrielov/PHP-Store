<!DOCTYPE html>
<html lang="en">
    <head>
        <?php 
        include_once 'extra.php';
        include_once '../dbcontroller.php';
        $db_handle = new DBController();
        ?>
    </head>

    <body>
    <br/>
        <div class="container-fluid">
            <?php
            $orders = $db_handle->runQuery("SELECT * FROM orders_id");
    
            if (count($orders) > 0) {
                foreach($orders as $row) {
                    $id = $row['id'];
                    $accountName = $db_handle->runQuery("SELECT Aname FROM accounts WHERE id='{$row["accountid"]}'")[0]['Aname'];
                    $date = $row['dateoforder'];
                    $address = $row['address'];
                    ?>
                    <h1 class="text-center"><?php echo "Order number: $id, Name: $accountName, Date: $date, Address: $address" ?></h1>
                    <table class="table">
                        <thead class="thead-light">
                            <tr style="text-align:center;">
                                <th scope="col">Product</th>
                                <th scope="col">Quantity</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $order_items = $db_handle->runQuery("SELECT productID,quantity FROM order_items WHERE order_id=$id");
  
                            foreach($order_items as $item) {
                                $productID = $item['productID'];                                    $productTitle = $db_handle->runQuery("SELECT title FROM product WHERE id='$productID'")[0]['title'];
                                $quan = $item['quantity'];
                                ?>
                                <tr style='text-align:center;'>
                                    <td><?php echo $productTitle; ?></td>
                                    <td><?php echo $quan; ?></td>
                                </tr>
                                <?php

                            }
                            ?> 
                            </tbody>
                            </table>
                            <hr/>
                            <?php
                        }
                    }
                    else {
                        ?><h1 class="text-center">There is no orders. :(</h1> <?php
                    }
                    $db_handle->closeSql(); ?>
        </div>            
    </body>
</html>
