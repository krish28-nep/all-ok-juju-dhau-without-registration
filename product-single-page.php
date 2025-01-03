<?php
include('header.php');
include('database/connect.php');

// Handle form submission for adding to cart
if (isset($_POST["cart-product"])) {
    // Check if the user is logged in
    if (!isset($_SESSION["userid"])) {
        echo "<script>alert('Please log in to add items to the cart');</script>";
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
            </script>
        ";
    } else {

        // Get product ID and user ID
        $get_product_id = (int) $_POST['product_id']; // Ensure product ID is an integer
        $userid = mysqli_real_escape_string($conn, $_SESSION["userid"]); // Sanitize the user ID

        // Get the selected option (option_id) from the form
        $option_id = intval($_POST['liter']); // Get the selected option_id directly

        // Check if the option_id exists in the product_options table
        $check_option_query = "SELECT * FROM `product_options` WHERE `option_id` = $option_id";
        $check_option_result = mysqli_query($conn, $check_option_query);

        if (mysqli_num_rows($check_option_result) > 0) {
            // The option exists in the product_options table

            // Check if the product with the selected option is already in the cart
            $sql = "SELECT * FROM `cart_details` WHERE userid = '$userid' AND product_id = $get_product_id AND option_id = $option_id";
            $result = mysqli_query($conn, $sql);

            if (mysqli_num_rows($result) > 0) {
                // Product with the selected option is already in the cart
                echo "<script>alert('Item already in cart');</script>";
            } else {
                // Insert the product into the cart with the selected option
                $insert_query = "INSERT INTO `cart_details` (product_id, userid, option_id) VALUES ($get_product_id, '$userid', $option_id)";
                if (mysqli_query($conn, $insert_query)) {
                    echo "<script>alert('Item added to cart successfully');</script>";
                    echo "<script>window.open('product-single-page.php?id=$get_product_id', '_self');</script>";
                } else {
                    echo "<script>alert('Error adding item to cart');</script>";
                    echo "<script>console.log('MySQL Error: " . mysqli_error($conn) . "');</script>"; // Log error for debugging
                }
            }

        } else {
            // The option_id does not exist in the product_options table
            echo "<script>alert('Invalid option selected');</script>";
        }
    }
}

// Get the product ID from the URL
if (isset($_GET['id'])) {
    $product_id = intval($_GET['id']);

    // Query the database for the selected product
    $query = "SELECT * FROM `products` WHERE `product_id` = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $product = $result->fetch_assoc();

    if ($product):
        $option_ids = explode(',', $product['product_options']);

        // Prepare a query to fetch product options
        $option_ids_placeholder = implode(',', array_map('intval', $option_ids)); // Sanitize option IDs
        $select_options = "SELECT * FROM `product_options` WHERE `option_id` IN ($option_ids_placeholder)";
        $options_result = mysqli_query($conn, $select_options);

        $options = mysqli_fetch_all($options_result, MYSQLI_ASSOC); // Fetch all options at once
        ?>
        <div class="container single-product-page py-5">
            <div class="row">
                <div class="col-md-6">
                    <img src="admin/product_images/<?php echo htmlspecialchars($product['image_path']); ?>" class="img-cover"
                        alt="<?php echo htmlspecialchars($product['title']); ?>">
                </div>
                <div class="col-md-6">
                    <h1><?php echo htmlspecialchars($product['title']); ?></h1>
                    <p><?php echo htmlspecialchars($product['description']); ?></p>
                    <div class="price">
                        <span class="symbol">Rs.</span><span id="current-price"
                            data-base-price="<?php echo number_format($product['base_price'], 2); ?>"><?php echo number_format($product['base_price'], 2); ?></span>
                    </div>
                    <form action="" method="post">
                        <div class="sizes">
                            <?php foreach ($options as $optionIndex => $option): ?>
                                <div class="size">
                                    <input type="radio" name="liter" 
                                           id="option_<?php echo $optionIndex; ?>_<?php echo htmlspecialchars($option['option_id']); ?>" 
                                           value="<?php echo htmlspecialchars($option['option_id']); ?>" 
                                           data-option-name="<?php echo htmlspecialchars($option['option_name']); ?>" 
                                           onchange="updatePrice(this)" <?php echo $optionIndex === 0 ? 'checked' : ''; ?>>
                                    <label for="option_<?php echo $optionIndex; ?>_<?php echo htmlspecialchars($option['option_id']); ?>">
                                        <?php echo htmlspecialchars($option['option_name']); ?> ltr
                                    </label>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <input type="hidden" name="product_id" value="<?php echo htmlspecialchars($product['product_id']); ?>">
                        <button class="productButton" type="submit" name="cart-product">ADD TO CART</button>
                    </form>
                </div>
            </div>
        </div>

        <script>
            function updatePrice(selectedSize) {
                // Get the base price from the hidden field
                const basePrice = parseFloat(document.getElementById("current-price").dataset.basePrice);

                // Get the selected option's price from the data attribute
                const selectedOptionPrice = parseFloat(selectedSize.getAttribute("data-option-name"));

                // Calculate the new price based on the selected option's price
                const newPrice = basePrice * selectedOptionPrice;

                // Update the price display (without adding "Rs." symbol multiple times)
                document.getElementById("current-price").innerText = `${newPrice.toFixed(2)}`;
            }
        </script>

        <?php
    else:
        echo "<p>Product not found.</p>";
    endif;
} else {
    echo "<p>No product ID specified.</p>";
}

include('footer.php');
?>
