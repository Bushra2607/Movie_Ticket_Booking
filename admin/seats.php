<?php
include("header.php");
$shows = mysqli_query($conn, "SELECT shows.id, shows.show_date, shows.show_time, movies.title,
    theatres.name, screens.screen_name, screens.total_seats
    FROM shows
    JOIN movies ON shows.movie_id = movies.id
    JOIN screens ON shows.screen_id = screens.id
    JOIN theatres ON screens.theatre_id = theatres.id
    ORDER BY show_date DESC, show_time");
?>
<div class="box"><h2>Seat Status</h2></div>
<div class="table-wrap"><table>
  <tr><th>Movie</th><th>Theatre</th><th>Screen</th><th>Show</th><th>Total</th><th>Booked</th><th>Available</th></tr>
  <?php while ($s = mysqli_fetch_assoc($shows)) {
      $booked = count(booked_seats($conn, $s['id'])); ?>
  <tr>
    <td><?php echo h($s['title']); ?></td>
    <td><?php echo h($s['name']); ?></td>
    <td><?php echo h($s['screen_name']); ?></td>
    <td><?php echo $s['show_date'] . " " . substr($s['show_time'], 0, 5); ?></td>
    <td><?php echo $s['total_seats']; ?></td>
    <td><?php echo $booked; ?></td>
    <td><?php echo $s['total_seats'] - $booked; ?></td>
  </tr>
  <?php } ?>
</table></div>
</div></body></html>
