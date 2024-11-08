<?php
include('header.php');
include('database/connect.php');

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
            <!-- Additional details if needed -->
        </div>
    </div>
</div>
<?php
    else:
        echo "<p>Product not found.</p>";
    endif;
    $stmt->close();
}
include('footer.php');
?>
