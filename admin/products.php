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
    <?php
    include_once '../db-connect.php';
    if($_POST['add']) {
        if(isset($_FILES['uploadImage'])) {
            if(!is_dir("../uploads/".$_POST["title"]))
                mkdir("../uploads/".$_POST["title"], 0777);

            $file_dir = "/uploads/".$_POST["title"]."/" . str_replace(" ", "-", $_FILES['uploadImage']['name']);
            if(!move_uploaded_file($_FILES['uploadImage']['tmp_name'], "..".$file_dir))
                echo 'There was some error moving the file to upload directory. Please make sure the upload directory is writable by web server.';
        }

        $title = $_POST["title"];
        $image = $file_dir;
        $detail = $_POST["detail"];
        $price = $_POST["price"];
        $quantity = $_POST["quantity"];
        $supplierid = $_POST["supplier"];
        $sql = "INSERT INTO product(title,img,detail,price,quantity,supplierid) 
        VALUES ('$title', '$image', '$detail', $price, $quantity, $supplierid)";
        $db_handle->runQuery($sql);
        if($db_handle->getError() !== null)
            echo $db_handle->getError();
    }
    if($_POST['delete'] && $_POST['ids']) {
        foreach ($_POST['ids'] as $id) {
            $db_handle->runQuery("DELETE FROM product WHERE id=$id");
            if($db_handle->getError() !== null)
                echo $db_handle->getError();
        }
    }
    if($_POST['change']) {
        for($i = 0; $i < count($_POST['id']); $i++) {
            if($_FILES["uploadImages"]["tmp_name"][$i]) {
                if(!is_dir("../uploads/".$_POST["titles"][$i]))
                    mkdir("../uploads/".$_POST["titles"][$i], 0777);

                $file_dir = "/uploads/".$_POST["titles"][$i]."/" . str_replace(" ", "-", $_FILES['uploadImages']['name'][$i]);
                if(!move_uploaded_file($_FILES['uploadImages']['tmp_name'][$i], "..".$file_dir))
                    echo 'There was some error moving the file to upload directory. Please make sure the upload directory is writable by web server.';
                
                    $db_handle->runQuery("UPDATE `product` SET img='$file_dir' WHERE id={$_POST["id"][$i]}");
            }
            
            $quantity = $_POST['quantities'][$i];
            $title = $_POST["titles"][$i];
            $detail = $_POST["details"][$i];
            $price = $_POST["prices"][$i];
            $supplier = $_POST["supplier"][$i];
            $id = $_POST["id"][$i];

            $sql = "UPDATE product
            SET quantity=$quantity,
            title='{$_POST["titles"][$i]}',
            detail='{$_POST["details"][$i]}',
            price='{$_POST["prices"][$i]}',
            supplierid='{$_POST["suppliers"][$i]}'
            WHERE id={$_POST["id"][$i]}";
            $db_handle->runQuery($sql);
            if($db_handle->getError() !== null)
                echo $db_handle->getError();
        }
    }
    ?>
    <br/>
    <div class="d-flex" id="wrapper">
        <div class="bg-light border-right" id="sidebar-wrapper">
            <div class="sidebar-heading">BestProduct Manager</div>
            <div class="list-group list-group-flush">
                <button class="list-group-item list-group-item-action" id="add-product" onclick="display(0);" style="font-weight:normal">Edit/Remove Product</a>
                <button class="list-group-item list-group-item-action" id="edit-product" onclick="display(1);" style="font-weight:normal">Add Product</a>
            </div>
        </div>
        
        <div class="container-fluid" id="edit-remove-table" style="display:none">
            <table class="table">
                <thead class="thead-light">
                    <tr style="text-align:center;">
                        <th scope="col">#</th>
                        <th scope="col">ID</th>
                        <th scope="col">Quantity</th>
                        <th scope="col">Title</th>
                        <th scope="col">Supplier</th>
                        <th scope="col">Image</th>
                        <th scope="col">Detail</th>
                        <th scope="col">Price</th>
                    </tr>
                </thead>
                <tbody>
                    <form action='products.php' method='POST' enctype="multipart/form-data"> 
        <?php

        $products = $db_handle->runQuery("SELECT * FROM product");
        if($db_handle->getError() !== null)
            echo $db_handle->getError();

        foreach($products as $product){
            $id = $product['id'];
            $quantity = $product['quantity'];
            $title = $product['title'];
            $detail = $product['detail'];
            $price = $product['price'];
            $image = $product['img'];
            $supplierId = $product['supplierid'];
            $allSuppliers = $db_handle->runQuery("SELECT `name`, `id` FROM `Suppliers`");

            echo "
                <tr>
                    <th><input type='checkbox' name='ids[]' value='$id' unchecked></th>
                    <input type='hidden' name='id[]' value='$id'/>
                    <th>$id</th>
                    <th scope='row'><input type='number' name='quantities[]' value='$quantity'/></th>
                    <td><input type='text' name='titles[]' value='$title'/></td>
                    <td>
                        <select id='suppliers[]' name='suppliers[]'>
                            ";
                            foreach($allSuppliers as $supplier) {
                                echo "<option value='{$supplier["id"]}' "; 
                                if($supplier["id"] == $supplierId) echo "selected";
                                echo ">{$supplier["name"]}</option>";
                            }
                            echo "
                        </select>
                    </td>
                    <td>
                        <img class='img-thumbnail rounded float-right' width='100px' src='$image'/>
                        <br/>
                        <input type='file' name='uploadImages[]'/>
                    </td>
                    <td><input type='text' name='details[]' value='$detail'/></td>
                    <td><input type='number' name='prices[]' value='$price'/></td>
                </tr>
            ";
        }
        ?>
        </tbody>
        </table>
        <br/>
        <input type='submit' name='delete' value='Delete selected'/>
        <input type='submit' name='change' value='Send changes'/>
        </form>
        </div>
        <div class="container-fluid" id="add-product-div" style="display:none">
        <table class="table">
                <thead class="thead-light">
                    <tr style="text-align:center;">
                        <th scope="col">Quantity</th>
                        <th scope="col">Title</th>
                        <th scope="col">Supplier</th>
                        <th scope="col">Image</th>
                        <th scope="col">Detail</th>
                        <th scope="col">Price</th>
                    </tr>
                </thead>
                <tbody>
                    <form action='products.php' method='POST' enctype="multipart/form-data">
                        <tr>
                            <td><input type='number' name='quantity' value='0' placeholder='Quantity of product'/></td>
                            <td><input type='text' name='title' placeholder='Product Title'/></td>
                            <td>
                                <select id='supplier' name='supplier'>
                                    <?php
                                    $allSuppliers = $db_handle->runQuery("SELECT `name`, `id` FROM `Suppliers`");
                                    foreach($allSuppliers as $supplier) {
                                        echo "<option value='{$supplier["id"]}'>{$supplier["name"]}</option>";
                                    }
                                    $db_handle->closeSql();
                                    ?>
                                </select>
                            </td>
                            <td><input type='file' name='uploadImage' placeholder='Image URL'/></td>
                            <td><input type='text' name='detail' placeholder='Product detail'/></td>
                            <td><input type='number' name='price' placeholder='Product price'/></td>
                        </tr>
                </tbody>
            </table>
            <input type='submit' name='add' value='Add Product'/>
            </form>
        </div>
    </div>
</body>
<script src="extra.js"></script>
</html>