<?php
include('header.php');
include('database/connect.php');
$select_product = "SELECT * FROM `products`";
$result = mysqli_query($conn, $select_product);

$products = [];
while ($row = mysqli_fetch_assoc($result)) {
    $products[] = $row;
}
?>

<section class="shop-section py-5 my-5">
    <div class="container">
        <div class="row g-5">
            <?php foreach ($products as $index => $product): ?>
                <div class='col-4'>
                    <?php include('asset/product-box.php') ?>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<?php include('footer.php'); ?>