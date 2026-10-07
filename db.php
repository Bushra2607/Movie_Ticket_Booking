<?php
// Starts the session and connects to MySQL. Every page includes this file.
session_start();
ob_start(); // allows header() redirects after HTML has started

$conn = mysqli_connect("localhost", "root", "", "movie_booking");
if (!$conn) { die("Database connection failed"); }

// Run a query safely. Example: run($conn, "SELECT * FROM movies WHERE id=?", "i", $id);
// Types: i = number, s = text, d = decimal
function run($conn, $sql, $types = "", ...$params) {
    $stmt = mysqli_prepare($conn, $sql);
    if ($types != "") { mysqli_stmt_bind_param($stmt, $types, ...$params); }
    mysqli_stmt_execute($stmt);
    return mysqli_stmt_get_result($stmt); // false for INSERT/UPDATE/DELETE
}

function count_rows($conn, $table) {
    $row = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS c FROM $table"));
    return $row['c'];
}

// Make text safe to print
function h($text) { return htmlspecialchars($text); }

// Seat names: 0 -> A1, 9 -> A10, 10 -> B1 ... (10 seats per row)
function seat_label($i) { return chr(65 + intdiv($i, 10)) . ($i % 10 + 1); }

// Seats already taken for a show: paid bookings, plus unpaid ones held for 10 minutes
function booked_seats($conn, $show_id) {
    $taken = [];
    $r = run($conn, "SELECT seats FROM bookings WHERE show_id=?
        AND (status='Confirmed' OR booked_at > NOW() - INTERVAL 10 MINUTE)", "i", $show_id);
    while ($row = mysqli_fetch_assoc($r)) {
        $taken = array_merge($taken, explode(",", $row['seats']));
    }
    return $taken;
}
?>
