<?php
include("database/connect.php");

if (isset($_GET['search_keyword'])) {
    $search_keyword = $_GET['search_keyword'];

    // Escape the search keyword to prevent SQL injection
    $search_keyword = '%' . mysqli_real_escape_string($conn, $search_keyword) . '%';

    // Construct the SQL query to fetch matching results
    $query = "
        SELECT list_title
        FROM products
        WHERE list_title LIKE '$search_keyword'
        LIMIT 10"; // Limit the number of suggestions

    // Execute the query
    $result = mysqli_query($conn, $query);

    // Generate the suggestion list
    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<div class='suggestion-item'>" . htmlspecialchars($row['list_title']) . "</div>";
        }
    } else {
        echo "<div class='suggestion-item'>No suggestions found</div>";
    }
}
?>
