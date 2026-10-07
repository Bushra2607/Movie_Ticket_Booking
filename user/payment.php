<?php
include("header.php");
if (!isset($_SESSION['user_id'])) { header("Location: login.php"); exit(); }

// Only your own unpaid booking, held for 10 minutes
$id = (int)($_GET['id'] ?? 0);
$b = mysqli_fetch_assoc(run($conn, "SELECT * FROM bookings WHERE id=? AND user_id=? AND status='Pending'
    AND booked_at > NOW() - INTERVAL 10 MINUTE", "ii", $id, $_SESSION['user_id']));
if (!$b) { header("Location: my_bookings.php"); exit(); }

$error = "";
if (isset($_POST['pay'])) {
    // This is a demo payment: card details are only checked, never saved.
    $card = str_replace(" ", "", $_POST['card']);
    if (trim($_POST['holder']) == "") {
        $error = "Enter the card holder name.";
    } elseif (!preg_match('/^\d{16}$/', $card)) {
        $error = "Card number must be 16 digits.";
    } elseif (!preg_match('/^(0[1-9]|1[0-2])\/\d{2}$/', $_POST['expiry'])) {
        $error = "Expiry must look like 09/32.";
    } elseif (!preg_match('/^\d{3}$/', $_POST['cvv'])) {
        $error = "CVV must be 3 digits.";
    } else {
        run($conn, "UPDATE bookings SET status='Confirmed' WHERE id=?", "i", $id);
        echo "<script>alert('Payment Successful! Booking Confirmed'); location='my_bookings.php';</script>";
        exit();
    }
}
?>
<div class="box narrow">
  <h2>Payment</h2>
  <p><b>Total Amount:</b> <?php echo $b['total_price']; ?></p>
  <form method="post">
    <input type="text" name="holder" placeholder="Card holder name" required>
    <input type="text" name="card" placeholder="Card number (16 digits)" maxlength="19" required>
    <input type="text" name="expiry" placeholder="Expiry (MM/YY)" maxlength="5" required>
    <input type="password" name="cvv" placeholder="CVV" maxlength="3" required>
    <p class="error"><?php echo $error; ?></p>
    <button type="submit" name="pay">Pay Now</button>
  </form>
  <p>Your seats are held for 10 minutes.</p>
</div>
</div></body></html>
