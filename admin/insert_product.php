<?php
include ('../database/connect.php');

if (isset($_POST['insert_product'])) {
    $list_title = $_POST['list_title'];
    $title = $_POST['title'];
    $base_price = $_POST['base_price'];
    $description = $_POST['description'];
    $background_color = $_POST['background_color'];

    $img = $_FILES['img']['name'];
    $img_temp = $_FILES['img']['tmp_name'];
    move_uploaded_file($img_temp, "./product_images/$img");

    // Insert product
    $sql = "INSERT INTO `products` (`list_title`, `title`, `base_price`, `description`, `image_path`, `background_color`, `date_added`, `product_options`) VALUES ('$list_title', '$title', '$base_price', '$description', '$img', '$background_color', NOW(), NULL)";

    $res = mysqli_query($conn, $sql);
    if (!$res) {
        echo "Error: " . mysqli_error($conn) . "<br>";
    } else {
        // Get the last inserted product ID
        $product_id = mysqli_insert_id($conn);

        // Handle selected options
        if (isset($_POST['select_options'])) {
            $options = implode(',', $_POST['select_options']); // Create a comma-separated string of option IDs
            // Update the product with selected options
            $update_sql = "UPDATE `products` SET `product_options` = '$options' WHERE `product_id` = '$product_id'";
            mysqli_query($conn, $update_sql);
        }

        echo "<script>alert('Product inserted successfully');</script>";
    }
}


include('header.php');
?>
<div class="insert_product w-50 m-auto pt-5">
    <form action="" method="post" enctype="multipart/form-data" onsubmit="return validateForm()">
        <div class="form-group">
            <label for="list_title">List Title <span class="required">*</span></label>
            <input type="text" id="list_title" required name="list_title" class="form-control" />
            <small id="list_title_error" class="text-danger"></small>
        </div>
        <div class="form-group">
            <label for="title">Title <span class="required">*</span></label>
            <input type="text" id="title" required name="title" class="form-control" />
            <small id="title_error" class="text-danger"></small>
        </div>
        <div class="form-group">
            <label for="base_price">Base Price <span class="required">*</span></label>
            <input type="number" step="0.01" id="base_price" required name="base_price" class="form-control" />
            <small id="base_price_error" class="text-danger"></small>
        </div>
        <div class="form-group">
            <label for="description">Description <span class="required">*</span></label>
            <textarea id="description" required name="description" class="form-control"></textarea>
            <small id="description_error" class="text-danger"></small>
        </div>
        <div class="form-group">
            <label for="img">Image <span class="required">*</span></label>
            <input type="file" name="img" required class="form-control">
            <small id="img_error" class="text-danger"></small>
        </div>
        <div class="form-group">
            <label for="background_color">Background Color</label>
            <input type="text" id="background_color" name="background_color" class="form-control" placeholder="e.g., green">
            <small id="background_color_error" class="text-danger"></small>
        </div>
        <div class="form-group">
    <label for="options">Options</label>
    <div>
        <?php
        $sql = "SELECT * FROM `product_options`";  // Use your actual options table
        $res = mysqli_query($conn, $sql);
        while ($row = mysqli_fetch_assoc($res)) {
            echo "<div class='form-check'>";
            echo "<input class='form-check-input' type='checkbox' name='select_options[]' value='" . $row['option_id'] . "' id='option_" . $row['option_id'] . "'>";
            echo "<label class='form-check-label' for='option_" . $row['option_id'] . "'>" . $row['option_name'] . "</label>";
            echo "</div>";
        }
        ?>
    </div>
    <small id="select_options_error" class="text-danger"></small>
</div>


        <input type="submit" class="btn btn-primary" name="insert_product" value="Insert Product">
    </form>
</div>

<?php include('footer.php');?>

<script>
    function validateForm() {
        var isValid = true;

        // Base Price Validation
        var basePrice = document.getElementById('base_price').value.trim();
        var basePriceError = document.getElementById('base_price_error');
        if (isNaN(basePrice) || parseFloat(basePrice) <= 0) {
            basePriceError.textContent = "Enter a valid positive price";
            isValid = false;
        } else {
            basePriceError.textContent = "";
        }

        return isValid;
    }
</script>