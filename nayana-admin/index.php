<?php
  session_start();
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if the username and password are not empty
    if (!empty($_POST['username']) && !empty($_POST['password'])) {
        // Get the posted username and password
        $username = $_POST['username'];
        $password = $_POST['password'];

        // Check if the provided username and password match
        if ($username == 'nayana') {
          if ($password == '123456') {
            // Redirect to the dashboard
            header("Location: dashboard.php");
            $_SESSION['authenticated'] = true;
            exit();
          } else {
            // Set error message in session
            $_SESSION['error'] = "Incorrect Password. Please try again.";
          }
        } else {
            // Set error message in session
            $_SESSION['error'] = "Incorrect username. Please try again.";
        }
    } else {
        // Set error message in session
        $_SESSION['error'] = "Username and password are required fields.";
    }
  }
?>

<?php include_once('./head.php'); ?>
    <div class="container">
        <div class="row mt-5 pt-5">
            <div class="col-md-6 offset-md-3">
                <div class="card p-4">
                    <div class="text-center mb-3 p-3 rounded bg-light">
                      <img src="../images/NayanaGroups-Logo-new-.png" class="img-fluid" width="150" alt="">
                      <p class="mb-0">Nayana Groups</p>
                    </div>
                    <!-- <hr> -->

                    <h5 class="text-center">Admin Login</h5>
                    <?php
                      // Display error message in an alert if it exists in the session
                      if (isset($_SESSION['error'])) {
                          echo '<div class="mt-2 alert alert-danger" role="alert">' . $_SESSION['error'] . '</div>';
                          unset($_SESSION['error']); // Clear the session error after displaying
                      }
                    ?>
                    <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                      <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" name="username" id="username" class="form-control" placeholder="Enter Username" aria-describedby="username">
                      </div>
                      <div class="form-group">
                          <label for="password">Password</label>
                          <input type="password" name="password" id="password" class="form-control" placeholder="Enter password" aria-describedby="password">
                      </div>
                      <div class="text-center">
                        <button type="submit" class="btn btn-success w-100">Login</button>
                      </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php include_once('./foot.php'); ?>
    