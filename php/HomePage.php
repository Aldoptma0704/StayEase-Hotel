<?php
include('Koneksi.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $check_in = $_POST['check_in'];
    $check_out = $_POST['check_out'];
    $room_type = $_POST['rooms'];

    // Prepare and bind
    $stmt = $conn->prepare("SELECT * FROM rooms WHERE room_type = ? AND id NOT IN (
                                SELECT room_id FROM room_availability 
                                WHERE (check_in <= ? AND check_out >= ?)
                            )");
    $stmt->bind_param("sss", $room_type, $check_out, $check_in);

    // Execute statement
    $stmt->execute();

    // Get result
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "<h2>Kamar Tersedia</h2>";
        while($row = $result->fetch_assoc()) {
            echo "<div class='room-info'>";
            echo "<div class='room-image'><img src='../IMG/" . $row['image'] . "' alt='Gambar kamar hotel' class='lightbox-trigger'><p>" . $row['description'] . "</p></div>";
            echo "<div class='room-details'><h2>" . $row['room_type'] . "</h2><p class='price'>Rp " . $row['price_per_night'] . "/ night</p>";
            echo "<div class='features'>";
            echo "<div class='feature'><img src='../IMG/Mask group.svg' alt='Twin Bed'><p>" . $row['bed_type'] . "</p></div>";
            echo "<div class='feature'><img src='../IMG/Mask group (1).svg' alt='Guests'><p>" . $row['max_guests'] . " guests</p></div>";
            echo "<div class='feature'><img src='../IMG/Mask group (2).svg' alt='Area'><p>" . $row['area'] . " m²</p></div>";
            echo "</div>";
            echo "<div class='buttons'><button><p>Shower</p></button><button><p>Refrigerator</p></button><button><p>Air conditioning</p></button></div>";
            echo "</div>";
            echo "</div>";
        }
    } else {
        echo "Tidak ada kamar yang tersedia untuk tanggal yang dipilih.";
    }

    // Close statement
    $stmt->close();
}

// Close connection
$conn->close();
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>StayEase Hotels</title>
  <link rel="stylesheet" href="../CSS/HomePage.css">
</head>
<body>
  <header>
    <nav>
        <img src="../IMG/logo.png" alt="Logo" class="logo">
        <ul>
            <li class="spacer"></li>
            <li><a href="HomePage.php" class="home" id="Home">Home</a></li>
            <li><a href="history.php" class="history">History</a></li>
        </ul>
        <img src="../IMG/icon.svg" class="icon" id="dropdown-icon">
        <div class="dropdown" id="dropdown-menu">
              <a href="HomePage.php">Home</a>
              <a href="../HTML/ChangeAccount.php">Profil</a>
              <a href="../HTML/change_password.php">Contact</a>
              <a href="history.php">Riwayat Booking</a>
              <a href="login.php">Keluar</a>
          </div>
    </nav>
</header>

<script src="dropdown.js"></script>

<div class="lightbox">
  <span class="prev">&lt;</span>
  <span class="next">&gt;</span>
  <img class="lightbox-image" src="../IMG/Slide.svg" alt="Slide">
</div>
  

<div class="header">
  <h2 style="margin-top: 100px;">StayEase Hotel Lampung</h2>
  <img style="margin-top: 100px;" class="star-image" src="../img/Star.png" alt="Star" width="20" height="20">
</div>
<div class="hotel-details">
  <div class="detail-item">
    <img src="../img/Pin.svg" alt="Address">
    <p><span>Jl. Kesambi No.7, Lempongsari, Gajah Terbang, Bandar Lampung 50231, Lampung, Indonesia |</span></p>
  </div>
  <div class="detail-item">
    <img src="../img/Phone.svg" alt="Phone">
    <p>+62 721 1234567|</p>
  </div>
  <div class="detail-item">
    <img src="../img/Message.svg" alt="Email">
    <p>stayease.lampung@stayease.com</p>
  </div>
</div>

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
            <option value="1">Superior Room</option>
            <option value="2">Deluxe Room</option>
            <option value="3">Junior Room</option>
            <option value="4">Executive Suite</option>
            <option value="5">Executive Studio</option>
        </select>
    </div>

    <button type="submit" class="search-button">SEARCH</button>
  </form>
</div>


<div class="welcome_section">
  <img class="logo-imagef" src="../img/explore.jpeg" alt="Logo">
