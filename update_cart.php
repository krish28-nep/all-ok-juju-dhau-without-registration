<?php
@session_start();
include('database/connect.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_SESSION['userid'])) {
        echo json_encode(['status' => 'error', 'message' => 'Please log in to add items to the cart']);
        exit;
    }

    $product_id = (int)$_POST['product_id'];
    $option = (int)$_POST['option'];
    $userid = mysqli_real_escape_string($conn, $_SESSION['userid']);

    // Check if the product is already in the cart
    $sql = "SELECT * FROM `cart_details` WHERE userid = '$userid' AND product_id = $product_id AND option = $option";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        echo json_encode(['status' => 'error', 'message' => 'Item already in cart']);
    } else {
        $insert_query = "INSERT INTO `cart_details` (product_id, userid, option) VALUES ($product_id, '$userid', $option)";
        if (mysqli_query($conn, $insert_query)) {
            // Get the updated cart count
            $count_query = "SELECT COUNT(*) AS cart_count FROM `cart_details` WHERE userid = '$userid'";
            $count_result = mysqli_query($conn, $count_query);
            $cart_count = mysqli_fetch_assoc($count_result)['cart_count'];

            echo json_encode(['status' => 'success', 'cart_count' => $cart_count]);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Error adding item to cart']);
        }
    }
    mysqli_close($conn);
}
?>
