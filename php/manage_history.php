<?php
// Lakukan koneksi ke database
include('Koneksi.php');

// Query untuk mengambil data dari tabel bookings
$sql = "SELECT * FROM bookings";
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html>
<head>
    <title>Kelola Riwayat</title>
    <link rel="stylesheet" type="text/css" href="../CSS/manage_history.css">
</head>
<body>
    <header>
        <nav>
            <img src="../IMG/Logo.png" alt="Logo">
            <ul>
                <li><h3>ADMIN</h3></li>
                <li><img src="../IMG/Photo by Grigore Ricky.png" alt="Profile Picture" class="profile-pic"></li>
            </ul>
        </nav>
    </header>
    <div class="sidebar">
        <a href="dashboard.php"><img src="../IMG/material-symbols_dashboard-outline.svg" alt="Dashboard">Dashboard</a>
        <a href="manage_room.php"><img src="../IMG/ic_baseline-room-preferences.svg" alt="Rooms">Kelola Kamar</a>
        <a href="manage_users.php"><img src="../IMG/fa6-solid_user-group.svg" alt="Users">Kelola Pengguna<img src="../IMG/oui_arrow-up.svg" alt="" class="arrow">   </a>
        <a href="manage_history.php"><img src="../IMG/material-symbols_history.svg" alt="History">Kelola Riwayat</a>
    </div>
    <h2>Kelola Riwayat</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Check In</th>
            <th>Check Out</th>
            <th>Full Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Bed Type</th>
            <th>Booking Date</th>
            <th>Actions</th>
        </tr>
        <?php
        // Periksa apakah ada hasil dari query
        if ($result->num_rows > 0) {
            // Tampilkan setiap baris data sebagai row dalam tabel
            while($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["id"] . "</td>";
                echo "<td>" . $row["check_in"] . "</td>";
                echo "<td>" . $row["check_out"] . "</td>";
                echo "<td>" . $row["fullname"] . "</td>";
                echo "<td>" . $row["email"] . "</td>";
                echo "<td>" . $row["phone"] . "</td>";
                echo "<td>" . $row["bed_type"] . "</td>";
                echo "<td>" . $row["booking_date"] . "</td>";
                echo "<td>"; // Mulai kolom untuk tombol aksi
                echo "<button onclick=\"deleteBooking(" . $row["id"] . ")\">Delete</button>";
                echo "</td>"; // Akhiri kolom untuk tombol aksi
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='9'>No bookings found.</td></tr>";
        }
        ?>
    </table>
    <a href="dashboard.php">Back to Dashboard</a>
</body>
</html>