</div>

<div class="container">
  <div class="large-box">
      <div class="image-container">
          <img src="../img/Slide2.svg" alt="Hotel Interior 1" class="lightbox-trigger">
          <div class="lightbox">
              <img src="../img/Slide2.svg" alt="Hotel Interior 1" class="lightbox-image">
          </div>
      </div>
  </div>
  <div class="small-box">
      <div class="box">
          <div class="image-container">
              <img src="../img/Slide.svg" alt="Hotel Interior 2" class="lightbox-trigger">
              <div class="lightbox">
                  <img src="../img/Slide.svg" alt="Hotel Interior 2" class="lightbox-image">
              </div>
          </div>
      </div>
      <div class="box">
          <div class="image-container">
              <img src="../img/restaurant.png" alt="Hotel Gym" class="lightbox-trigger">
              <div class="lightbox">
                  <img src="../img/restaurant.png" alt="Hotel Gym" class="lightbox-image">
              </div>
          </div>
      </div>
  </div>
  <div class="small-box">
    <div class="box">
        <div class="image-container">
            <img src="../img/Slide3.svg" alt="Hotel Interior 2" class="lightbox-trigger">
            <div class="lightbox">
                <img src="../img/Slide3.svg" alt="Hotel Interior 2" class="lightbox-image">
            </div>
        </div>
    </div>
    <div class="box">
        <div class="image-container">
            <img src="../img/Slide4.svg" alt="Hotel Gym" class="lightbox-trigger">
            <div class="lightbox">
                <img src="../img/Slide4.svg" alt="Hotel Gym" class="lightbox-image">
            </div>
        </div>
    </div>
</div>
<div class="small-box">
  <div class="box">
      <div class="image-container">
          <img src="../img/Slide5.svg" alt="Hotel Interior 2" class="lightbox-trigger">
          <div class="lightbox">
              <img src="../img/Slide5.svg" alt="Hotel Interior 2" class="lightbox-image">
          </div>
      </div>
  </div>
  <div class="box">
      <div class="image-container">
          <img src="../IMG/Slide1.svg" alt="Hotel Gym" class="lightbox-trigger">
          <div class="lightbox">
              <img src="../IMG/Slide1.svg" alt="Hotel Gym" class="lightbox-image">
          </div>
      </div>
  </div>
</div>
</div>

<div class="welcome_section">
  <img class="logo-imager" src="../IMG/explore2.jpeg" alt="Logo">
