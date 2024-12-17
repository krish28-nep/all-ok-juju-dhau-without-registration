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
        return; // Stop further execution
    }

    // Get product ID and user ID
    $get_product_id = (int)$_POST['product_id']; // Ensure product ID is an integer
    $userid = mysqli_real_escape_string($conn, $_SESSION["userid"]); // Sanitize the user ID

    // Get the selected option (liter value) from the form
    $selected_option_name = key($_POST); // Gets the first key in the posted data
    $option = intval($_POST[$selected_option_name]); // Convert the selected value to an integer

    // Check if the product with the selected option is already in the cart
    $sql = "SELECT * FROM `cart_details` WHERE userid = '$userid' AND product_id = $get_product_id AND option = $option";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        // Product with the selected option is already in the cart
        echo "<script>alert('Item already in cart');</script>";
    } else {
        // Insert the product into the cart with the selected option
        $insert_query = "INSERT INTO `cart_details` (product_id, userid, option) VALUES ($get_product_id, '$userid', $option)";
        if (mysqli_query($conn, $insert_query)) {
            echo "<script>alert('Item added to cart successfully');</script>";
        } else {
            echo "<script>alert('Error adding item to cart');</script>";
            echo "<script>console.log('MySQL Error: " . mysqli_error($conn) . "');</script>"; // Log error for debugging
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
            <img src="admin/product_images/<?php echo $product['image_path'] ?>" class="img-cover" alt="<?php echo $product['title'] ?>">
        </div>
        <div class="col-md-6">
            <h1><?php echo $product['title'] ?></h1>
            <p><?php echo $product['description'] ?></p>
            <div class="price">
                <span class="symbol">Rs.</span><?php echo $product['base_price'] ?>
            </div>
            <form action="" method="post">
                <div class="sizes">
                    <?php foreach ($options as $optionIndex => $option): ?>
                        <div class="size">
                            <input type="radio" name="liter_<?php echo $optionIndex; ?>" id="option_<?php echo $optionIndex; ?>_<?php echo htmlspecialchars($option['option_id']); ?>" 
                                   value="<?php echo intval($option['option_name']); ?>" 
                                   onchange="updatePrice(this)" <?php echo $optionIndex === 0 ? 'checked' : ''; ?>>
                            <label for="option_<?php echo $optionIndex; ?>_<?php echo htmlspecialchars($option['option_id']); ?>"><?php echo htmlspecialchars($option['option_name']); ?> ltr</label>
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
        const productDiv = selectedSize.closest('.col-md-6'); // Find the closest parent with the class 'col-md-6'
        const basePrice = parseFloat(document.querySelector('.price').innerText.replace('Rs.', '').trim()); // Get the base price
        const literValue = parseInt(selectedSize.value); // Get the selected liter value
        const newPrice = basePrice * literValue; // Calculate the new price
        const priceElement = productDiv.querySelector('.price'); // Get the price element to update
        priceElement.innerText = `Rs. ${newPrice}`; // Update the displayed price
    }
</script>
<?php
    else:
        echo "<p>Product not found.</p>";
    endif;
    $stmt->close();
}
include('footer.php');
?>
