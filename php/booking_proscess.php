<?php
session_start();
include('Koneksi.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil data dari formulir
    $room_id = $_POST['room_id'];
    $check_in = $_POST['check_in'];
    $check_out = $_POST['check_out'];
    $fullname = $_POST['fullname'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $bed_type = $_POST['bed_type'];
    
    // Tanggal booking saat ini
    $booking_date = date("Y-m-d");

    // Prepared statement untuk mencegah SQL injection
    $stmt = $conn->prepare("INSERT INTO bookings (room_id, check_in, check_out, fullname, email, phone, bed_type, booking_date) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("isssssss", $room_id, $check_in, $check_out, $fullname, $email, $phone, $bed_type, $booking_date);

    // Eksekusi prepared statement
    if ($stmt->execute()) {
        // Jika berhasil disimpan, redirect ke halaman sukses atau halaman lain
        header("Location: booking_success.php");
        exit();
    } else {
        // Jika terjadi kesalahan, tampilkan pesan error
        echo "Error: " . $stmt->error;
    }

    // Tutup statement dan koneksi
    $stmt->close();
    $conn->close();
}
?>
