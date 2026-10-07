<?php
include("header.php");
$error = "";
if (isset($_POST['register'])) {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $exists = mysqli_fetch_assoc(run($conn, "SELECT id FROM users WHERE email=?", "s", $email));
    if ($name == "" || $email == "" || strlen($_POST['password']) < 6) {
        $error = "Fill all fields. Password needs at least 6 characters.";
    } elseif ($exists) {
        $error = "This email is already registered.";
    } else {
        $hash = password_hash($_POST['password'], PASSWORD_DEFAULT); // never store the real password
        run($conn, "INSERT INTO users(name,email,password) VALUES(?,?,?)", "sss", $name, $email, $hash);
        header("Location: login.php");
        exit();
    }
}
?>
<div class="box narrow">
  <h2>Register</h2>
  <form method="post">
    Name <input type="text" name="name" required>
    Email <input type="email" name="email" required>
    Password <input type="password" name="password" required>
    <p class="error"><?php echo $error; ?></p>
    <button type="submit" name="register">Create account</button>
  </form>
</div>
</div></body></html>
