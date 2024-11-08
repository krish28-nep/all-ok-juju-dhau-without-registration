<?php
include("database/connect.php");

function total_product_cart()
{
    if (isset($_SESSION["userid"])) {
        global $conn;
        $userid = $_SESSION["userid"];

        // Simple SQL query to count the number of items in the cart
        $sql = "SELECT * FROM `cart_details` WHERE userid = '$userid'";
        $result = mysqli_query($conn, $sql);
        $num_of_sqli = mysqli_num_rows($result);

        echo $num_of_sqli;
    } else {
        echo "0"; // If userid is not set, return 0
    }
}

function search_product()
{
    global $conn;

    // Check if the search keyword is set
    if (isset($_GET['search_keyword']) && !empty($_GET['search_keyword'])) {
        $user_search_data_value = $_GET['search_keyword'];

        // Escape the search keyword to prevent SQL injection
        $search_keyword = '%' . mysqli_real_escape_string($conn, $user_search_data_value) . '%';

        // Simple SQL query to search products
        $search_product_query = "
            SELECT * 
            FROM products
            WHERE list_title LIKE '$search_keyword'";

        // Execute the query
        $result_query = mysqli_query($conn, $search_product_query);

        // Check if there are any search results
        if (mysqli_num_rows($result_query) == 0) {
            echo "<section class='search-result-section pb-5 mb-sm-5'>
                    <div class='container'>
                        <div class='content'>
                            <h4 class='heading'>No search Results</h4>
                            <p>There are no products matching your query</p>
                            <div class='search-product search-result'>
                                <form action='search.php' method='get'>
                                    <div class='position-relative d-flex gap-3'>
                                        <input type='search' name='search_keyword' placeholder='Search...'>
                                        <input type='submit' name='search_product' class='read-more btn' value='Search'>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </section>";
        } else {
            while ($product = mysqli_fetch_assoc($result_query)) {

                // Output HTML code to display product
                echo "<div class='col-lg-3 col-sm-6'>";

                include('asset/product-box.php');

                echo "
                        
                    </div>";
            }
        }
    } else {
        echo "<section class='search-result-section pb-5 mb-sm-5'>
                <div class='container'>
                    <div class='content'>
                        <h4 class='heading'>No search Results</h4>
                        <p>Please enter a search keyword.</p>
                        <div class='search-product search-result'>
                            <form action='search.php' method='get'>
                                <div class='position-relative d-flex gap-3'>
                                    <input type='search' name='search_keyword' placeholder='Search...'>
                                    <input type='submit' name='search_product' class='read-more btn' value='Search'>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </section>";
    }
}
?>
