<?php 
if (time() > $_SESSION['cart_expire']) {
  unset($_SESSION['cart_expire']);
  unset($_SESSION['cart_item']);
}

$extra = [
    '<link href="./style.css" rel="stylesheet"/>',
    '<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">',
    '<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>'
];

foreach($extra as &$link)
    echo $link;

function addProduct($title, $desc, $price, $image) {
    echo "
    <div class='card' style='width: 18rem;'>
            <img class='card-img-top' src='$image' alt='Card image cap'>
            <div class='card-body'>
                <h5 class='card-title'>$title - $price</h5>
                <p class='card-text'>$desc</p>
                <a href='#' class='btn btn-primary'>More details</a>
            </div>
    </div>
    ";
}

addNavBar();

function addNavBar() {
    echo "
    <nav class='navbar navbar-expand-lg navbar-light bg-light'>
  <a class='navbar-brand' href='index.php'>BestNavbar</a>
  <div class='navbar-collapse collapse justify-content-between' id='navbarNav'>
    <ul class='navbar-nav mr-auto'>
      <li class='nav-item active'>
        <a class='nav-link' href='index.php'>BestHome</a>
      </li>
      <li class='nav-item'>
        <a class='nav-link' href='products.php'>BestProducts</a>
      </li>
      ";
      session_start();
      if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true)
        echo "
        <li class='nav-item'>
          <a class='nav-link' href='login.php'>BestLogin</a>
        </li>
        ";
      else {
        echo "
        </ul>
        <ul class='navbar-nav'>
        <li class='navbar-brand'>
          <a href='/cart' style='text-decoration: none;'>
            <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-cart' viewBox='0 0 16 16'>
              <path d='M0 1.5A.5.5 0 0 1 .5 1H2a.5.5 0 0 1 .485.379L2.89 3H14.5a.5.5 0 0 1 .491.592l-1.5 8A.5.5 0 0 1 13 12H4a.5.5 0 0 1-.491-.408L2.01 3.607 1.61 2H.5a.5.5 0 0 1-.5-.5zM3.102 4l1.313 7h8.17l1.313-7H3.102zM5 12a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm7 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm-7 1a1 1 0 1 1 0 2 1 1 0 0 1 0-2zm7 0a1 1 0 1 1 0 2 1 1 0 0 1 0-2z'/>
            </svg>
            <span>".count($_SESSION["cart_item"])."</span>
          </a>
        </li>
        <li class='navbar-brand helloname'>
          Hello {$_SESSION['name']}
        </li>";
        if($_SESSION["admin"] == 1)
          echo "
          <li class='navbar-brand'>
            <a class='navbar-brand' href='/admin'>BestAdmin</a>
          </li>
          ";
        echo "
        <li class='navbar-brand'>
          <a class='navbar-brand' href='logout.php'>BestLogout</a>
        </li>
        ";
      }
      echo "
    </ul>
  </div>
</nav>
    ";
}

?>