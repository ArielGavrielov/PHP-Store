<!DOCTYPE html>
<html lang="en">
<head>
<?php
include_once "extra.php";
include_once "../db-connect.php";
?>
</head>

<?php
if($_POST['delete'] && $_POST['ids']) {
    foreach ($_POST['ids'] as $id) {
        $sql = "DELETE FROM accounts WHERE id=$id";
        if($mysqli->query($sql) !== true) echo $mysqli->error;
    }
}
if($_POST['change']) {
    for($i = 0; $i < count($_POST['id']); $i++) {
        $sql = "UPDATE accounts
        SET Aname='{$_POST["names"][$i]}',
        username='{$_POST["usernames"][$i]}',
        isadmin = ".(int)isset($_POST['admins'][$i])."
        WHERE username='{$_POST["usernames"][$i]}'";
        if($mysqli->query($sql) !== true) echo $mysqli->error;
    }
}
?>
<body>
<div class="container-fluid" id="edit-remove-table">
            <table class="table">
                <thead class="thead-light">
                    <tr style="text-align:center;">
                        <th scope="col">#</th>
                        <th scope="col">ID</th>
                        <th scope="col">Name</th>
                        <th scope="col">Is Admin</th>
                        <th scope="col">Username</th>
                    </tr>
                </thead>
                <tbody>
                    <form action='users.php' method='POST'> 
        <?php

        $sql = "SELECT * FROM accounts";
        $result = $mysqli->query($sql);

        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $id = $row['id'];
                $admin = $row['isadmin'];
                $checked = $admin == 1 ? "checked" : "unchecked";
                $username = $row['username'];
                $name = $row['Aname'];
                echo "
                <tr style='text-align:center;'>
                    <td><input type='checkbox' name='ids[]' value='$id' unchecked></td>
                    <input type='hidden' name='id[]' value='$id'/>
                    <td>$id</td>
                    <td><input type='text' name='names[]' value='$name'/></td>
                    <td><input type='checkbox' class='admin' name='admins[]' $checked/></td>
                    <td><input type='text' name='usernames[]' value='$username'/></td>
                </tr>
                ";
            }
        }
        ?>
        </tbody>
        </table>
        <br/>
        <input type='submit' name='delete' value='Delete selected'/>
        <input type='submit' name='change' value='Send changes'/>
        </form>
        <?php $mysqli->close(); ?>
        </div>
</body>
</html>