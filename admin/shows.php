<?php
include("header.php");
if (isset($_POST['add'])) {
    run($conn, "INSERT INTO shows(movie_id,screen_id,show_date,show_time,price,status) VALUES(?,?,?,?,?,?)",
        "iissds", $_POST['movie_id'], $_POST['screen_id'], $_POST['show_date'],
        $_POST['show_time'], $_POST['price'], $_POST['status']);
    header("Location: shows.php");
    exit();
}
if (isset($_GET['delete'])) {
    run($conn, "DELETE FROM shows WHERE id=?", "i", $_GET['delete']);
    header("Location: shows.php");
    exit();
}
$movies = mysqli_query($conn, "SELECT id,title FROM movies");
$screens = mysqli_query($conn, "SELECT screens.id, screens.screen_name, theatres.name
    FROM screens JOIN theatres ON screens.theatre_id = theatres.id");
$shows = mysqli_query($conn, "SELECT shows.*, movies.title, theatres.name, screens.screen_name
    FROM shows
    JOIN movies ON shows.movie_id = movies.id
    JOIN screens ON shows.screen_id = screens.id
    JOIN theatres ON screens.theatre_id = theatres.id
    ORDER BY show_date DESC, show_time");
?>
<div class="box">
  <h2>Add Show</h2>
  <form method="post">
    Movie
    <select name="movie_id" required>
      <?php while ($m = mysqli_fetch_assoc($movies)) { ?>
        <option value="<?php echo $m['id']; ?>"><?php echo h($m['title']); ?></option>
      <?php } ?>
    </select>
    Theatre and screen
    <select name="screen_id" required>
      <?php while ($s = mysqli_fetch_assoc($screens)) { ?>
        <option value="<?php echo $s['id']; ?>"><?php echo h($s['name'] . " - " . $s['screen_name']); ?></option>
      <?php } ?>
    </select>
    Date <input type="date" name="show_date" required>
    Time <input type="time" name="show_time" required>
    Ticket price <input type="number" step="0.01" name="price" required>
    Status
    <select name="status"><option>Available</option><option>Not Available</option></select>
    <button type="submit" name="add">Add Show</button>
  </form>
</div>
<div class="table-wrap"><table>
  <tr><th>ID</th><th>Movie</th><th>Theatre</th><th>Screen</th><th>Date</th><th>Time</th><th>Price</th><th>Status</th><th>Action</th></tr>
  <?php while ($s = mysqli_fetch_assoc($shows)) { ?>
  <tr>
    <td><?php echo $s['id']; ?></td>
    <td><?php echo h($s['title']); ?></td>
    <td><?php echo h($s['name']); ?></td>
    <td><?php echo h($s['screen_name']); ?></td>
    <td><?php echo $s['show_date']; ?></td>
    <td><?php echo substr($s['show_time'], 0, 5); ?></td>
    <td><?php echo $s['price']; ?></td>
    <td><?php echo h($s['status']); ?></td>
    <td><a href="shows.php?delete=<?php echo $s['id']; ?>" onclick="return confirm('Delete this show?')">Delete</a></td>
  </tr>
  <?php } ?>
</table></div>
</div></body></html>
