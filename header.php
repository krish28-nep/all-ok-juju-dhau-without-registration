<?php
@session_start();
if (isset($_SESSION['userid'])) {
    $userName = $_SESSION['name'];
}
$user_search_data_value = "";
if (isset($_GET['search_keyword'])) {
    $user_search_data_value = $_GET['search_keyword'];
}
include('function/common-function.php');
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="css/all.css" />
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/style.css" />

    <title>Juju-Dhau</title>
</head>


<body>
    <nav>
        <div class="navTop">
            <div class="navItem">
                <a href="index.php">

                    <img src="image/logo.png" alt="" class="logoImg">
                </a>

            </div>
            <div class="navItem">
                <div class="search">
                    <form action="search.php" method="get" class="search-form">
                        <input type="search" class="searchInput" name="search_keyword" placeholder="Search..." />
                        <button type="submit" class="searchButton">
                            <i class="fa-solid fa-magnifying-glass"></i>
                        </button>
                        <div id="suggestionsList" class="suggestions-list"></div>
                    </form>
                </div>
            </div>

            <div class="navItem">
                <ul class="nav-icon">
                    <li>
                        <span class="icon">
                            <a href="#">
                                <i class="fa-solid fa-user"></i>
                            </a>
                            <ul class="dropdown">
                                <?php
                                if (isset($_SESSION['userid'])) {
                                    echo '<li><span class="text"> Welcome, ' . $userName . '</span></li>';
                                    echo '<li><a href="user_profile.php" class="text">Profile</a></li>';
                                    echo '<li><a href="logout.php" class="text">Logout</a></li>';
                                } else {
                                    echo '<li><button class="login-btn">Login</button></li>';
                                }
                                ?>

                            </ul>
                        </span>
                    </li>
                    <li>
                        <span class="icon"><a href="cart.php"><i class="fa-solid fa-cart-shopping"><span
                                        class="cart-no"><sup><?php total_product_cart(); ?></sup></span></i></a></span>
                    </li>
                    <span class="icon"><a href="order_list.php">Your Orders</a></span>
                </ul>
            </div>
        </div>
        <div class="overlay"></div>
    </nav>