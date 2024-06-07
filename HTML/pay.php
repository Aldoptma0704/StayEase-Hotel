<?php
session_start(); // Start the session

// Check if id exists in session
if (isset($_SESSION['id'])) {
    $id = $_SESSION['id'];
} else {
    // Handle the case where id is not found in session
    echo "No booking ID found. Please complete your booking.";
    exit;
}

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "hotel_management";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$message = "";
$allowedFileTypes = ['image/jpeg', 'image/png', 'image/svg+xml'];
$maxFileSize = 2 * 1024 * 1024; // 2 MB

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["proofOfPayment"])) {
    // Define the target directory for uploaded files
    $targetDirectory = "uploads/";

    // Check if the directory exists and is writable
    if (!is_dir($targetDirectory) || !is_writable($targetDirectory)) {
        $message = "Upload directory does not exist or is not writable.";
    } else {
        // Define the target file path
        $targetFile = $targetDirectory . basename($_FILES["proofOfPayment"]["name"]);
        $fileType = mime_content_type($_FILES["proofOfPayment"]["tmp_name"]);
        $fileSize = $_FILES["proofOfPayment"]["size"];
        $fileError = $_FILES["proofOfPayment"]["error"];

        // Validate file type
        if (in_array($fileType, $allowedFileTypes)) {
            // Validate file size
            if ($fileSize <= $maxFileSize) {
                // Check for upload errors
                if ($fileError === UPLOAD_ERR_OK) {
                    // Check if file was uploaded successfully
                    if (move_uploaded_file($_FILES["proofOfPayment"]["tmp_name"], $targetFile)) {
                        // File uploaded successfully, save the file name to the database
                        $fileName = basename($_FILES["proofOfPayment"]["name"]);
                        $sql = "UPDATE bookings SET bukti_pembayaran = '$fileName' WHERE id = $id"; // Use the session id for the booking ID
                        if ($conn->query($sql) === TRUE) {
                            $message = "File successfully uploaded and saved in the database.";
                            echo "<script>
                                    document.addEventListener('DOMContentLoaded', function() {
                                        showPopup();
                                    });
                                  </script>";
                        } else {
                            $message = "Sorry, there was an error saving the file to the database: " . $conn->error;
                        }
                    } else {
                        $message = "Sorry, there was an error moving your uploaded file.";
                    }
                } else {
                    $message = "File upload error (code $fileError). Please try again.";
                }
            } else {
                $message = "Sorry, your file is too large. Maximum file size is 2 MB.";
            }
        } else {
            $message = "Sorry, only JPG, PNG, and SVG files are allowed.";
        }
    }
} else {
    $message = "No file uploaded or request method is not POST.";
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accommodation Booking - Payment</title>
    <link rel="stylesheet" href="../CSS/Book Now.css">
    <style>
        .dropdown {
            display: none;
            position: absolute;
            top: calc(100% + 10px);
            right: 0; 
            background-color: #d9d9d9;
            border: 1px solid #042048;
            color: #ABCDF6;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            z-index: 1;
            min-width: 200px;
            border-radius: 5px; 
        }

        .dropdown a {
            display: block;
            padding: 10px 20px;
            text-decoration: none;
            color: #042048;
            border-radius: 5px;
            border-bottom: 1px solid #042048;
            font-weight: bold;
        }

        .dropdown a:hover {
            background-color: #ABCDF6;
            border-radius: 5px;
        }

        .dropdown a:last-child {
            border-bottom: none; 
        }

        .dropdown.active {
            display: block;
        }

        .popup {
            display: none;
            position: fixed;
            left: 50%;
            top: 50%;
            transform: translate(-50%, -50%);
            background-color: white;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.25);
            border-radius: 8px;
            z-index: 1000;
        }

        .popup-content {
            text-align: center;
        }

        .popup-content .close {
            position: absolute;
            right: 10px;
            top: 10px;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <header style="margin-top: -6%; width: 100%;">
        <nav>
            <img src="../IMG/logo.png" alt="Logo" class="logo">
            <ul>
                <li class="spacer"></li>
                <li><a href="../php/HomePage.php" class="home" id="Home">Home</a></li>
                <li><a href="../php/History.php" class="history">History</a></li>
                <li><a href="../php/search_results.php" class="booking">Booking</a></li>
            </ul>
            <img src="../IMG/icon.svg" class="icon" id="dropdown-icon">
            <div class="dropdown" id="dropdown-menu">
                <a href="home.php">Home</a>
                <a href="../HTML/ChangeAccount.php">Profil</a>
                <a href="../HTML/change_password.php">Change Password</a>
                <a href="riwayat.php">Riwayat Booking</a>
                <a href="../php/login.php">Keluar</a>
            </div>
        </nav>
    </header>

    <div class="container">
        <div class="right-column">
            <div class="hotel-info">
                <img src="../IMG/pay.png" alt="StayEase Hotel Lampung">
                <div>StayEase Hotel Lampung</div>
                <div>Jl. Kesambi No.7, Lempongsari, Gajah Terbang, Bandar Lampung, 50231, Lampung, Indonesia</div>
            </div>
            <div class="line"></div>
            <div class="booking-details">
                <div>My booking</div>
                <div>Occupancy: 1 room</div>
                <div>Check-in: Thu, 09 May 2024 - 3:00 PM</div>
                <div>Check-out: Fri, 10 May 2024 - 12:00 PM</div>
                <div>Superior Room</div>
                <div>Without Breakfast</div>
                <div class="line"></div>
                <div>Room(s) held for 00:15:00</div>
            </div>
        </div>

        <div class="left-column">
            <div class="logo">
                <h2><img src="../IMG/Bosst.svg" alt="Company Logo"> Your booking is guaranteed for a limited time only.</h2>
            </div>
            <p>Make sure all the details on this page are correct before proceeding to payment.</p>
            <div class="price-details">
                <div>Room Price: Rp 99</div>
                <div>(1x) Superior Room (1 night)</div>
                <div>Other Taxes and Fees: Rp 99</div>
                <div class="line"></div>
                <div>Total Price: Rp 99</div>
            </div>

            <form action="pay.php" method="post" enctype="multipart/form-data">
                <label for="proofOfPayment">Upload Proof of Payment (JPG, PNG, SVG):</label>
                <input type="file" name="proofOfPayment" id="proofOfPayment" required>
                <input type="submit" value="Upload">
            </form>
            
            <?php if ($message != ""): ?>
                <div class="popup" id="popup">
                    <div class="popup-content">
                        <span class="close" onclick="hidePopup()">&times;</span>
                        <p><?php echo $message; ?></p>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>

</body>
</html>