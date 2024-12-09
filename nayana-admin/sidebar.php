<?php
    // session_start();

    // Check if the user is authenticated
    if (!isset($_SESSION['authenticated']) || $_SESSION['authenticated'] !== true) {
        header("Location: index.php"); // Redirect to login page if not authenticated
        exit();
    }

    function logout() {
        session_unset(); // Unset all session variables
        session_destroy(); // Destroy the session
    
        // Redirect to the login page or any other page after logout
        header("Location: index.php");
        exit();
    }
    
    // Handle logout when clicked
    if (isset($_GET['logout'])) {
        logout();
    }
?>

<div class="p-3" style="height: 98vh; background-color: #f9f9f9;">
    <h4>Nayana Groups</h4>
    <hr>
    <ul class="list-group">
        <a href="dashboard.php">
            <li class="list-group-item <?php echo (basename($_SERVER['SCRIPT_FILENAME']) == 'dashboard.php') ? 'active' : ''; ?>">
                Dashboard
            </li>
        </a>
        <a href="categories.php">
            <li class="list-group-item <?php echo (basename($_SERVER['SCRIPT_FILENAME']) == 'categories.php') ? 'active' : ''; ?>">
                Categories
            </li>
        </a>
        <a href="images.php">
            <li class="list-group-item <?php echo (basename($_SERVER['SCRIPT_FILENAME']) == 'images.php') ? 'active' : ''; ?>">
                Images
            </li>
        </a>
        <a href="?logout" onclick="return confirm('Are you sure you want to logout?')">
            <li class="list-group-item text-danger">Logout</li>
        </a>
    </ul>
</div>