<?php
include("header.php");
if (!isset($_SESSION['user_id'])) { header("Location: login.php"); exit(); }

$show_id = (int)($_POST['show_id'] ?? 0);
$show = mysqli_fetch_assoc(run($conn, "SELECT shows.*, movies.title, theatres.name AS theatre,
    screens.screen_name, screens.total_seats
    FROM shows
    JOIN movies ON shows.movie_id = movies.id
    JOIN screens ON shows.screen_id = screens.id
    JOIN theatres ON screens.theatre_id = theatres.id
    WHERE shows.id=?", "i", $show_id));
if (!$show) { echo "<p>Show not found.</p>"; exit(); }

// Seats come as an array from the seat page, or as "C4,C5" text from the confirm button
$chosen = $_POST['seats'] ?? [];
if (!is_array($chosen)) { $chosen = explode(",", $chosen); }

// Keep only seats that really exist and are still free
$all = [];
for ($i = 0; $i < $show['total_seats']; $i++) { $all[] = seat_label($i); }
$free = array_diff($all, booked_seats($conn, $show_id));
$chosen = array_values(array_unique(array_intersect($chosen, $free)));

if (count($chosen) == 0) {
    echo "<div class='box'><p class='error'>No valid seats selected.</p><a href='seats.php?show_id=$show_id'>Back to seats</a></div>";
    exit();
}
$seat_text = implode(",", $chosen);
$total = count($chosen) * $show['price'];

// Confirm: save the booking as Pending, then go to payment
if (isset($_POST['confirm'])) {
    run($conn, "INSERT INTO bookings(user_id,show_id,seats,seat_count,total_price) VALUES(?,?,?,?,?)",
        "iisid", $_SESSION['user_id'], $show_id, $seat_text, count($chosen), $total);
    header("Location: payment.php?id=" . mysqli_insert_id($conn));
    exit();
}
?>
<div class="box narrow">
  <h2>Booking Summary</h2>
  <p><b>Movie:</b> <?php echo h($show['title']); ?></p>
  <p><b>Theatre:</b> <?php echo h($show['theatre']); ?> (<?php echo h($show['screen_name']); ?>)</p>
  <p><b>Date:</b> <?php echo $show['show_date']; ?></p>
  <p><b>Time:</b> <?php echo $show['show_time']; ?></p>
  <p><b>Seats:</b> <?php echo h($seat_text); ?></p>
  <p><b>Price per seat:</b> <?php echo $show['price']; ?></p>
  <hr>
  <p><b>Total Amount:</b> <?php echo $total; ?></p>
  <form method="post">
    <input type="hidden" name="show_id" value="<?php echo $show_id; ?>">
    <input type="hidden" name="seats" value="<?php echo h($seat_text); ?>">
    <button type="submit" name="confirm">Proceed to payment</button>
  </form>
</div>
</div></body></html>
