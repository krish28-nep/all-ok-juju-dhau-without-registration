<?php
@session_start();
if (isset($_SESSION['name'])) {
    $userName = $_SESSION['name'];
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="css/style.css" />
    <link rel="stylesheet" href="css/all.css  " />

    <title>Duju-Dhau</title>
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
                    <input type="search" class="searchInput" placeholder="Search..." />
                    <i class="fa-solid fa-magnifying-glass"></i>
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
                                if (isset($_SESSION['name'])) {
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
                        <span class="icon"><a href="#"><i class="fa-solid fa-cart-shopping"><span
                                        class="cart-no"><sup>0</sup></span></i></a></span>
                    </li>
                </ul>
            </div>
        </div>
        <div class="overlay"></div>
    </nav>