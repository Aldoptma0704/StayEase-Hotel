<?php
// Lakukan koneksi ke database
include('Koneksi.php');

// Jika ada request POST untuk mengkonfirmasi pesanan
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['confirm_booking'])) {
    // Ambil ID pemesanan yang akan dikonfirmasi
    $booking_id = $_POST['booking_id'];

    // Query untuk mengupdate status pemesanan menjadi "Confirmed"
    $update_sql = "UPDATE bookings SET payment_status = 'Confirmed' WHERE id = $booking_id";
    
    if ($conn->query($update_sql) === TRUE) {
        // Redirect kembali ke halaman ini setelah berhasil mengkonfirmasi
        header("Location: manage_history.php");
        exit();
    } else {
        echo "Error updating record: " . $conn->error;
    }
}

// Jika ada request POST untuk menghapus pesanan
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete_booking'])) {
    // Ambil ID pemesanan yang akan dihapus
    $booking_id = $_POST['delete_booking'];

    // Query untuk menghapus pemesanan
    $delete_sql = "DELETE FROM bookings WHERE id = $booking_id";
    
    if ($conn->query($delete_sql) === TRUE) {
        // Redirect kembali ke halaman ini setelah berhasil menghapus
        header("Location: manage_history.php");
        exit();
    } else {
        echo "Error deleting record: " . $conn->error;
    }
}

// Query untuk mengambil data dari tabel bookings
$sql = "SELECT * FROM bookings";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Kelola Riwayat</title>
    <link rel="stylesheet" type="text/css" href="../CSS/manage_history.css">
    <script>
    function deleteBooking(bookingId) {
        if (confirm("Are you sure you want to delete this booking?")) {
            var form = document.createElement('form');
            form.method = 'POST';
            form.action = '';

            var input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'delete_booking';
            input.value = bookingId;

            form.appendChild(input);
            document.body.appendChild(form);
            form.submit();
        }
    }
    </script>
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
        <a href="manage_users.php"><img src="../IMG/fa6-solid_user-group.svg" alt="Users">Kelola Tamu</a>
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
                echo "<form method='post'>";
                echo "<input type='hidden' name='booking_id' value='" . $row["id"] . "'>";
                echo "<button type='submit' name='confirm_booking'>Confirm</button>"; // Tombol "Confirm" dengan tipe submit
                echo "<button type='button' onclick=\"deleteBooking(" . $row["id"] . ")\">Delete</button>"; // Tombol "Delete"
                echo "</form>";
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
