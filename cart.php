<?php
session_start();
include("database/connect.php");
include("header.php");

if (!isset($_SESSION["userid"])) {
    echo "<script>
            alert('Please log in to add items to the cart');
            document.addEventListener('DOMContentLoaded', function () {
                const form_box = document.querySelector('.form-box');
                const overlay = document.querySelector('.overlay');

                if (form_box && overlay) {
                    form_box.classList.add('active'); // Show the login form
                    overlay.classList.add('active'); // Show the overlay
                    document.querySelector('body').classList.add('overflow-hidden'); // Prevent scrolling
                }
            });
          </script>";
} else {
    $userid = $_SESSION["userid"];

    // Fetch cart details with option names
    $cart_query = "SELECT cd.product_id, cd.option_id, p.image_path, p.base_price, p.title, po.option_name 
                   FROM cart_details cd 
                   JOIN products p ON cd.product_id = p.product_id 
                   JOIN product_options po ON cd.option_id = po.option_id 
                   WHERE cd.userid = ?";
    
    $stmt = $conn->prepare($cart_query);
    if (!$stmt) {
        die("Query preparation failed: " . $conn->error);
    }
    $stmt->bind_param("i", $userid);
    $stmt->execute();
    $run_cart = $stmt->get_result();

    $total = 0;
}

if (isset($_GET['remove_product']) && isset($_GET['option_id'])) {
    $product_id_to_remove = filter_input(INPUT_GET, 'remove_product', FILTER_VALIDATE_INT);
    $product_option_to_remove = filter_input(INPUT_GET, 'option_id', FILTER_SANITIZE_STRING);

    if ($product_id_to_remove && $product_option_to_remove && isset($_GET['confirm_delete'])) {
        $delete_query = "DELETE FROM cart_details WHERE product_id = ? AND userid = ? AND option_id = ?";
        $stmt = $conn->prepare($delete_query);
        if (!$stmt) {
            die("Query preparation failed: " . $conn->error);
        }
        $stmt->bind_param("iis", $product_id_to_remove, $userid, $product_option_to_remove);
        
        if ($stmt->execute()) {
            echo "<script>alert('Product option removed successfully');</script>";
            header("Location: " . $_SERVER['PHP_SELF']);
            exit();
        } else {
            echo "<script>alert('Failed to delete product option.');</script>";
        }
    }
}

if (isset($run_cart) && $run_cart->num_rows > 0) {
    echo "<section class='cart-section padding-top-section'>
            <div class='container'>
                <form action='' method='post'>
                    <table class='cart-list margin-bottom-cart'>
                        <thead>
                            <tr>
                                <th class='product-remove'></th>
                                <th class='product-thumbnail'>Image</th>
                                <th class='product-name'>Product Name</th>
                                <th class='product-price'>Price</th>
                                <th class='product-quantity'>Litre</th>
                                <th class='product-subtotal'>Total</th>
                            </tr>
                        </thead>
                        <tbody>";

    while ($row_cart = $run_cart->fetch_assoc()) {
        $pro_id = $row_cart['product_id'];
        $option_name = htmlspecialchars($row_cart['option_name'], ENT_QUOTES, 'UTF-8'); // Get option_name
        $image = htmlspecialchars($row_cart['image_path'], ENT_QUOTES, 'UTF-8');
        $price = $row_cart['base_price'];
        $product_name = htmlspecialchars($row_cart['title'], ENT_QUOTES, 'UTF-8');

        echo "<tr>
                <td class='product-remove'>
                    <a href='" . $_SERVER['PHP_SELF'] . "?remove_product=$pro_id&option_id=" . $row_cart['option_id'] . "&confirm_delete' 
                       onclick='return confirm(\"Are you sure you want to delete this product option?\")'>Cancel</a>
                </td>
                <td class='product-thumbnail' style='width: 30%;'>
                    <img src='./admin/product_images/$image' alt='$product_name'>
                </td>
                <td class='product-name'>
                    $product_name
                </td>
                <td class='product-price'>
                    <span class='price-symbol'>Rs.</span> $price
                </td>
                <td class='product-quantity'>
                    <span>$option_name</span>
                </td>
                <td class='product-subtotal'>
                    <span class='price-symbol'>Rs.</span> " . ($price * (float) $option_name) . "
                </td>
            </tr>";
        $total += ($price * (float) $option_name);
    }

    echo "</tbody></table>
          <div class='cart-collaterals margin-bottom-cart'>
            <div class='row justify-content-end'>
                <div class='col-sm-6'>
                    <h2 class='heading underline'>Cart totals</h2>
                    <table>
                        <tbody>
                            <tr class='cart-subtotal'>
                                <th>Subtotal</th>
                                <td><span class='price-symbol'>Rs.</span> $total</td>
                            </tr>
                            <tr class='order-total'>
                                <th>Total</th>
                                <td><strong><span class='price-symbol'>Rs.</span> $total</strong></td>
                            </tr>
                        </tbody>
                    </table>
                    <div class='proceed-to-checkout'>
                        <a href='checkout.php?user_id=$userid' class='btn read-more checkout-btn'>Proceed to checkout</a>
                    </div>
                </div>
            </div>
          </div>
          </form>
          </div>
          </section>";
} else {
    echo "<section class='section-gap'>
            <div class='container'>
                <h2 class='heading underline center text-center'>Your shopping cart is empty.</h2>
                <p class='lead text-center'>Add some products to your cart before proceeding. 
                   <a href='shop_list.php' class='btn btn-primary'>Browse Shop</a></p>
            </div>
          </section>";
}

include("footer.php");
?>
