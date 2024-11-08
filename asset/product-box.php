<div class="product-box">
<a href="product-single-page.php?id=<?php echo $product['product_id']?>" title="<?php echo $product['title'] ?>">
        <div class="image">
            <img src="admin/product_images/<?php echo $product['image_path'] ?>" class="img-cover" alt="">
        </div>
        <div class="content">
            <h3 class="title"><?php echo $product['title'] ?></h3>
            <p><?php echo $product['description'] ?></p>
            <div class="price">
                <span class="price"><span class="symbol">Rs.</span><?php echo $product['base_price'] ?></span>
            </div>
            <span class="btn-box primary-btn">View More</span>
        </div>
    </a>
</div>

