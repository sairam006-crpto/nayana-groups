<?php
$path = "./images/backend/"; // Replace this with the correct path

if (isset($_GET['category'])) {
    $category = $_GET['category'];

    $categoryPath = $path . $category;

    if (is_dir($categoryPath)) {
        $images = array_diff(scandir($categoryPath), array('.', '..'));

        $images = array_values($images); // Reset array index to start from 0

        $imagePaths = array_map(function ($image) use ($category, $path) {
            return $path . $category . '/' . $image;
        }, $images);

        header('Content-Type: application/json');
        echo json_encode($imagePaths);
    } else {
        http_response_code(404);
        echo "Category not found";
    }
} else {
    http_response_code(400);
    echo "Category parameter is missing";
}
?>
