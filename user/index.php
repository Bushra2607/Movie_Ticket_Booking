<?php
include("header.php");
$movies = mysqli_query($conn, "SELECT * FROM movies ORDER BY id DESC");
?>
<h1>Now Showing</h1>
<div class="movies">
  <?php while ($m = mysqli_fetch_assoc($movies)) { ?>
  <div class="movie">
    <img src="../uploads/<?php echo h($m['poster']); ?>" alt="">
    <h3><?php echo h($m['title']); ?></h3>
    <p><?php echo h($m['genre']); ?><br><?php echo h($m['language']); ?></p>
    <a class="btn" href="movie.php?id=<?php echo $m['id']; ?>">Book Now</a>
  </div>
  <?php } ?>
</div>
</div></body></html>
