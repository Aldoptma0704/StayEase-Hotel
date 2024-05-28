<?php
session_start();
include('Koneksi.php');
$error = "";
$success = "";

// Check if user is logged in
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $old_password = $_POST['oldPassword'];
        $new_password = $_POST['newPassword'];
        $confirm_password = $_POST['confirmPassword'];

        // Fetch the current password from the database
        $sql = "SELECT password FROM users WHERE id = ?";
        $stmt = $conn->prepare($sql);
        if ($stmt) {
            $stmt->bind_param("i", $user_id);
            $stmt->execute();
            $stmt->store_result();
            $stmt->bind_result($current_password);
            $stmt->fetch();

            // Verify the old password
            if (password_verify($old_password, $current_password)) {
                // Check if new password and confirm password match
                if ($new_password == $confirm_password) {
                    // Check if new password meets the requirements
                    if (strlen($new_password) >= 8 && preg_match('/[A-Z]/', $new_password) &&
                        preg_match('/[a-z]/', $new_password) && preg_match('/[0-9]/', $new_password) &&
                        preg_match('/[!$#%]/', $new_password) && !preg_match('/\s/', $new_password)) {
                        
                        // Hash the new password
                        $new_password_hashed = password_hash($new_password, PASSWORD_DEFAULT);
                        
                        // Update the password in the database
                        $update_sql = "UPDATE users SET password = ? WHERE id = ?";
                        $update_stmt = $conn->prepare($update_sql);
                        if ($update_stmt) {
                            $update_stmt->bind_param("si", $new_password_hashed, $user_id);
                            if ($update_stmt->execute()) {
                                $success = "Password changed successfully.";
                            } else {
                                $error = "Error updating password.";
                            }
                            $update_stmt->close();
                        } else {
                            $error = "Error preparing update statement.";
                        }
                    } else {
                        $error = "New password does not meet the requirements.";
                    }
                } else {
                    $error = "New password and confirm password do not match.";
                }
            } else {
                $error = "Old password is incorrect.";
            }
            $stmt->close();
        } else {
            $error = "Error preparing statement.";
        }
    }
} else {
    $error = "User is not logged in.";
}

$conn->close();
?>
