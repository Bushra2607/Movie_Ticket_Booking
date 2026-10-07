<?php
include("header.php");
$error = "";
if (isset($_POST['login'])) {
    $user = mysqli_fetch_assoc(run($conn, "SELECT * FROM users WHERE email=?", "s", $_POST['email']));
    if ($user && password_verify($_POST['password'], $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_name'] = $user['name'];
        header("Location: index.php");
        exit();
    }
    $error = "Invalid email or password";
}
?>
<div class="box narrow">
  <h2>Login</h2>
  <form method="post">
    Email <input type="email" name="email" required>
    Password <input type="password" name="password" required>
    <p class="error"><?php echo $error; ?></p>
    <button type="submit" name="login">Login</button>
  </form>
  <p>New here? <a href="register.php">Register</a></p>
</div>
</div></body></html>
