<?php
include("header.php");
$id = (int)($_GET['id'] ?? 0);
$m = mysqli_fetch_assoc(run($conn, "SELECT * FROM movies WHERE id=?", "i", $id));
if (!$m) { echo "<p>Movie not found.</p>"; exit(); }

// Upcoming shows that are open for booking
$shows = run($conn, "SELECT shows.*, theatres.name, theatres.city, screens.screen_name
    FROM shows
    JOIN screens ON shows.screen_id = screens.id
    JOIN theatres ON screens.theatre_id = theatres.id
    WHERE shows.movie_id=? AND shows.status='Available' AND shows.show_date >= CURDATE()
    ORDER BY show_date, show_time", "i", $id);
?>
<div class="box detail">
  <img src="../uploads/<?php echo h($m['poster']); ?>" alt="">
  <div>
    <h1><?php echo h($m['title']); ?></h1>
    <p><b>Genre:</b> <?php echo h($m['genre']); ?></p>
    <p><b>Language:</b> <?php echo h($m['language']); ?></p>
    <p><b>Duration:</b> <?php echo $m['duration']; ?> min</p>
    <p><?php echo h($m['description']); ?></p>
  </div>
</div>
<div class="box">
  <h2>Available Shows</h2>
  <?php $found = false; while ($s = mysqli_fetch_assoc($shows)) { $found = true; ?>
  <div class="show">
    <span>
      <b><?php echo h($s['name']); ?></b>, <?php echo h($s['city']); ?> - <?php echo h($s['screen_name']); ?><br>
      <?php echo $s['show_date'] . " at " . substr($s['show_time'], 0, 5); ?> | Price: <?php echo $s['price']; ?>
    </span>
    <a class="btn" href="seats.php?show_id=<?php echo $s['id']; ?>">Select Seats</a>
  </div>
  <?php } ?>
  <?php if (!$found) { echo "<p>No upcoming shows for this movie.</p>"; } ?>
</div>
</div></body></html>
