<?php
include("header.php");
if (!isset($_SESSION['user_id'])) { header("Location: login.php"); exit(); }

$show_id = (int)($_GET['show_id'] ?? 0);
$show = mysqli_fetch_assoc(run($conn, "SELECT shows.*, movies.title, theatres.name AS theatre,
    screens.screen_name, screens.total_seats
    FROM shows
    JOIN movies ON shows.movie_id = movies.id
    JOIN screens ON shows.screen_id = screens.id
    JOIN theatres ON screens.theatre_id = theatres.id
    WHERE shows.id=?", "i", $show_id));
if (!$show) { echo "<p>Show not found.</p>"; exit(); }

$booked = booked_seats($conn, $show_id);   // seats nobody else can pick
?>
<div class="box">
  <h1><?php echo h($show['title']); ?></h1>
  <p><?php echo h($show['theatre']) . " | " . $show['show_date'] . " | " . substr($show['show_time'], 0, 5); ?><br>
     <?php echo h($show['screen_name']); ?> | Price per seat: <?php echo $show['price']; ?></p>

  <form method="post" action="summary.php">
    <input type="hidden" name="show_id" value="<?php echo $show_id; ?>">
    <div class="seats">
      <?php for ($i = 0; $i < $show['total_seats']; $i++) {
          $label = seat_label($i);
          $taken = in_array($label, $booked); ?>
        <label class="seat <?php echo $taken ? 'taken' : ''; ?>">
          <input type="checkbox" name="seats[]" value="<?php echo $label; ?>" <?php echo $taken ? 'disabled' : ''; ?>>
          <span><?php echo $label; ?></span>
        </label>
      <?php } ?>
    </div>
    <button type="submit">Proceed to book</button>
  </form>
</div>
</div></body></html>
