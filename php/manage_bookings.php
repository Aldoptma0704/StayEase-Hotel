<?php
session_start();
if (!isset($_SESSION['login_user']) || !$_SESSION['is_admin']) {
    header("location: login.php");
}

include('Koneksi.php');

// Handle delete booking
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $conn->query("DELETE FROM bookings WHERE id=$id");
}

// Fetch bookings data
$bookings = $conn->query("SELECT bookings.*, users.username FROM bookings JOIN users ON bookings.user_id = users.id");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Kelola Riwayat</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <h2>Kelola Riwayat</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Username</th>
            <th>Room Type</th>
            <th>Check In</th>
            <th>Check Out</th>
            <th>Price</th>
            <th>Actions</th>
        </tr>
        <?php while($row = $bookings->fetch_assoc()): ?>
        <tr>
            <td><?php echo $row['id']; ?></td>
            <td><?php echo $row['username']; ?></td>
            <td><?php echo $row['room_type']; ?></td>
            <td><?php echo $row['check_in']; ?></td>
            <td><?php echo $row['check_out']; ?></td>
            <td><?php echo $row['price']; ?></td>
            <td>
                <a href="edit_booking.php?id=<?php echo $row['id']; ?>">Edit</a>
                <a href="manage_bookings.php?delete=<?php echo $row['id']; ?>">Delete</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
    <a href="dashboard.php">Back to Dashboard</a>
</body>
</html>
