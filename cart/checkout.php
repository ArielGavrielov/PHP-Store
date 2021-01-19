<?php
    session_start();
    require_once("../dbcontroller.php");
    require_once("javascript.php");
    $db_handle = new DBController();

    if($_POST['checkout'] && !empty($_SESSION["cart_item"])) {
        $db_handle->runQuery("INSERT INTO `orders_id`(`accountID`, `DateOfOrder`, `address`) VALUES ('{$_SESSION["id"]}', CURRENT_TIMESTAMP, '{$_POST["address"]}')");
        $order_id = $db_handle->runQuery("SELECT LAST_INSERT_ID() FROM `orders_id`")[0]["LAST_INSERT_ID()"];
        
        foreach($_SESSION["cart_item"] as $item) {
            $db_handle->runQuery("INSERT INTO `order_items`(`order_id`, `productID`, `quantity`) 
            VALUES($order_id, '{$item["id"]}', '{$item["quantity"]}')");
            echo $db_handle->getConn()->error;
            $current = $db_handle->runQuery("SELECT quantity FROM product WHERE id=".$item["id"]);
            $db_handle->runQuery("UPDATE product SET quantity='{$current[0]["quantity"]}'-'{$item["quantity"]}' WHERE id=".$item["id"]);
        }
        unset($_SESSION["cart_item"]);
        unset($_SESSION["cart_expire"]);
        header("Location: thanks.php");
    }
?>
<html>
    <head>
        <link href="style.css" type="text/css" rel="stylesheet" />
    </head>
    <body>
        <div id="shopping-cart text-center">
            <div class="txt-heading text-center">Checkout</div>
            <?php
                $isOK = true;
                foreach($_SESSION["cart_item"] as $item) {
                    $product = $db_handle->runQuery("SELECT * FROM `product` WHERE id=".$item["id"])[0];
        
                    if($product["quantity"] < $item["quantity"]) {
                        echo "\nThere is no stock for product ". $product["title"];
                        $isOK = false;
                    }
                }
                if($isOK) {
            ?>
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" class="text-center">
                    <div class="form-group">
                        <label>Name on card</label>
                        <input type="text" name="name" />
                    </div>    
                    <div class="form-group">
                        <label>Address</label>
                        <input type="text" name="address">
                    </div>
                    <div class="form-group">
                        <label>Card number</label>
                        <input type="text" name="card">
                    </div>
                    <div class="form-group">
                        <label>Card expire</label>
                        <input type="number" name="month" size="2"/>
                        <input type="number" name="year" size="4"/>
                    </div>
                    <div class="form-group">
                        <input type="submit" class="btn btn-primary" name="checkout" value="Checkout">
                    </div>
                </form>
            </div> 
        <?php } ?>