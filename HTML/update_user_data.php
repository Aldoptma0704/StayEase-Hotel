<?php
session_start();
include('Koneksi.php');

$user_data = [];
$error = "";

// Check if user is logged in
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];

    // Fetch user data from database
    $sql = "SELECT first_name, last_name, mobile_phone, email, birth_date FROM users WHERE id = ?";
    $stmt = $conn->prepare($sql);
    if ($stmt) {
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $user_data = $result->fetch_assoc();
        } else {
            $error = "User not found.";
        }
        $stmt->close();
    } else {
        $error = "Error preparing statement: " . $conn->error;
    }
} else {
    $error = "User is not logged in.";
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $first_name = $_POST['firstName'];
    $last_name = $_POST['lastName'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $birth_date = $_POST['birthDate'];

    // SQL query to update user data
    $sql = "UPDATE users SET first_name = ?, last_name = ?, mobile_phone = ?, email = ?, birth_date = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("sssssi", $first_name, $last_name, $phone, $email, $birth_date, $user_id);

        if ($stmt->execute()) {
            echo "Profile updated successfully";
            // Optionally, you can refresh the page to reflect updated data
            // header("Location: update_user_data.php");
        } else {
            $error = "Error updating profile: " . $stmt->error;
        }

        $stmt->close();
    } else {
        $error = "Error preparing statement: " . $conn->error;
    }

    $conn->close();
}
?>