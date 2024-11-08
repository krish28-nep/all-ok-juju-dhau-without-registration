<?php 
include("database/connect.php");

?>

<footer>
    <div class="footerLeft">
        <div class="footerMenu">
            <h1 class="fMenuTitle">About Us</h1>
            <ul class="fList">
                <li class="fListItem"><a href="#">About us</a></li>
                <li class="fListItem"><a href="#">Contact us</a></li>
                <li class="fListItem"><a href="shop_list.php">shop list</a></li>
            </ul>
        </div>
        <div class="footerMenu">
            <h1 class="fMenuTitle">Products</h1>
            <ul class="fList">
            <?php 
                $titleQuery = "SELECT * FROM products";
                $result = mysqli_query($conn, $titleQuery);
                
                if ($result) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        $title = $row['list_title'];
                        $productId = $row['product_id']; // Use the correct column name for product ID
                        $productTitle = $row['title'];   // Use the correct column name for the product title

                        // Output each title as a list item with proper concatenation
                        echo "<li class='fListItem'>
                                <a href='product-single-page.php?id=" . $productId . "' title='" . htmlspecialchars($productTitle) . "'>
                                    $title
                                </a>
                            </li>";
                    }
                } else {
                    echo "Error fetching titles: " . mysqli_error($conn);
                }
            ?>
            </ul>
        </div>
    </div>
    <div class="footerRight">
        <div class="fRightMenu">
            <h1 class="fMenuTitle">Subscribe to our newsletter</h1>
            <form action="#">
                <div class="fMail">
                    <input type="text" placeholder="your@email.com" class="fInput" />
                    <button type="submit" name="newsletter-form" class="fButton">Join!</button>
                </div>
            </form>
        </div> 
        <div class="fRightMenu">
            <h1 class="fMenuTitle">Follow Us!</h1>
            <ul class="fIcons">
                <li><a href="#" title=""><i class="fa-brands fa-facebook"></i></a></li>
                <li><a href="#" title=""><i class="fa-brands fa-instagram"></i></a></li>
                <li><a href="#" title=""><i class="fa-brands fa-whatsapp"></i></a></li>
            </ul>
        </div>
        <div class="fRightMenu">
            <span class="copyright">copyright@All rights reserved 2024</span>
        </div>
    </div>
</footer>
<script src="js/jquery.js"></script>
<script src="js/user_login.js"></script>
<script src="js/product.js"></script>
<script src="js/search.js"></script>
<script src="js/script.js"></script>

</body>

</html>
<?php include('form-box.php');?>
