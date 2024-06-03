<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change Profile</title>
    <link rel="stylesheet" href="../CSS/changeaccount.css">
</head>
<body>
    <header>
    <nav>
        <img src="../IMG/logo.png" alt="Logo" class="logo">
        <ul>
            <li class="spacer"></li>
            <li><a href="../php/HomePage.php" class="home" id="Home">Home</a></li>
            <li><a href="../php/history.php" class="history">History</a></li>
        </ul>
        <img src="../IMG/icon.svg" class="icon" id="dropdown-icon">
        <div class="dropdown" id="dropdown-menu">
              <a href="../php/HomePage.php">Home</a>
              <a href="../HTML/ChangeAccount.php">Profil</a>
              <a href="../HTML/change_password.php">Contact</a>
              <a href="../php/history.php">Riwayat Booking</a>
              <a href="login.php">Keluar</a>
          </div>
    </nav>
    </header>

    <script src="dropdown.js"></script>

    <div class="profile-container">
        <h2>Change Profile</h2>
        <form id="changeProfileForm" action="update_user_data.php" method="POST">
            <div class="form-group">
                <label for="firstName">First Name *</label>
                <input type="text" id="firstName" name="firstName" value="<?php echo htmlspecialchars($user_data['first_name'] ?? ''); ?>" required>
            </div>
            <div class="form-group">
                <label for="lastName">Last Name *</label>
                <input type="text" id="lastName" name="lastName" value="<?php echo htmlspecialchars($user_data['last_name'] ?? ''); ?>" required>
            </div>
            <div class="form-group">
                <label for="phone">Mobile Phone *</label>
                <input type="tel" id="phone" name="phone" value="<?php echo htmlspecialchars($user_data['phone'] ?? ''); ?>" required>
            </div>
            <div class="form-group">
                <label for="email">Email *</label>
                <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user_data['email'] ?? ''); ?>" required>
            </div>
            <div class="form-group">
                <label for="birthDate">Birth Date (MM/DD/YYYY) *</label>
                <input type="date" id="birthDate" name="birthDate" value="<?php echo htmlspecialchars($user_data['birth_date'] ?? ''); ?>" required>
            </div>
            <div class="form-actions">
                <button type="submit">SAVE</button>
                <button type="button" onclick="cancelChanges()">CANCEL</button>
            </div>
        </form>
        <?php if (!empty($error)) { echo "<p class='error'>$error</p>"; } ?>
    </div>
    

    <script src="script.js"></script>
    <script src="../php/dropdown.js"></script> <!-- Include JavaScript file -->
</body>
</html>
