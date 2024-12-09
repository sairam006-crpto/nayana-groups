<?php session_start(); ?>

<?php
$path = "../images/backend/";

$categoriesList = array_filter(glob($path.'*'), 'is_dir');

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    $categoryName = $_POST['category_name'];

    if (empty($categoryName)) {
        $_SESSION['message'] = "Please select a category.";
    } else {
        $categoryFolder = $path . $categoryName;

        if (!is_dir($categoryFolder)) {
            $_SESSION['message'] = "Category does not exist.";
        } else {
            if (!empty(array_filter($_FILES['images']['name']))) {
                $files = $_FILES['images'];
                $uploaded = true;

                foreach ($files['name'] as $key => $file_name) {
                    $file_tmp = $files['tmp_name'][$key];
                    $file_destination = $categoryFolder . '/' . $file_name;

                    if (move_uploaded_file($file_tmp, $file_destination) === false) {
                        $uploaded = false;
                        $_SESSION['message'] = "Failed to upload one or more images.";
                        break;
                    }
                }

                if ($uploaded) {
                    $_SESSION['message'] = "Images uploaded successfully to category '$categoryName'.";
                }
            } else {
                $_SESSION['message'] = "Please select images to upload.";
            }
        }
    }
    header("Location: images.php");
    exit();
}

if (isset($_GET['category_name'])) {
    $selectedCategory = $_GET['category_name'];
    if (!empty($selectedCategory)) {
        $categoryFolder = $path . $selectedCategory;
        $images = array_diff(scandir($categoryFolder), array('.', '..')); // Get current images in the directory
    }
}

if (isset($_POST['delete_image'])) {
    $imageToDelete = $_POST['delete_image'];
    $imagePath = $categoryFolder . '/' . $imageToDelete;
    if (file_exists($imagePath)) {
        if (unlink($imagePath)) {
            echo 'success';
            exit;
        }
    }
    echo 'failed';
    exit;
}
?>

<?php include_once('./head.php'); ?>
    <div class="container-fluid" >
        <div class="row">
            <div class="col-md-2">
                <?php include_once('./sidebar.php'); ?>
            </div>
            <div class="col-md-10">
                <h4 class="pt-3">Images</h4>
                <hr>
                <div class="row">
                    <div class="col-md-6">
                        <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" enctype="multipart/form-data">
                            <div class="form-group">
                                <label for="category_name">Select Category:</label>
                                <select name="category_name" id="categorySelect" class="form-control" onchange="showImages(this.value)">
                                    <option value="">Select Category</option>
                                    <?php
                                    foreach ($categoriesList as $category) {
                                        $categoryName = basename($category);
                                        echo '<option value="' . $categoryName . '">' . $categoryName . '</option>';
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="images">Select Images (Multiple):</label>
                                <input type="file" name="images[]" class="form-control-file" multiple>
                            </div>
                            <button type="submit" name="submit" class="btn btn-primary mt-3">Upload Images</button>
                        </form>
                        <?php
                        if (isset($_SESSION['message'])) {
                            echo '<div class="mt-3 alert alert-info" role="alert">' . $_SESSION['message'] . '</div>';
                            unset($_SESSION['message']);
                        }
                        ?>
                    </div>
                    <div class="col-md-6">
                        <div id="imagesContainer" class="mt-4">
                            <?php
                            if (isset($images)) {
                                if (count($images) > 0) {
                                    echo '<h6>Current Images in ' . $selectedCategory . '</h6>';
                                    echo '<div class="row col-md-12">';
                                    foreach ($images as $image) {
                                        echo '<div class="col-md-5 mr-1" style="border:1px solid #ced4da; border-radius:.25rem"><img src="' . $categoryFolder . '/' . $image . '" data-toggle="modal" data-target="#imageModal" style="max-width: 200px; margin: 5px; cursor: pointer;" />';
                                        echo '<form method="post" action="delete_image.php" style="position: relative; text-align:center">';
                                        echo '<input type="hidden" name="image" value="' . $image . '"/>';
                                        echo '<input type="hidden" name="category" value="' . $selectedCategory . '"/>';
                                        echo '<button type="submit" class="deleteImage shadow" onclick="return confirm(\'Are you sure you want to delete this image?\')" style="
                                                top: 0;
                                                right: 0;
                                                background-color: red;
                                                border-radius: 5px 5px 0px 0px;
                                                padding: 8px;
                                                width: 80px;
                                                height: 40px;
                                                text-align: center;
                                                border: none;
                                                cursor: pointer;
                                              ">';
                                        echo '<i class="fa fa-trash-alt text-white"></i>';
                                        echo '</button>';
                                        echo '</form>';
                                        echo '</div>';
                                    }
                                    echo "</div>";
                                } else {

                                    echo '<p>No images in ' . $selectedCategory . ' folder.</p>';
                                }
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="imageModal" tabindex="-1" role="dialog" aria-labelledby="imageModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="imageModalLabel">Image Preview</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body text-center">
                    <img src="" id="modalImage" style="max-width: 100%;" />
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>

    <script>
        $(document).on('click', 'img[data-toggle="modal"]', function () {
            var image = $(this).attr('src');
            $('#modalImage').attr('src', image);
        });
    </script>
    <script>
        function showImages(category) {
            window.location.href = 'images.php?category_name=' + category;
        }

        let params = new URLSearchParams(window.location.search);
        let categoryFromURL = params.get('category_name');

        document.addEventListener("DOMContentLoaded", function() {
            let select = document.getElementById('categorySelect');
            if (categoryFromURL !== null) {
                select.value = categoryFromURL;
            }
        });
    </script>

<?php include_once('./foot.php'); ?>