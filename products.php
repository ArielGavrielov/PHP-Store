<!DOCTYPE html>
<html>
<head>
<?php
session_start();
require_once("dbcontroller.php");
$db_handle = new DBController();
require_once("javascript.php");
?>
<link href="productstyle.css" rel="stylesheet"/>
</head>
<body>
<?php
$session_items = 0;
if(!empty($_SESSION["cart_item"])){
	$session_items = count($_SESSION["cart_item"]);
}	
?>
<div id="product-grid">
	<div class="txt-heading">Products</div>
	<?php
    $product_array = $db_handle->runQuery("SELECT * FROM product ORDER BY id ASC");
	if (!empty($product_array)) { 
		foreach($product_array as $key=>$value){
	?>
		<div class="product-item">
			<form method="POST" action="products.php">
                <input type="hidden" name="id" value="<?php echo $product_array[$key]["id"] ?>"/>
                <img class="card-img-top product-image mx-auto" src="<?php echo $product_array[$key]["img"]; ?>">
                <div><strong><?php echo $product_array[$key]["title"]; ?></strong></div>
                <div><?php echo $product_array[$key]["detail"]; ?></div>
                <div class="product-price"><?php echo "$".$product_array[$key]["price"]; ?></div>
                <div><input type="number" name="quan" value="1" min="1" />
                <input type="submit" name="add" <?php echo ($product_array[$key]["quantity"] == 0) ? "value='Out of stock' disabled" : "value='Add to cart'"; ?> class="btnAddAction" /></div>
                <div id="error-<?php echo $product_array[$key]["id"] ?>" class="d-none"><small class="form-text text-muted">Only <?php echo $product_array[$key]["quantity"]; ?> left.</small></div>
			</form>
		</div>
	<?php
			}
	}
	?>
</div>
</body>
</html>

<?php
if($_POST["add"]) {
	if(!empty($_POST["quan"])) {
        $productByID = $db_handle->runQuery("SELECT * FROM product WHERE id='" . $_POST["id"] . "'");
        $itemArray = array($productByID[0]["id"]=>array('title'=>$productByID[0]["title"], 'id'=>$productByID[0]["id"], 'quantity'=>$_POST["quan"], 'price'=>$productByID[0]["price"]));
		if(!empty($_SESSION["cart_item"])) {
			if(in_array($productByID[0]["id"],array_column($_SESSION["cart_item"], 'id'))) {
				foreach($_SESSION["cart_item"] as $k => $v) {
					if($productByID[0]["id"] == $v["id"]) {
                        if(($_SESSION["cart_item"][$k]["quantity"] + $_POST["quan"]) <= $productByID[0]["quantity"]) {
                            $_SESSION["cart_item"][$k]["quantity"] += $_POST["quan"];
                        }
                        else {
                            ?>
                            <script>
                                document.getElementById("error-<?php echo $productByID[0]["id"]; ?>").classList.remove('d-none');
                            </script>
                            <?php
                        }
                    }
				}
			} else {
                if($_POST["quan"] > $productByID[0]["quantity"]) {
                    ?>
                        <script>
                            document.getElementById("error-<?php echo $productByID[0]["id"]; ?>").classList.remove('d-none');
                        </script>
                    <?php
                }
                else
				    $_SESSION["cart_item"] = array_merge($_SESSION["cart_item"],$itemArray);
			}
		} else {
            if(isset($_SESSION["loggedin"])) {
                if($_POST["quan"] > $productByID[0]["quantity"]) {
                    ?>
                        <script>
                            document.getElementById("error-<?php echo $productByID[0]["id"]; ?>").classList.remove('d-none');
                        </script>
                    <?php
                }
                else {
                    $_SESSION["cart_item"] = $itemArray;
                    $_SESSION["cart_expire"] = time() + (60*60*24*14); // 2 weeks
                }
            } else {
                ?>
                <script>
                if (confirm('You need login first, you want login now?'))
                    location.replace("login.php");
                </script>
                <?php
            }
		}
	}
}
?>