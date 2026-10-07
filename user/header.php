<?php include("../db.php"); ?>
<!DOCTYPE html>
<html><head><title>Movie Ticket Booking</title><link rel="stylesheet" href="../style.css"></head>
<body>
<div class="nav">
  <a class="brand" href="index.php">Movie Ticket Booking</a>
  <div>
    <?php if (isset($_SESSION['user_id'])) { ?>
      <a href="my_bookings.php">My Bookings</a>
      <a href="logout.php">Logout (<?php echo h($_SESSION['user_name']); ?>)</a>
    <?php } else { ?>
      <a href="login.php">Login</a>
      <a href="register.php">Register</a>
    <?php } ?>
  </div>
</div>
<div class="page">
