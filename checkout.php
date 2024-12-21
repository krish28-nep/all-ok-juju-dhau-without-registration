<?php
session_start();
include("database/connect.php");
include("header.php");

if (!isset($_SESSION["userid"])) {
    echo "<script>
            alert('Please log in to proceed to checkout');
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
    exit();
}

$userid = $_SESSION["userid"];
$total = 0;

// Fetch cart items for the user
$cart_query = "SELECT cd.product_id, cd.option, p.image_path, p.base_price, p.title 
               FROM cart_details cd 
               JOIN products p ON cd.product_id = p.product_id 
               WHERE cd.userid=?";
$stmt = $conn->prepare($cart_query);
$stmt->bind_param("i", $userid);
$stmt->execute();
$cart_items = $stmt->get_result();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['place_order'])) {
    $address = htmlspecialchars($_POST['address']);
    $payment_method = "Cash on Delivery"; // Hardcoded payment method as "Cash on Delivery"
    
    // Initialize total amount
    $total = 0;

    // Loop through cart items and calculate total
    while ($cart_item = $cart_items->fetch_assoc()) {
        $subtotal = $cart_item['base_price'] * $cart_item['option'];
        $total += $subtotal;
    }

    // Re-fetch the cart items to avoid using the results that were already consumed
    $stmt->execute();
    $cart_items = $stmt->get_result();

    // Proceed with placing the order if there are items in the cart
    if ($cart_items->num_rows > 0) {
        $order_query = "INSERT INTO orders (userid, total_amount, address, payment_method) VALUES (?, ?, ?, ?)";
        $order_stmt = $conn->prepare($order_query);
        $order_stmt->bind_param("idss", $userid, $total, $address, $payment_method);

        if ($order_stmt->execute()) {
            $order_id = $conn->insert_id;

            // Insert order details for each cart item
            while ($cart_item = $cart_items->fetch_assoc()) {
                $product_id = $cart_item['product_id'];
                $option = $cart_item['option'];
                $price = $cart_item['base_price'];
                
                $order_detail_query = "INSERT INTO order_details (order_id, product_id, option, price) VALUES (?, ?, ?, ?)";
                $detail_stmt = $conn->prepare($order_detail_query);
                $detail_stmt->bind_param("iiid", $order_id, $product_id, $option, $price);
                $detail_stmt->execute();
            }

            // Clear cart after placing order
            $conn->query("DELETE FROM cart_details WHERE userid=$userid");

            // Redirect to success page
            echo "<script>alert('Order placed successfully'); window.location.href='order-success.php?order_id=$order_id';</script>";
            exit();
        } else {
            echo "<script>alert('Failed to place the order. Please try again.');</script>";
        }
    }
}

// Display the checkout page if there are items in the cart
if ($cart_items->num_rows > 0) {
    echo "<section class='checkout-section padding-top-section'>
            <div class='container'>
                <h2 class='heading underline'>Checkout</h2>
                <form action='' method='post'>
                    <div class='row'>
                        <div class='col-md-6'>
                            <h3 class='subheading'>Billing Details</h3>
                            <div class='form-group'>
                                <label for='address'>Address</label>
                                <textarea name='address' id='address' class='form-control' rows='3' required></textarea>
                            </div>
                        </div>
                        <div class='col-md-6'>
                            <h3 class='subheading'>Your Order</h3>
                            <table class='table'>
                                <thead>
                                    <tr>
                                        <th>Product</th>
                                        <th>Option</th>
                                        <th>Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody>";

    // Reset total to recalculate after fetching cart items
    $total = 0;
    while ($row = $cart_items->fetch_assoc()) {
        $subtotal = $row['base_price'] * $row['option'];
        $total += $subtotal;
        echo "<tr>
                <td>" . htmlspecialchars($row['title']) . "</td>
                <td>" . htmlspecialchars($row['option']) . " Ltr</td>
                <td>Rs. " . number_format($subtotal, 2) . "</td>
              </tr>";
    }

    echo "</tbody>
                                <tfoot>
                                    <tr>
                                        <th>Total</th>
                                        <th></th>
                                        <th>Rs. " . number_format($total, 2) . "</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                    <div class='row'>
                        <div class='col-md-12 text-right'>
                            <button type='submit' name='place_order' class='btn btn-primary'>Place Order (Cash on Delivery)</button>
                        </div>
                    </div>
                </form>
            </div>
          </section>";
} else {
    echo "<section class='section-gap'>
            <div class='container'>
                <h2 class='heading underline center text-center'>Your cart is empty.</h2>
                <p class='lead text-center'>Please add some products to your cart before proceeding to checkout.</p>
            </div>
          </section>";
}

include("footer.php");
?>
