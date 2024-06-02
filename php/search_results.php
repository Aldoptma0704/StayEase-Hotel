<?php
session_start();
include('Koneksi.php');

// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $check_in = $_POST['check_in'];
    $check_out = $_POST['check_out'];
    $room_type = $_POST['rooms'];

    // SQL query
    $sql = "SELECT * FROM rooms WHERE room_type = ? AND id NOT IN (
                SELECT id FROM bookings 
                WHERE (check_in <= ? AND check_out >= ?)
            )";

    // Prepared statement to prevent SQL injection
    $stmt = $conn->prepare($sql);

    // Check if the statement was prepared successfully
    if ($stmt === false) {
        die('Prepare failed: ' . htmlspecialchars($conn->error));
    }

    // Bind parameters
    $stmt->bind_param("sss", $room_type, $check_out, $check_in);

    // Execute the query
    $stmt->execute();

    // Get the result
    $result = $stmt->get_result();

    // Check for execution errors
    if ($result === false) {
        die('Execute failed: ' . htmlspecialchars($stmt->error));
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>StayEase Hotels</title>
    <link rel="stylesheet" href="../CSS/search_results.css">
</head>
<body>
<header style="margin-top: -3%; width: 100%;">
    <nav>
        <img src="../IMG/logo.png" alt="Logo" class="logo">
        <ul>
            <li class="spacer"></li>
            <li><a href="Regist.html" class="home" id="Home">Home</a></li>
            <li><a href="history.php" class="history">History</a></li>
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

<div class="form-container">
    <form action="search_results.php" method="POST">
        <div class="form-group">
            <label for="check-in">Check-in</label>
            <div>
                <img src="../img/Calender.svg" alt="Calendar Logo" class="calendar-logo">
                <input type="date" id="check-in" name="check_in" value="2024-01-01">
            </div>
        </div>

        <div class="form-group">
            <label for="check-out">Check-out</label>
            <div>
                <img src="../img/Calender.svg" alt="Calendar Logo" class="calendar-logo">
                <input type="date" id="check-out" name="check_out" value="2024-01-02">
            </div>
        </div>

        <div class="form-group">
            <label for="rooms">Rooms</label>
            <select id="rooms" name="rooms">
                <option value="Superior Room">Superior Room</option>
                <option value="Deluxe Room">Deluxe Room</option>
                <option value="Junior Room">Junior Room</option>
                <option value="Executive Suite">Executive Suite</option>
                <option value="Executive Studio">Executive Studio</option>
            </select>
        </div>

        <button type="submit" class="search-button">SEARCH</button>
    </form>
</div>

<div class="available-rooms" style="width: 100%">
    <div class="room-container" style="width: 100%">
        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($result)) {
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $bookingUrl = "../HTML/Book Now.html?check_in=" . urlencode($check_in) . "&check_out=" . urlencode($check_out) . "&room_type=" . urlencode($row['room_type']) . "&price=" . urlencode($row['price_per_night']) . "&bed_type=" . urlencode($row['bed_type']) . "&max_guests=" . urlencode($row['max_guests']) . "&area=" . urlencode($row['area']);
                    
                    // Fetch and split image paths
                    $image_paths = explode(',', $row['image']);
                    ?>
                    <div class="room-card">
                        <div class="room-image">
                            <?php foreach ($image_paths as $image): ?>
                                <img src="<?php echo htmlspecialchars($image); ?>" alt="<?php echo htmlspecialchars($row['room_type']); ?> ">
                            <?php endforeach; ?>
                        </div>
                        <div class="room-details">
                            <h2><?php echo htmlspecialchars($row['room_type']); ?></h2>
                            <p class="description"><?php echo htmlspecialchars($row['description']); ?></p>
                            <p class="price">Rp <?php echo htmlspecialchars($row['price_per_night']); ?> / night</p>
                            <div class="features">
                                <div class="feature"><p><?php echo htmlspecialchars($row['bed_type']); ?></p></div>
                                <div class="feature"><p><?php echo htmlspecialchars($row['max_guests']); ?> guests</p></div>
                                <div class="feature"><p><?php echo htmlspecialchars($row['area']); ?> m²</p></div>
                            </div>
                            <div class="buttons">
                                <button><p>Shower</p></button>
                                <button><p>Refrigerator</p></button>
                                <button><p>Air conditioning</p></button>
                            </div>
                            <a href="<?php echo $bookingUrl; ?>" class="book-now-button">BOOK NOW</a>
                        </div>
                    </div>
                    <?php
                }
            } else {
                echo "<p>Tidak ada kamar yang tersedia untuk tanggal yang dipilih.</p>";
            }
        }
        ?>
    </div>
</div>

<h2>Key Features</h2>
<div class="footer">
    <div class="feature-column">
        <button>
            <div class="feature-content">
                <img src="../IMG/Meeting rooms.svg" alt="Meeting Rooms">
                <p>Meeting rooms</p>
            </div>
        </button>
    </div>
    <div class="feature-column">
        <button>
            <div class="feature-content">
                <img src="../IMG/person max. capacity.svg" alt="1,500 person max. capacity">
                <p>1,500 person max. capacity</p>
            </div>
        </button>
    </div>
    <div class="feature-column">
        <button>
            <div class="feature-content">
                <img src="../IMG/Ballroom pre-function area.svg" alt="Ballroom pre-function area">
                <p>Ballroom pre-function area</p>
            </div>
        </button>
    </div>
    <div class="feature-column">
        <button>
            <div class="feature-content">
                <img src="../IMG/Catering Service.svg" alt="Catering Service">
                <p>Catering Service</p>
            </div>
        </button>
    </div>
    <div class="feature-column">
        <button>
            <div class="feature-content">
                <img src="../IMG/Free Wi-Fi.svg" alt="Free Wi-Fi">
                <p>Free Wi-Fi</p>
            </div>
        </button>
    </div>
    <div class="feature-column">
        <button>
            <div class="feature-content">
                <img src="../IMG/Wedding and event coordinator.svg" alt="Wedding and event coordinator">
                <p>Wedding and event coordinator</p>
            </div>
        </button>
    </div>
    <div class="feature-column">
        <button>
            <div class="feature-content">
                <img src="../IMG/Reception.svg" alt="Reception">
                <p>Reception</p>
            </div>
        </button>
    </div>
    <div class="feature-column">
        <button>
            <div class="feature-content">
                <img src="../IMG/Theater.svg" alt="Theater">
                <p>Theater</p>
            </div>
        </button>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="../JS/Home Page.js"></script>
</body>
</html>
