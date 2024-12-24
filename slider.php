<?php
include('database/connect.php');
$select_product = "SELECT * FROM `products`";
$result = mysqli_query($conn, $select_product);

$products = [];
while ($row = mysqli_fetch_assoc($result)) {
    $products[] = $row;
}
?>

<div class="slider-list">
    <ul class="navBottom" id="navBottom">
        <?php foreach ($products as $index => $product): ?>
            <li>
                <button class="menuItem" data-index="<?php echo $index; ?>">
                    <?php echo htmlspecialchars($product['list_title']); ?>
                </button>
            </li>
        <?php endforeach; ?>
    </ul>
</div>

<div class="slider">
    <div class="sliderWrapper" id="sliderWrapper">
        <?php foreach ($products as $index => $product): ?>
            <div class="sliderItem">
                <img src="admin/product_images/<?php echo htmlspecialchars($product['image_path']); ?>"
                    alt="<?php echo htmlspecialchars($product['title']); ?>" class="sliderImage">
                <div class="slideBg"></div>
                <h1 class="sliderTitle"><?php echo htmlspecialchars($product['title']); ?></h1>
                <h2 class="sliderPrice">RS <?php echo htmlspecialchars($product['base_price']); ?></h2>
                <a class="buyButton" href="#product">BUY NOW!</a>
            </div>
        <?php endforeach; ?>
    </div>
</div>