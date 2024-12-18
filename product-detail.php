<?php
// Include necessary files
include('database/connect.php');

// Handle form submission for adding to cart
if (isset($_POST["cart-product"])) {
    // Check if the user is logged in
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
        // Do not stop rendering the rest of the page
    } else {
        // Sanitize and validate inputs
        $get_product_id = intval($_POST['product_id']);
        $userid = mysqli_real_escape_string($conn, $_SESSION["userid"]);
        $selected_option_name = key($_POST); // Get the selected liter key
        $option = intval($_POST[$selected_option_name]);

        // Check if the product with the selected option is already in the cart
        $sql = "SELECT * FROM `cart_details` WHERE userid = '$userid' AND product_id = $get_product_id AND option = $option";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            echo "<script>alert('Item already in cart');</script>";
        } else {
            // Insert the product into the cart
            $insert_query = "INSERT INTO `cart_details` (product_id, userid, option) VALUES ($get_product_id, '$userid', $option)";
            if (mysqli_query($conn, $insert_query)) {
                echo "<script>alert('Item added to cart successfully');</script>";
                echo "<script>window.open('index.php', '_self');</script>";
            } else {
                echo "<script>alert('Error adding item to cart');</script>";
                echo "<script>console.log('MySQL Error: " . mysqli_error($conn) . "');</script>";
            }
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

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products</title>
</head>
<body>

<div class="product" id="product">
    <?php 

    // Display products
    foreach ($products as $index => $product): 
        $option_ids = explode(',', $product['product_options']);
        $option_ids_placeholder = implode(',', array_map('intval', $option_ids)); // Sanitize option IDs

        $select_options = "SELECT * FROM `product_options` WHERE `option_id` IN ($option_ids_placeholder)";
        $options_result = mysqli_query($conn, $select_options);
        $options = mysqli_fetch_all($options_result, MYSQLI_ASSOC);
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
                                   onchange="updatePrice(this)" <?php echo $optionIndex === 0 ? 'checked' : ''; ?> >
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
        const productDiv = selectedSize.closest('.product-item'); 
        const basePrice = parseFloat(productDiv.getAttribute('data-base-price')); 
        const literValue = parseInt(selectedSize.value); 
        const newPrice = basePrice * literValue; 
        const priceElement = productDiv.querySelector('.productPrice'); 
        priceElement.innerText = `RS ${newPrice}.00`; 
    }
</script>

<?php
// Close the database connection
mysqli_close($conn);
?>

</body>
</html>
