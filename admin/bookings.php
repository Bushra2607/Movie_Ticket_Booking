<?php
include("header.php");
$bookings = mysqli_query($conn, "SELECT bookings.*, users.name AS user_name, movies.title, shows.show_date, shows.show_time
    FROM bookings
    JOIN users ON bookings.user_id = users.id
    JOIN shows ON bookings.show_id = shows.id
    JOIN movies ON shows.movie_id = movies.id
    ORDER BY bookings.id DESC");
?>
<div class="box"><h2>Booking Management</h2></div>
<div class="table-wrap"><table>
  <tr><th>ID</th><th>User</th><th>Movie</th><th>Date</th><th>Seats</th><th>Total</th><th>Status</th></tr>
  <?php while ($b = mysqli_fetch_assoc($bookings)) { ?>
  <tr>
    <td><?php echo $b['id']; ?></td>
    <td><?php echo h($b['user_name']); ?></td>
    <td><?php echo h($b['title']); ?></td>
    <td><?php echo $b['show_date'] . " " . substr($b['show_time'], 0, 5); ?></td>
    <td><?php echo h($b['seats']); ?></td>
    <td><?php echo $b['total_price']; ?></td>
    <td><?php echo h($b['status']); ?></td>
  </tr>
  <?php } ?>
</table></div>
</div></body></html>
