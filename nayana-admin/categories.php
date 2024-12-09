<?php
session_start();
$path = "../images/backend/";
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['category_name'])) {
    $categoryName = $_POST['category_name'];
    $categoryFolder = $path . $categoryName; // Replace './your_specified_path/' with the actual directory path you want to create the category in

    if (empty($categoryName)) {
        $_SESSION['message'] = "Category name cannot be empty.";
    } else {
        if (!is_dir($categoryFolder)) {
            if (mkdir($categoryFolder)) {
                $_SESSION['message'] = "Category '$categoryName' created successfully.";
            } else {
                $_SESSION['message'] = "Failed to create category '$categoryName'.";
            }
        } else {
            $_SESSION['message'] = "Category '$categoryName' already exists.";
        }
    }
    header("Location: categories.php");
    exit();
}

$categoriesList = array_filter(glob($path.'*'), 'is_dir');

if (isset($_GET['delete'])) {
    $deleteCategory = $_GET['delete'];
    $categoryPath = $path . $deleteCategory;
    if (is_dir($categoryPath)) {
        $files = glob($categoryPath . '/*'); // Get all files in the directory
        foreach ($files as $file) {
            if (is_file($file)) {
                unlink($file); // Delete file
            }
        }
        if (rmdir($categoryPath)) {
            $_SESSION['message'] = "Category '$deleteCategory' and its images deleted successfully.";
        } else {
            $_SESSION['message'] = "Failed to delete category '$deleteCategory'.";
        }
        header("Location: categories.php");
        exit();
    }
}
?>      

<?php include_once('./head.php'); ?>
    <div class="container-fluid" >
        <div class="row">
            <div class="col-md-2">
                <?php include_once('./sidebar.php'); ?>
            </div>
            <div class="col-md-10">
                <h4 class="pt-3">Categories</h4>
                <hr>
                <div class="row">
                    <div class="col-md-6">
                        <?php
                                if (isset($_SESSION['message'])) {
                                    echo '<div class="mt-3 alert alert-info" role="alert">' . $_SESSION['message'] . '</div>';
                                    unset($_SESSION['message']);
                                }
                        ?>
                        <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                            <div class="form-group">
                                <label for="category_name">Category Name:</label>
                                <input type="text" class="form-control" name="category_name" id="category_name">
                            </div>
                            <button type="submit" class="btn btn-primary">Add Category</button>
                        </form>
                        <?php
                        if ($_SERVER["REQUEST_METHOD"] == "POST") {
                            echo '<div class="mt-3 alert alert-info" role="alert">';
                            if (!isset($_POST['category_name']) || empty($_POST['category_name'])) {
                                echo "Category name is required.";
                            } else {
                                if (!is_dir('./your_specified_path/' . $_POST['category_name'])) {
                                    echo "Category '" . $_POST['category_name'] . "' created successfully.";
                                } else {
                                    echo "Category '" . $_POST['category_name'] . "' already exists.";
                                }
                            }
                            echo '</div>';
                        }
                        ?>
                    <!-- </div>
                    <div class="col-md-6"> -->
                        <h6 class="mt-5">Categories List</h6>
                        <ul class="list-group">
                            <?php foreach ($categoriesList as $category) {
                                $categoryName = basename($category);
                                echo '<li class="list-group-item">' . $categoryName . ' <a href="?delete=' . $categoryName . '" class="text-danger float-right" onclick="return confirmDelete(\'' . $categoryName . '\')">Delete</a></li>';
                            }
                            ?>
                        </ul>   
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        function confirmDelete(categoryName) {
            return confirm("Are you sure you want to delete category " + categoryName + "? This action will delete all images in the folder.");
        }
    </script>
<?php include_once('./foot.php'); ?>