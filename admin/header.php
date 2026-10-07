<?php
include("../db.php");
// Only a logged-in admin can open admin pages
if (!isset($_SESSION['admin'])) { header("Location: login.php"); exit(); }
?>
<!DOCTYPE html>
<html><head><title>Admin Panel</title><link rel="stylesheet" href="../style.css"></head>
<body>
<div class="sidebar">
  <h2>Admin Panel</h2>
  <a href="dashboard.php">Dashboard</a>
  <a href="movies.php">Manage Movies</a>
  <a href="theatres.php">Manage Theatres</a>
  <a href="screens.php">Manage Screens</a>
  <a href="shows.php">Manage Shows</a>
  <a href="seats.php">Manage Seats</a>
  <a href="bookings.php">View Bookings</a>
  <a href="logout.php">Logout</a>
</div>
<div class="main">
