<?php
include ("header.php");
// include ('function/commonfunction.php');

// Check if the search keyword is set
$user_search_data_value = "";
if (isset($_GET['search_keyword'])) {
    $user_search_data_value = $_GET['search_keyword'];
}

?>

<section class="single-banner bg-light-white margin-top-header">
    <div class="container">
        <h1 class="heading">Search</h1>
        <div class="breadcrumb m-0">
            <a href="index.php">Home</a>
            <span>/</span>
            <span>Search for "<?php echo $user_search_data_value ?>"</span>
        </div>
    </div>
</section>
<section class="pb-5 padding-top-section">
    <div class="container">
        <div class="row g-5">
            <?php
            search_product();
            ?>
        </div>
    </div>
</section>

<?php include ("footer.php"); ?>