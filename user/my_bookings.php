<?php
include("header.php");
if (!isset($_SESSION['user_id'])) { header("Location: login.php"); exit(); }
$bookings = run($conn, "SELECT bookings.*, movies.title, theatres.name AS theatre, shows.show_date, shows.show_time
    FROM bookings
    JOIN shows ON bookings.show_id = shows.id
    JOIN movies ON shows.movie_id = movies.id
    JOIN screens ON shows.screen_id = screens.id
    JOIN theatres ON screens.theatre_id = theatres.id
    WHERE bookings.user_id=? ORDER BY bookings.id DESC", "i", $_SESSION['user_id']);
?>
<h1>My Bookings</h1>
<div class="table-wrap"><table>
  <tr><th>Movie</th><th>Theatre</th><th>Show</th><th>Seats</th><th>Total</th><th>Status</th></tr>
  <?php while ($b = mysqli_fetch_assoc($bookings)) { ?>
  <tr>
    <td><?php echo h($b['title']); ?></td>
    <td><?php echo h($b['theatre']); ?></td>
    <td><?php echo $b['show_date'] . " " . substr($b['show_time'], 0, 5); ?></td>
    <td><?php echo h($b['seats']); ?></td>
    <td><?php echo $b['total_price']; ?></td>
    <td><?php echo h($b['status']); ?>
      <?php if ($b['status'] == 'Pending') { ?> - <a href="payment.php?id=<?php echo $b['id']; ?>">Pay</a><?php } ?>
    </td>
  </tr>
  <?php } ?>
</table></div>
</div></body></html>
