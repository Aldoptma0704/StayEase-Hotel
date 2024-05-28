<?php
include('Koneksi.php');
session_start(); // Start the session

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Read the raw POST data
    $rawData = file_get_contents("php://input");
    // Decode the JSON data
    $data = json_decode($rawData, true);

    if ($data) {
        // Extract data from the decoded JSON
        $check_in = $data['check_in'];
        $check_out = $data['check_out'];
        $fullname = $data['fullname'];
        $email = $data['email'];
        $phone = $data['phone'];
        $bed_type = $data['bed_type'];
        $booking_date = date("Y-m-d H:i:s");

        // Prepared statement to prevent SQL injection
        $stmt = $conn->prepare("INSERT INTO bookings (check_in, check_out, fullname, email, phone, bed_type, booking_date) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sssssss", $check_in, $check_out, $fullname, $email, $phone, $bed_type, $booking_date);

        if ($stmt->execute()) {
            // Get the ID of the last inserted row
            $id = $conn->insert_id;

            // Store booking ID in session
            $_SESSION['id'] = $id;

            echo json_encode(["status" => "success", "message" => "Booking successful!"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Booking failed. Please try again."]);
        }

        $stmt->close();
    } else {
        echo json_encode(["status" => "error", "message" => "Invalid JSON data."]);
    }
    $conn->close();
} else {
    echo json_encode(["status" => "error", "message" => "Invalid request method."]);
}
?>
