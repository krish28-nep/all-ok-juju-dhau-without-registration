<?php
session_start();
include("database/connect.php");
include("header.php");

// Check if user is logged in
if (!isset($_SESSION["userid"])) {
    echo "<script>alert('Please log in to view your orders');</script>";
    echo "
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const form_box = document.querySelector('.form-box');
                const overlay = document.querySelector('.overlay');
                if (form_box && overlay) {
                    form_box.classList.add('active');
                    overlay.classList.add('active'); 
                    document.querySelector('body').classList.add('overflow-hidden');
                }
            });
        </script>";
} else {
    $userid = $_SESSION["userid"];
}

// Deleting an order
if (isset($_GET['delete_order_id'])) {
    // Ensure the order_id is an integer and properly sanitized
    $delete_order_id = filter_input(INPUT_GET, 'delete_order_id', FILTER_VALIDATE_INT);

    if ($delete_order_id) {
        // Start transaction
        $conn->begin_transaction();

        try {
            // Delete the order from the orders table
            $delete_query = "DELETE FROM orders WHERE order_id = ? AND userid = ?";
            $stmt = $conn->prepare($delete_query);
            if ($stmt) {
                $stmt->bind_param("ii", $delete_order_id, $userid);
                if ($stmt->execute()) {
                    // Reset the auto-increment value after deletion
                    $reset_auto_increment_query = "SELECT MAX(order_id) AS max_id FROM orders";
                    $result = $conn->query($reset_auto_increment_query);

                    if ($result) {
                        $row = $result->fetch_assoc();
                        $max_id = $row['max_id'];
                        $next_auto_increment = $max_id + 1;

                        // Now reset the AUTO_INCREMENT value
                        $reset_query = "ALTER TABLE orders AUTO_INCREMENT = $next_auto_increment";
                        if ($conn->query($reset_query)) {
                            // Commit the transaction
                            $conn->commit();
                            echo "<script>alert('Order deleted successfully');</script>";
                        } else {
                            throw new Exception("Failed to reset AUTO_INCREMENT.");
                        }
                    } else {
                        throw new Exception("Failed to retrieve the max order ID.");
                    }

                    // Redirect back to the order list page after deletion
                    header("Location: order_list.php");
                    exit();
                } else {
                    throw new Exception("Failed to delete the order.");
                }
            } else {
                throw new Exception("Failed to prepare the delete query.");
            }
        } catch (Exception $e) {
            // Rollback the transaction in case of an error
            $conn->rollback();
            echo "<script>alert('Error: " . $e->getMessage() . "');</script>";
        }
    } else {
        echo "<script>alert('Invalid order ID.');</script>";
    }
}

// Fetch all orders for the logged-in user
$order_query = "
    SELECT o.order_id, o.total_amount, o.order_date, 
           (SELECT COUNT(*) FROM order_details od WHERE od.order_id = o.order_id) AS item_count
    FROM orders o
    WHERE o.userid = ?
    ORDER BY o.order_date DESC";

$stmt = $conn->prepare($order_query);
$stmt->bind_param("i", $userid);
$stmt->execute();
$order_result = $stmt->get_result();

echo "<section class='order-list-section padding-top-section'>
        <div class='container'>
            <h2 class='heading underline'>Your Orders</h2>";

if ($order_result->num_rows > 0) {
    echo "<table class='table'>
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Date</th>
                    <th>Payment Method</th>
                    <th>Total Items</th>
                    <th>Total Amount</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>";

    while ($row = $order_result->fetch_assoc()) {
        $order_id = $row['order_id'];
        $order_date = htmlspecialchars($row['order_date']);
        $payment_method = "Cash on Delivery";
        $item_count = $row['item_count'];
        $total_amount = number_format($row['total_amount'], 2);

        echo "<tr>
                <td>$order_id</td>
                <td>$order_date</td>
                <td>$payment_method</td>
                <td>$item_count</td>
                <td>Rs. $total_amount</td>
                <td>
                    <a href='order-success.php?order_id=$order_id' class='btn btn-info'>View Details</a>
                    <a href='order_list.php?delete_order_id=$order_id' class='btn btn-danger' 
                       onclick='return confirm(\"Are you sure you want to delete this order?\")'>Cancel Order</a>
                </td>
              </tr>";
    }

    echo "</tbody>
          </table>";
} else {
    echo "<p class='lead text-center'>You have no orders yet. <a href='shop_list.php'>Start shopping now!</a></p>";
}

echo "</div>
      </section>";

include("footer.php");
?>
