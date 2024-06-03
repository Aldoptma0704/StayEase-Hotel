<?php
// Lakukan koneksi ke database
include('Koneksi.php');

// Periksa apakah parameter booking_id telah diterima dari permintaan POST
if(isset($_POST['booking_id'])) {
    // Escape karakter khusus dari nilai booking_id untuk mencegah serangan SQL Injection
    $bookingId = $conn->real_escape_string($_POST['booking_id']);

    // Buat query SQL untuk menghapus entri booking berdasarkan ID yang diberikan
    $sql = "DELETE FROM bookings WHERE id = '$bookingId'";

    // Jalankan query dan periksa apakah penghapusan berhasil
    if($conn->query($sql) === TRUE) {
        echo "Booking with ID $bookingId has been successfully rescheduled.";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
} else {
    echo "Booking ID is not provided.";
}

// Tutup koneksi ke database
$conn->close();
?>