</div>
<div class="rooms-container">
  <div class="room-info">
    <div class="room-image">
      <img src="../IMG/Property 3.svg" alt="Gambar kamar hotel" class="lightbox-trigger">
      <p>Lobby Bar And Lounge</p>
    </div>
    <div class="room-details">
      <h2>Superior Room</h2>
      <p class="price">Rp 99/ night</p>
      <div class="features">
        <div class="feature">
          <img src="../IMG/Mask group.svg" alt="Twin Bed">
          <p>2 Twin Bed Or 1 King Bed</p>
        </div>
        <div class="feature">
          <img src="../IMG/Mask group (1).svg" alt="Guests">
          <p>2 guests</p>
        </div>
        <div class="feature">
          <img src="../IMG/Mask group (2).svg" alt="Area">
          <p>32.0 m²</p>
        </div>
      </div>
      <div class="buttons">
        <button><p>Shower</p></button>
        <button><p>Wheelchair Access</p></button>
        <button><p>Refrigerator</p></button>
        <button><p>Air conditioning</p></button>
      </div>
    </div>
  </div>

  <div class="room-info">
    <div class="room-image">
      <img src="../IMG/Property 2.svg" alt="Gambar kamar hotel" class="lightbox-trigger">
      <p>Lobby Bar And Lounge</p>
    </div>
    <div class="room-details">
      <h2>Deluxe Room</h2>
      <p class="price">Rp 99/ night</p>
      <div class="features">
        <div class="feature">
          <img src="../IMG/Mask group.svg" alt="Twin Bed">
          <p>2 Twin Bed Or 1 King Bed</p>
        </div>
        <div class="feature">
          <img src="../IMG/Mask group (1).svg" alt="Guests">
          <p>2 guests</p>
        </div>
        <div class="feature">
          <img src="../IMG/Mask group (2).svg" alt="Area">
          <p>32.0 m²</p>
        </div>
      </div>
      <div class="buttons">
        <button><p>Shower</p></button>
        <button><p>Refrigerator</p></button>
        <button><p>Air conditioning</p></button>
      </div>
    </div>
  </div>

  <div class="room-info">
    <div class="room-image">
      <img src="../IMG/Property 1.svg" alt="Gambar kamar hotel" class="lightbox-trigger">
      <p>Lobby Bar And Lounge</p>
    </div>
    <div class="room-details">
      <h2>Junior suite</h2>
      <p class="price">Rp 99/ night</p>
      <div class="features">
        <div class="feature">
          <img src="../IMG/Mask group.svg" alt="Twin Bed">
          <p>1 King Bed </p>
        </div>
        <div class="feature">
          <img src="../IMG/Mask group (1).svg" alt="Guests">
          <p>2 guests</p>
        </div>
        <div class="feature">
          <img src="../IMG/Mask group (2).svg" alt="Area">
          <p>44.0 m²</p>
        </div>
      </div>
      <div class="buttons">
        <button><p>Shower</p></button>
        <button><p>Refrigerator</p></button>
        <button><p>Air conditioning</p></button>
      </div>
    </div>
  </div>

  <div class="room-info">
    <div class="room-image">
      <img src="../IMG/Property 4.svg" alt="Gambar kamar hotel" class="lightbox-trigger">
      <p>Lobby Bar And Lounge</p>
    </div>
    <div class="room-details">
      <h2>Executive suite</h2>
      <p class="price">Rp 99/ night</p>
      <div class="features">
        <div class="feature">
          <img src="../IMG/Mask group.svg" alt="Twin Bed">
          <p>2 Twin Bed Or 1 King Bed</p>
        </div>
        <div class="feature">
          <img src="../IMG/Mask group (1).svg" alt="Guests">
          <p>2 guests</p>
        </div>
        <div class="feature">
          <img src="../IMG/Mask group (2).svg" alt="Area">
          <p>44.0 m²</p>
        </div>
      </div>
      <div class="buttons">
        <button><p>Shower</p></button>
        <button><p>Refrigerator</p></button>
        <button><p>Air conditioning</p></button>
      </div>
    </div>
  </div>

  <div class="room-info">
    <div class="room-image">
      <img src="../IMG/Property 1.svg" alt="Gambar kamar hotel" class="lightbox-trigger">
      <p>Lobby Bar And Lounge</p>
    </div>
    <div class="room-details">
      <h2>Deluxe Room</h2>
      <p class="price">Rp 99/ night</p>
      <div class="features">
        <div class="feature">
          <img src="../IMG/Mask group.svg" alt="Twin Bed">
          <p>2 Twin Bed Or 1 King Bed</p>
        </div>
        <div class="feature">
          <img src="../IMG/Mask group (1).svg" alt="Guests">
          <p>2 guests</p>
        </div>
        <div class="feature">
          <img src="../IMG/Mask group (2).svg" alt="Area">
          <p>32.0 m²</p>
        </div>
      </div>
      <div class="buttons">
        <button><p>Shower</p></button>
        <button><p>Refrigerator</p></button>
        <button><p>Air conditioning</p></button>
      </div>
    </div>
  </div>

  <div class="room-info">
    <div class="room-image">
      <img src="../IMG/Property 2.svg" alt="Gambar kamar hotel" class="lightbox-trigger">
      <p>Lobby Bar And Lounge</p>
    </div>
    <div class="room-details">
      <h2>Deluxe Room</h2>
      <p class="price">Rp 99/ night</p>
      <div class="features">
        <div class="feature">
          <img src="../IMG/Mask group.svg" alt="Twin Bed">
          <p>2 Twin Bed Or 1 King Bed</p>
        </div>
        <div class="feature">
          <img src="../IMG/Mask group (1).svg" alt="Guests">
          <p>2 guests</p>
        </div>
        <div class="feature">
          <img src="../IMG/Mask group (2).svg" alt="Area">
          <p>32.0 m²</p>
        </div>
      </div>
      <div class="buttons">
        <button><p>Shower</p></button>
        <button><p>Refrigerator</p></button>
        <button><p>Air conditioning</p></button>
      </div>
    </div>
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
  <script src="../JS/Home Page.js"></script> <!-- Include JavaScript file -->
</body>
</html>