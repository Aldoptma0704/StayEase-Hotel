<?php
// Lakukan koneksi ke database
include('Koneksi.php');

// Query untuk mengambil data dari tabel bookings
$sql = "SELECT * FROM bookings";
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking History</title>
    <link rel="stylesheet" href="../CSS/history.css">
</head>
<body>
    <header>
        <nav>
            <img src="../IMG/logo.png" alt="Logo" class="logo">
            <ul>
                <li class="spacer"></li>
                <li><a href="../php/HomePage.php" class="home" id="Home">Home</a></li>
                <li><a href="history.php" class="history">History</a></li>
                <li><a href="../php/search_results.php" class="booking">Booking</a></li>
            </ul>
            <img src="../IMG/icon.svg" class="icon" id="dropdown-icon">
            <div class="dropdown" id="dropdown-menu">
                <a href="HomePage.php">Home</a>
                <a href="../HTML/ChangeAccount.php">Profil</a>
                <a href="../HTML/change_password.php">Change Password</a>
                <a href="history.php">Riwayat Booking</a>
                <a href="login.php">Keluar</a>
            </div>
        </nav>
    </header>
    <h1>Booking History</h1>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Check-in</th>
                <th>Check-out</th>
                <th>Full Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Bed Type</th>
                <th>Booking Date</th>
                <th>Payment Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
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
                    // Kolom untuk status pembayaran
                    echo "<td>" . $row["payment_status"] . "</td>";
                    echo "<td>";

                    // Cek apakah tanggal check-in sudah berlalu
                    $currentDate = date("Y-m-d");
                    $checkInDate = date("Y-m-d", strtotime($row["check_in"]));

                    // Debug output untuk memeriksa tanggal
                    echo "<!-- Debug: currentDate = $currentDate, checkInDate = $checkInDate -->";

                    if ($currentDate < $checkInDate) {
                        echo "<button onclick=\"refundBooking(" . $row["id"] . ")\">Refund</button>";
                    } else {
                        echo "<button disabled>Refund</button>";
                    }
                    echo "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='10'>No bookings found.</td></tr>";
            }
            ?>
        </tbody>
    </table>
    <!-- Tambahkan link JavaScript Anda di sini -->
    <script>
        // Fungsi JavaScript untuk melakukan refund
        function refundBooking(bookingId) {
            // Konfirmasi refund dari pengguna
            if (confirm("Apakah Anda yakin ingin melakukan refund untuk booking ID " + bookingId + "?")) {
                // Kirim AJAX request untuk memanggil skrip PHP refund
                var xhr = new XMLHttpRequest();
                xhr.open("POST", "refund.php", true);
                xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                xhr.onreadystatechange = function() {
                    if (xhr.readyState == 4 && xhr.status == 200) {
                        // Tampilkan pesan keberhasilan refund dari respons PHP
                        alert(xhr.responseText);
                        // Refresh halaman untuk memperbarui riwayat
                        window.location.reload();
                    }
                };
                // Kirim data booking_id ke skrip PHP refund
                xhr.send("booking_id=" + bookingId);
            }
        }
    </script>
    <script src="dropdown.js"></script> <!-- Include JavaScript file -->
</body>
</html>
