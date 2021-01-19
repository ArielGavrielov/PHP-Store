<?php
session_start();
require_once("../dbcontroller.php");
require_once("javascript.php");
$db_handle = new DBController();

if(!empty($_GET["action"])) {
	switch($_GET["action"]) {
		case "remove":
			if(!empty($_SESSION["cart_item"])) {
				foreach($_SESSION["cart_item"] as $k => $v) {
						if($_GET["id"] == $v["id"])
							unset($_SESSION["cart_item"][$k]);				
						if(empty($_SESSION["cart_item"]))
							unset($_SESSION["cart_item"]);
				}
			}
		break;
		case "empty":
			unset($_SESSION["cart_item"]);
		break;	
	}
}
?>
<html>
<head>
<title>Simple PHP Shopping Cart</title>
<link href="style.css" type="text/css" rel="stylesheet" />
</HEAD>
<BODY>
<div id="shopping-cart text-center">
<div class="txt-heading text-center">Shopping Cart</div>
<?php
if(isset($_SESSION["cart_item"])){
    $item_total = 0;
?>	
<?php foreach ($_SESSION["cart_item"] as $item) { 
		$product_info = $db_handle->runQuery("SELECT * FROM product WHERE id =" . $item["id"]);
?>
	<div class="product-item" onMouseOver="document.getElementById('<?php echo $item["id"]; ?>').style.display='block';"  onMouseOut="document.getElementById('<?php echo $item["id"]; ?>').style.display='';" >
		<div class="product-image mx-auto"><img class="card-img-top" src="<?php echo $product_info[0]["img"]; ?>"></div></br>
		<div><strong><?php echo $item["name"]; ?></strong></div>
		<div class="product-price"><?php echo "$".$item["price"]; ?></div>
		<div><span>Quantity: <?php echo $item["quantity"]; ?></span></div>
		<div><span>
			<?php
			$checkoutEnabled = false; 
			if($product_info[0]["quantity"] == 0)
				echo "Out of stock."; 
			else if($product_info[0]["quantity"] < $item["quantity"])
				echo "Only ". $product_info[0]["quantity"]. " on stock.";
			else $checkoutEnabled = true;
			?>
		</span></div>
		<div class="btnRemoveAction" id="<?php echo $item["id"]; ?>"><a href="?action=remove&id=<?php echo $item["id"]; ?>" title="Remove from Cart">x</a></div>
	</div>
<?php
	}
?>
<div class="cart_footer_link">
	<span>Total: <?php 
		$total = 0;
		foreach($_SESSION["cart_item"] as $item)
			$total += $item['price']*$item['quantity'];
		echo $total;
	 ?>
	 </span>
	<?php if($checkoutEnabled) echo '<a href="checkout.php">Checkout</a>'; ?>
	<a href="index.php?action=empty">Clear Cart</a>
	<a href="../products.php" title="Cart">Continue Shopping</a>
</div>
</div>
<?php 
} else {
	?> <h1 class="text-center">Cart is empty.</h1> <?php
}
?>

<script>
function toggleAction(id) {
	if(document.getElementById("remove"+id).style.display == 'none') {
		document.getElementById("remove"+id).style.display = 'block';
	} else {
		document.getElementById("remove"+id).style.display = 'none';
	}
}
</script>
</BODY>
</HTML>