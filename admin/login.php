<?php
include("../db.php");
$error = "";
if (isset($_POST['login'])) {
    $admin = mysqli_fetch_assoc(run($conn, "SELECT * FROM admin WHERE username=?", "s", $_POST['username']));
    if ($admin && password_verify($_POST['password'], $admin['password'])) {
        $_SESSION['admin'] = $admin['username'];
        header("Location: dashboard.php");
        exit();
    }
    $error = "Invalid username or password";
}
?>
<!DOCTYPE html>
<html><head><title>Admin Login</title><link rel="stylesheet" href="../style.css"></head>
<body>
<div class="box narrow">
  <h2>Admin Login</h2>
  <form method="post">
    Username <input type="text" name="username" required>
    Password <input type="password" name="password" required>
    <p class="error"><?php echo $error; ?></p>
    <button type="submit" name="login">Login</button>
  </form>
</div>
</body></html>
