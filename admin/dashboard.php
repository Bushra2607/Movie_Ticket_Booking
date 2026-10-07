<?php
include("header.php");
$seats = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COALESCE(SUM(total_seats),0) AS s FROM screens"));
?>
<div class="box"><h1>Welcome, <?php echo h($_SESSION['admin']); ?></h1></div>
<div class="cards">
  <div class="card"><b><?php echo count_rows($conn, "movies"); ?></b>Total Movies</div>
  <div class="card"><b><?php echo count_rows($conn, "theatres"); ?></b>Total Theatres</div>
  <div class="card"><b><?php echo count_rows($conn, "shows"); ?></b>Total Shows</div>
  <div class="card"><b><?php echo count_rows($conn, "screens"); ?></b>Total Screens</div>
  <div class="card"><b><?php echo $seats['s']; ?></b>Total Seats</div>
  <div class="card"><b><?php echo count_rows($conn, "bookings"); ?></b>Total Bookings</div>
</div>
</div></body></html>
