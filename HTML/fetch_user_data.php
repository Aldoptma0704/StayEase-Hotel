<?php
session_start();
include 'koneksi.php';

$user_id = $_SESSION['user_id']; // assuming user_id is stored in session

$sql = "SELECT first_name, last_name, phone, email, birth_date FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

echo json_encode($user);
?>
