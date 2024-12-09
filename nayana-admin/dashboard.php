<?php session_start(); ?>

<?php
$path = "../images/backend/";

$categoriesList = array_filter(glob($path.'*'), 'is_dir');
$selectedCategory = isset($_GET['category_name']) ? $_GET['category_name'] : (count($categoriesList) > 0 ? basename($categoriesList[0]) : null);

if (!empty($selectedCategory)) {
    $categoryFolder = $path . $selectedCategory;
    $images = array_diff(scandir($categoryFolder), array('.', '..')); // Get current images in the directory
}
?>

<?php include_once('./head.php'); ?>
      <div class="container-fluid" >
        <div class="row">
            <div class="col-md-2">
                <?php include_once('./sidebar.php'); ?>
            </div>
            <div class="col-md-10">
                <h4 class="pt-3">Dashboard</h4>
                <hr>
                <div class="btn-group">
                    <?php foreach ($categoriesList as $category) {
                        $categoryName = basename($category);
                        $activeClass = $selectedCategory === $categoryName ? ' active' : '';
                        echo '<a href="?category_name=' . $categoryName . '" class="btn btn-primary' . $activeClass . '">' . $categoryName . '</a>';
                    }
                    ?>
                </div>

                <div id="imagesContainer" class="mt-4">
                    <?php
                    if (isset($images)) {
                        if (count($images) > 0) {
                            // echo '<h3>Images in ' . $selectedCategory . '</h3>';
                            foreach ($images as $image) {
                                echo '<img src="' . $categoryFolder . '/' . $image . '" data-toggle="modal" data-target="#imageModal" style="max-width: 200px; margin: 5px; cursor: pointer;" />';
                            }
                        } else {
                            echo '<p>No images available.</p>';
                        }
                    }
                    ?>
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
<?php include_once('./foot.php'); ?>
