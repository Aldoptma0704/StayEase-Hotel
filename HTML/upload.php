<?php
// Koneksi ke database (sesuaikan dengan konfigurasi Anda)
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "hotel_management";

// Buat koneksi
$conn = new mysqli($servername, $username, $password, $dbname);

// Periksa koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["proofOfPayment"])) {
    // Tentukan direktori penyimpanan untuk file yang diunggah
    $targetDirectory = "uploads/";

    // Tentukan nama file yang diunggah
    $targetFile = $targetDirectory . basename($_FILES["proofOfPayment"]["name"]);

    // Periksa apakah file sudah diunggah dengan benar
    if (move_uploaded_file($_FILES["proofOfPayment"]["tmp_name"], $targetFile)) {
        // File berhasil diunggah, simpan nama file ke dalam database
        $fileName = basename($_FILES["proofOfPayment"]["name"]);
        $sql = "UPDATE bookings SET bukti_pembayaran = '$fileName' WHERE id = 12"; // Ubah 'id_booking = 1' sesuai dengan kondisi yang sesuai
        if ($conn->query($sql) === TRUE) {
            // Tampilkan pesan sukses jika query berhasil dieksekusi
            echo "File berhasil diunggah dan disimpan di database.";
        } else {
            // Tampilkan pesan kesalahan jika query gagal dieksekusi
            echo "Maaf, terjadi kesalahan saat menyimpan file di database: " . $conn->error;
        }
    } else {
        // Jika terjadi kesalahan saat mengunggah file, tampilkan pesan kesalahan
        echo "Maaf, terjadi kesalahan saat mengunggah file.";
    }
}

// Tutup koneksi database
$conn->close();
?>
