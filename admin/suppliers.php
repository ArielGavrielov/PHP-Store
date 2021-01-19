<!DOCTYPE html>
<html lang="en">
<head>
<?php
include_once "extra.php";
include_once "../dbcontroller.php";
$db_handle = new DBController();
?>
</head>

<?php
if($_POST['add']) {
    $name = $_POST["name"];
    $company = $_POST["company"];
    $phone = $_POST["phone"];
    $sql = "INSERT INTO suppliers(`name`,`company`,`phone`) 
    VALUES ('$name', '$company', '$phone')";
    $db_handle->runQuery($sql);
    if($db_handle->getError() !== null)
        echo $db_handle->getError();
}

if($_POST['delete'] && $_POST['ids']) {
    foreach ($_POST['ids'] as $id) {
        $db_handle->runQuery("DELETE FROM Suppliers WHERE id=$id");
        if($db_handle->getError() !== null)
            echo $db_handle->getError();
    }
}
if($_POST['change']) {
    for($i = 0; $i < count($_POST['id']); $i++) {
        $sql = "UPDATE Suppliers
        SET `name`='{$_POST["names"][$i]}',
        `company`='{$_POST["companies"][$i]}',
        `phone` = '{$_POST["phones"][$i]}'
        WHERE id='{$_POST["id"][$i]}'";
        $db_handle->runQuery($sql);
        if($db_handle->getError() !== null)
            echo $db_handle->getError();
    }
}
?>
<body>
<br/>
<div class="d-flex" id="wrapper">
        <div class="bg-light border-right" id="sidebar-wrapper">
            <div class="sidebar-heading">BestSuppliers Manager</div>
            <div class="list-group list-group-flush">
                <button class="list-group-item list-group-item-action" id="add-product" onclick="display(0);" style="font-weight:normal">Edit/Remove Supplier</a>
                <button class="list-group-item list-group-item-action" id="edit-product" onclick="display(1);" style="font-weight:normal">Add Supplier</a>
            </div>
        </div>
        
        <div class="container-fluid" id="edit-remove-table" style="display:none">
            <table class="table">
                <thead class="thead-light">
                    <tr style="text-align:center;">
                        <th scope="col">#</th>
                        <th scope="col">ID</th>
                        <th scope="col">Name</th>
                        <th scope="col">Company</th>
                        <th scope="col">Phone</th>
                    </tr>
                </thead>
                <tbody>
                    <form action='suppliers.php' method='POST'> 
        <?php

        $suppliers = $db_handle->runQuery("SELECT * FROM Suppliers");

        foreach($suppliers as $supplier){
            $id = $supplier['id'];
            $name = $supplier['name'];
            $company = $supplier['company'];
            $phone = $supplier['phone'];
            echo "
                <tr style='text-align:center;'>
                    <td><input type='checkbox' name='ids[]' value='$id' unchecked></td>
                    <input type='hidden' name='id[]' value='$id'/>
                    <td>$id</td>
                    <td><input type='text' name='names[]' value='$name'/></td>
                    <td><input type='text' name='companies[]' value='$company'/></td>
                    <td><input type='text' name='phones[]' value='$phone'/></td>
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
                        <th scope="col">Name</th>
                        <th scope="col">Company</th>
                        <th scope="col">Phone</th>
                    </tr>
                </thead>
                <tbody>
                    <form action='suppliers.php' method='POST'>
                        <tr class="text-center">
                            <td><input type='text' name='name' placeholder='Supplier name'/></td>
                            <td><input type='text' name='company' placeholder='Company name'/></td>
                            <td><input type='text' name='phone' placeholder='Phone number'/></td>
                        </tr>
                        <br/>
                </tbody>
            </table>
            <input type='submit' name='add' value='Add Supplier'/>
            </form>
        </div>
    </div>
    <?php $db_handle->closeSql(); ?>
</body>
<script src="extra.js"></script>
</html>