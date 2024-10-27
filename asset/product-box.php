<div class="product-box">
    <a href="product-detail.php?id=<?php echo $id?>" title="<?php echo $product_title ?>">
        <div class="image">
            <img src="image/<?php echo $product_image ?>" class="img-cover" alt="">
        </div>
        <div class="content">
            <h3 class="title"><?php echo $product_title ?></h3>
            <p><?php echo $product_description ?></p>
            <div class="price">
                <span class="price"><span class="symbol">Rs.</span><?php echo $product_price ?></span>
            </div>
            <span class="btn-box primary-btn">View More</span>
        </div>
    </a>
</div>