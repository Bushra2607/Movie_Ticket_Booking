<?php
include("header.php");
$error = "";

// Add a movie with a poster image
if (isset($_POST['add'])) {
    $ext = strtolower(pathinfo($_FILES['poster']['name'], PATHINFO_EXTENSION));
    if (!in_array($ext, ["jpg", "jpeg", "png", "webp"])) {
        $error = "Poster must be a jpg, png or webp image.";
    } else {
        $poster = uniqid() . "." . $ext;   // unique file name
        move_uploaded_file($_FILES['poster']['tmp_name'], "../uploads/" . $poster);
        run($conn, "INSERT INTO movies(title,genre,language,duration,description,poster) VALUES(?,?,?,?,?,?)",
            "sssiss", $_POST['title'], $_POST['genre'], $_POST['language'], $_POST['duration'], $_POST['description'], $poster);
        header("Location: movies.php");
        exit();
    }
}
if (isset($_GET['delete'])) {
    run($conn, "DELETE FROM movies WHERE id=?", "i", $_GET['delete']);
    header("Location: movies.php");
    exit();
}
$movies = mysqli_query($conn, "SELECT * FROM movies ORDER BY id DESC");
?>
<div class="box">
  <h2>Add Movie</h2>
  <form method="post" enctype="multipart/form-data">
    Poster <input type="file" name="poster" required>
    Title <input type="text" name="title" required>
    Genre <input type="text" name="genre" required>
    Language <input type="text" name="language" required>
    Duration (minutes) <input type="number" name="duration" required>
    Description <textarea name="description" rows="3"></textarea>
    <p class="error"><?php echo $error; ?></p>
    <button type="submit" name="add">Add Movie</button>
  </form>
</div>
<div class="table-wrap"><table>
  <tr><th>ID</th><th>Poster</th><th>Title</th><th>Genre</th><th>Language</th><th>Duration</th><th>Action</th></tr>
  <?php while ($m = mysqli_fetch_assoc($movies)) { ?>
  <tr>
    <td><?php echo $m['id']; ?></td>
    <td><img src="../uploads/<?php echo h($m['poster']); ?>"></td>
    <td><?php echo h($m['title']); ?></td>
    <td><?php echo h($m['genre']); ?></td>
    <td><?php echo h($m['language']); ?></td>
    <td><?php echo $m['duration']; ?> min</td>
    <td><a href="movies.php?delete=<?php echo $m['id']; ?>" onclick="return confirm('Delete this movie?')">Delete</a></td>
  </tr>
  <?php } ?>
</table></div>
</div></body></html>
