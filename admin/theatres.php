<?php
include("header.php");
if (isset($_POST['add'])) {
    run($conn, "INSERT INTO theatres(name,location,city,screens) VALUES(?,?,?,?)",
        "sssi", $_POST['name'], $_POST['location'], $_POST['city'], $_POST['screens']);
    header("Location: theatres.php");
    exit();
}
if (isset($_GET['delete'])) {
    run($conn, "DELETE FROM theatres WHERE id=?", "i", $_GET['delete']);
    header("Location: theatres.php");
    exit();
}
$theatres = mysqli_query($conn, "SELECT * FROM theatres ORDER BY id DESC");
?>
<div class="box">
  <h2>Add Theatre</h2>
  <form method="post">
    Theatre name <input type="text" name="name" required>
    Location <input type="text" name="location" required>
    City <input type="text" name="city" required>
    Number of screens <input type="number" name="screens" min="1" required>
    <button type="submit" name="add">Add Theatre</button>
  </form>
</div>
<div class="table-wrap"><table>
  <tr><th>ID</th><th>Name</th><th>Location</th><th>City</th><th>Screens</th><th>Action</th></tr>
  <?php while ($t = mysqli_fetch_assoc($theatres)) { ?>
  <tr>
    <td><?php echo $t['id']; ?></td>
    <td><?php echo h($t['name']); ?></td>
    <td><?php echo h($t['location']); ?></td>
    <td><?php echo h($t['city']); ?></td>
    <td><?php echo $t['screens']; ?></td>
    <td><a href="theatres.php?delete=<?php echo $t['id']; ?>" onclick="return confirm('Delete this theatre?')">Delete</a></td>
  </tr>
  <?php } ?>
</table></div>
</div></body></html>
