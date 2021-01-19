<?php 
session_start();
if($_SESSION["admin"] == 0 || !isset($_SESSION["admin"])) {
    //header("Location: ../index.php");
    header('HTTP/1.0 403 Forbidden');
    echo file_get_contents('403.php');
    exit;
}

$extra = [
    '<link href="../style.css" rel="stylesheet"/>',
    '<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">',
    '<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>',
    '<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>'
];

foreach($extra as &$link)
    echo $link;

addNavBar();

function addNavBar() {
  echo "
  <nav class='navbar navbar-expand-lg navbar-light bg-light'>
    <a class='navbar-brand' href='index.php'>BestAdmin</a>
    <div class='navbar-collapse collapse justify-content-between' id='navbarNav'>
      <ul class='navbar-nav mr-auto'>
        <li class='nav-item active'>
          <a class='nav-link' href='index.php'>BestHome</a>
        </li>
        <li class='nav-item'>
          <a class='nav-link' href='suppliers.php'>BestSuppliers</a>
        </li>
        <li class='nav-item'>
          <a class='nav-link' href='products.php'>BestProduct</a>
        </li>
        <li class='nav-item'>
          <a class='nav-link' href='users.php'>BestUsers</a>
        </li>
        <li class='nav-item'>
          <a class='nav-link' href='orders.php'>BestOrders</a>
        </li>
      </ul>
      <ul class='navbar-nav'>
        <li class='navbar-brand helloname'>
          Hello <bold>{$_SESSION['name']}</bold>
        </li>
        <li class='navbar-brand'>
          <a class='navbar-brand' href='/'>Back to BestHome</a>
        </li>
        <li class='navbar-brand'>
          <a class='navbar-brand' href='../logout.php'>BestLogout</a>
        </li>
      </ul>
    </div>
  </nav>";
}

?>