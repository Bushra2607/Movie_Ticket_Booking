<?php
include("header.php");
if (isset($_POST['add'])) {
    run($conn, "INSERT INTO screens(theatre_id,screen_name,total_seats) VALUES(?,?,?)",
        "isi", $_POST['theatre_id'], $_POST['screen_name'], $_POST['total_seats']);
    header("Location: screens.php");
    exit();
}
if (isset($_GET['delete'])) {
    run($conn, "DELETE FROM screens WHERE id=?", "i", $_GET['delete']);
    header("Location: screens.php");
    exit();
}
$theatres = mysqli_query($conn, "SELECT id,name FROM theatres");
$screens = mysqli_query($conn, "SELECT screens.*, theatres.name FROM screens
    JOIN theatres ON screens.theatre_id = theatres.id ORDER BY screens.id DESC");
?>
<div class="box">
  <h2>Add Screen</h2>
  <form method="post">
    Theatre
    <select name="theatre_id" required>
      <?php while ($t = mysqli_fetch_assoc($theatres)) { ?>
        <option value="<?php echo $t['id']; ?>"><?php echo h($t['name']); ?></option>
      <?php } ?>
    </select>
    Screen name <input type="text" name="screen_name" placeholder="Screen 1" required>
    Total seats <input type="number" name="total_seats" min="1" required>
    <button type="submit" name="add">Add Screen</button>
  </form>
</div>
<div class="table-wrap"><table>
  <tr><th>ID</th><th>Theatre</th><th>Screen</th><th>Total Seats</th><th>Action</th></tr>
  <?php while ($s = mysqli_fetch_assoc($screens)) { ?>
  <tr>
    <td><?php echo $s['id']; ?></td>
    <td><?php echo h($s['name']); ?></td>
    <td><?php echo h($s['screen_name']); ?></td>
    <td><?php echo $s['total_seats']; ?></td>
    <td><a href="screens.php?delete=<?php echo $s['id']; ?>" onclick="return confirm('Delete this screen?')">Delete</a></td>
  </tr>
  <?php } ?>
</table></div>
</div></body></html>
