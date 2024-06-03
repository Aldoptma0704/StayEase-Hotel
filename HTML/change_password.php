<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change Password</title>
    <link rel="stylesheet" href="../CSS/changePassword.css">
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

    <div class="password-container">
        <h2>Change Password</h2>
        <form id="changePasswordForm" action="changePassword.php" method="POST">
            <div class="form-group">
                <label for="oldPassword">Old Password *</label>
                <input type="password" id="oldPassword" name="oldPassword" required>
            </div>
            <div class="form-group">
                <label for="newPassword">New Password *</label>
                <input type="password" id="newPassword" name="newPassword" required>
            </div>
            <div class="form-group">
                <label for="confirmPassword">Confirm Password *</label>
                <input type="password" id="confirmPassword" name="confirmPassword" required>
            </div>
            <p class="password-rules">At least 8 characters long, case sensitive, can contain !$#%, no spaces, not the same as previous password or login</p>
            <div class="form-actions">
                <button type="submit">SAVE</button>
                <button type="button" onclick="cancelChanges()">CANCEL</button>
            </div>
        </form>
        <?php if (!empty($error)) { echo "<p class='error'>$error</p>"; } ?>
        <?php if (!empty($success)) { echo "<p class='success'>$success</p>"; } ?>
    </div>

    <script src="../php/dropdown.js"></script> <!-- Include JavaScript file -->
</body>
</html>