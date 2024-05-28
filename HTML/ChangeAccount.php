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
            <img src="../IMG/Logo.png" alt="Logo" class="logo">
            <ul>
                <li><a href="Regist.html" class="home">Home</a></li>
                <li><a href="#" class="history">History</a></li>
                <li><a href="#" class="change-profile">Change Profile</a></li>
                <li><a href="#" class="profile-info">Profile Information</a></li>
            </ul>
            <img src="../IMG/Phone.svg" alt="Phone" class="phone-icon">
        </nav>
    </header>

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
</body>
</html>
