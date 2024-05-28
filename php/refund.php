<?php
include('Koneksi.php');

// Pastikan hanya metode POST yang diterima
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Periksa apakah parameter booking_id telah diterima
    if(isset($_POST['booking_id'])) {
        // Ambil booking_id dari POST data
        $booking_id = $_POST['booking_id'];

        // Query untuk menghapus entri dari tabel bookings berdasarkan booking_id
        $delete_sql = "DELETE FROM bookings WHERE id = '$booking_id'";

        if ($conn->query($delete_sql) === TRUE) {
            // Jika penghapusan berhasil, kirim pesan keberhasilan
            echo "Refund berhasil!";
        } else {
            // Jika terjadi kesalahan, kirim pesan error
            echo "Error: " . $conn->error;
        }
    } else {
        // Jika parameter booking_id tidak diterima, kirim pesan error
        echo "Parameter booking_id tidak diterima.";
    }
} else {
    // Jika metode yang diterima bukan POST, kirim pesan error
    echo "Metode yang diterima harus POST.";
}
?>
