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
                <li><a href="#" class="history">History</a></li>
            </ul>
            <img src="../IMG/icon.svg" class="icon" id="dropdown-icon">
            <div class="dropdown" id="dropdown-menu">
                <a href="home.php">Home</a>
                <a href="../HTML/ChangeAccount.php">Profil</a>
                <a href="../HTML/change_password.php">Contact</a>
                <a href="riwayat.php">Riwayat Booking</a>
                <a href="index.html">Keluar</a>
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
                <th>Action</th> <!-- Kolom tambahan untuk tombol aksi -->
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
                    echo "<td>"; // Mulai kolom untuk tombol aksi
                    echo "<button onclick=\"refundBooking(" . $row["id"] . ")\">Refund</button>";
                    echo "<button onclick=\"rescheduleBooking(" . $row["id"] . ")\">Reschedule</button>";
                    echo "</td>"; // Akhiri kolom untuk tombol aksi
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='9'>No bookings found.</td></tr>";
            }
            ?>
        </tbody>
    </table>
    <!-- Tambahkan link JavaScript Anda di sini -->
    <script>
        // Fungsi JavaScript untuk melakukan refund
        // Fungsi JavaScript untuk melakukan refund
        function refundBooking(bookingId) {
        // Konfirmasi refund dari pengguna
        if(confirm("Apakah Anda yakin ingin melakukan refund untuk booking ID " + bookingId + "?")) {
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

        // Fungsi JavaScript untuk melakukan reschedule
        function rescheduleBooking(bookingId) {
            // Konfirmasi reschedule dari pengguna
            if(confirm("Apakah Anda yakin ingin melakukan reschedule untuk booking ID " + bookingId + "?")) {
                // Kirim AJAX request untuk memanggil skrip PHP reschedule
                var xhr = new XMLHttpRequest();
                xhr.open("POST", "reschedule.php", true);
                xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                xhr.onreadystatechange = function() {
                    if (xhr.readyState == 4 && xhr.status == 200) {
                        // Tampilkan pesan keberhasilan reschedule dari respons PHP
                        alert(xhr.responseText);
                        // Refresh halaman untuk memperbarui riwayat
                        window.location.reload();
                    }
                };
                // Kirim data booking_id ke skrip PHP reschedule
                xhr.send("booking_id=" + bookingId);
            }
        }

    </script>
</body>
</html>
