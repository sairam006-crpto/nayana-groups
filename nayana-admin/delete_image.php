<?php
    // Check if the image to be deleted is specified
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['image'])) {
        $imageToDelete = $_POST['image'];
        $category = $_POST['category'];

        // Directory where images are stored
        $categoryFolder = '../images/backend/';
        // Check if the image file exists before attempting deletion
        if (file_exists($categoryFolder . $category. '/' . $imageToDelete)) {
            // Attempt to delete the image file
            if (unlink($categoryFolder . $category.'/' . $imageToDelete)) {
                // Image deleted successfully
                $_SESSION['message'] = 'Image deleted';
                
            } else {
                // Error in deleting the image
                $_SESSION['message'] = 'Failed to delete image';
            }
        } else {
            // Image file doesn't exist
            $_SESSION['message'] = 'Image not found';
        }
        header("Location: images.php?category_name=".$_POST['category']);
    } else {
        // Image parameter not provided
        $_SESSION['message'] = 'No image specified for deletion';
        header("Location: images.php");
    }
?>
