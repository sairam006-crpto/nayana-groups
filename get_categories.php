<?php
$path = "./images/backend/"; // Replace this with the correct path

$categories = array_filter(glob($path . '*'), 'is_dir');
$categoryNames = array_map('basename', $categories);

header('Content-Type: application/json');
echo json_encode($categoryNames);
?>
