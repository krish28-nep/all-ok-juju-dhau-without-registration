<?php
// Connect to the database
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

// Fetch products from the database
$select_product = "SELECT * FROM `products`";
$result = mysqli_query($conn, $select_product);

$products = [];
while ($row = mysqli_fetch_assoc($result)) {
    $products[] = $row; 
}

?>

<div class="product" id="product">
    <?php 

    // Display products
    foreach ($products as $index => $product): 
        // Split the product_options into an array of option IDs
        $option_ids = explode(',', $product['product_options']);
        
        // Prepare a query to fetch product options
        $option_ids_placeholder = implode(',', array_map('intval', $option_ids)); // Sanitize option IDs
        $select_options = "SELECT * FROM `product_options` WHERE `option_id` IN ($option_ids_placeholder)";
        $options_result = mysqli_query($conn, $select_options);
        
        $options = mysqli_fetch_all($options_result, MYSQLI_ASSOC); // Fetch all options at once
    ?>
    <div class="product-item" data-base-price="<?php echo htmlspecialchars($product['base_price']); ?>" data-index="<?php echo $index; ?>"> 
        <img src="admin/product_images/<?php echo htmlspecialchars($product['image_path']); ?>" alt="<?php echo htmlspecialchars($product['title']); ?>" class="sliderImage">
        <div class="productDetail">

            <h1 class="productTitle"><?php echo htmlspecialchars($product['title']); ?></h1>
            <h2 class="productPrice">RS <?php echo htmlspecialchars($product['base_price']); ?></h2>
            <div class="productDisc"><?php echo htmlspecialchars($product['description']); ?></div>
            <form action="" method="post">
                <div class="sizes">
                    <?php foreach ($options as $optionIndex => $option): ?>
                        <div class="size">
                            <input type="radio" name="liter_<?php echo $index; ?>" id="option_<?php echo $index; ?>_<?php echo htmlspecialchars($option['option_id']); ?>" 
                                   value="<?php echo intval($option['option_name']); ?>" 
                                   onchange="updatePrice(this)" <?php echo $optionIndex === 0 ? 'checked' : ''; ?>>
                            <label for="option_<?php echo $index; ?>_<?php echo htmlspecialchars($option['option_id']); ?>"><?php echo htmlspecialchars($option['option_name']); ?> ltr</label>
                        </div>
                    <?php endforeach; ?>
                </div>
                <input type="hidden" name="product_id" value="<?php echo htmlspecialchars($product['product_id']); ?>">
                <button class="productButton" type="submit" name="cart-product">ADD TO CART</button>
            </form>
        </div>
    </div>
    <?php endforeach; ?>
</div>

<script>
    function updatePrice(selectedSize) {
        const productDiv = selectedSize.closest('.product-item'); // Get the parent product item element
        const basePrice = parseFloat(productDiv.getAttribute('data-base-price')); // Get base price from data attribute
        const literValue = parseInt(selectedSize.value); // Get the selected liter value
        const newPrice = basePrice * literValue; // Calculate the new price
        const priceElement = productDiv.querySelector('.productPrice'); // Get the price element for this product
        priceElement.innerText = `RS ${newPrice}.00`; // Update the displayed price
    }
</script>

<?php
// Close the database connection after all queries are done
mysqli_close($conn);
?>
