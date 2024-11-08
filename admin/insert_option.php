<?php
include ('../database/connect.php');

if (isset($_POST['delete_option'])) {
    $option_id = $_POST['option_id'];
    $delete_query = "DELETE FROM product_options WHERE option_id = $option_id";
    $delete_result = mysqli_query($conn, $delete_query);
    if ($delete_result) {
        // Tag deleted successfully
        // Redirect or display a success message
    } else {
        // Error deleting option
        echo "Error: " . mysqli_error($conn);
    }
}
if (isset($_POST['insert_option'])) {
    $option_name = $_POST['option'];

    $check_query = "SELECT * FROM product_options WHERE option_name = '$option_name'";
    $check_result = mysqli_query($conn, $check_query);
    $number = mysqli_num_rows($check_result);

    if ($number > 0) {
        echo "<script>alert('Tag is already in the database');</script>";
    } else {
        $insert_query = "INSERT INTO product_options (option_name) VALUES ('$option_name')";
        $insert_result = mysqli_query($conn, $insert_query);

        if (!$insert_result) {
            echo "Error: " . mysqli_error($conn) . "<br>";
        } else {
            echo "<script>console.log('$option_name is inserted')</script>";
        }
    }
}
include('header.php');


?>

<div class="row pt-5">
    <div class="col-6">
        <div>
            <table class="table table-bordered">
                <thead>
                    <th>Id</th>
                    <th>Option Name</th>
                    <th>Action</th>
                </thead>
                <tbody>
                    <?php
                    $select = "SELECT * FROM  `product_options`";
                    $result = mysqli_query($conn, $select);

                    while ($data = mysqli_fetch_array($result)) { ?>
                        <tr>
                            <td><?= $data["option_id"] ?></td>
                            <td><?= $data["option_name"] ?></td>
                            <td>
                                <form action="" method="post">
                                    <input type="hidden" name="option_id" value="<?php echo $data['option_id']; ?>">
                                    <button type="submit" name="delete_option" class="btn btn-danger btn-sm"
                                        onclick="return confirm('Are you sure you want to delete this option?')">Delete</button>
                                    <a class="text-white text-decoration-none btn btn-success btn-sm"
                                        href="index.php?edit_product_options=<?php echo $data["option_id"] ?>">Edit</a>
                                </form>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
    <div class="col-6">
        <div>
            <form action="" method="post">
                <div class="form-group">
                    <label for="option">Add option: <span class="required">*</span></label>
                    <input type="text" name="option" class="form-control">
                </div>
                <input type="submit" value="Insert Value" class="btn btn-primary" name="insert_option">
            </form>
        </div>

    </div>
</div>
<?php include('footer.php');?>