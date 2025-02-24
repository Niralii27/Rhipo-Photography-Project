<?php
include('config.php');

// Include PHPMailer classes
require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/SMTP.php';
require 'PHPMailer/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Function to validate and format time
function formatTime($time) {
    return date("h:i A", strtotime($time));
}

// Function to get event hours from booking table
function getEventHours($conn, $event_name) {
    $event_name = mysqli_real_escape_string($conn, $event_name);
    $sql = "SELECT hours FROM booking WHERE title = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $event_name);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($row = $result->fetch_assoc()) {
        return $row['hours'];
    }
    return 1; // Default to 1 hour if not found
}

// Function to send booking email notification
function sendBookingEmail($bookingData) {
    $mail = new PHPMailer();
    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'akbarinirali27@gmail.com'; // Your email
        $mail->Password = 'byey uwbv ebys fnlr'; // Your email password
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        $mail->setFrom('akbarinirali27@gmail.com', 'akbari nirali');
        $mail->addAddress('akbarinirali27@gmail.com'); // Your email where you want to receive notifications

        $mail->isHTML(true);
        $mail->Subject = 'New Booking: ' . $bookingData['event_name'];
        
        // Create HTML email body
        $mail->Body = "
            <html>
            <body>
                <h2>New Booking Details</h2>
                <p><strong>Client Name:</strong> {$bookingData['user_name']}</p>
                <p><strong>Email:</strong> {$bookingData['email']}</p>
                <p><strong>Event:</strong> {$bookingData['event_name']}</p>
                <p><strong>Date:</strong> {$bookingData['date']}</p>
                <p><strong>Time:</strong> {$bookingData['time']}</p>
                <p><strong>Timezone:</strong> {$bookingData['time_zone']}</p>
                <p><strong>Address:</strong> {$bookingData['address']}</p>
                <p><strong>Hours:</strong> {$bookingData['hours']}</p>
                <p><strong>Booking Created:</strong> {$bookingData['created_at']}</p>
            </body>
            </html>
        ";

        return $mail->send();
    } catch (Exception $e) {
        error_log("Email Error: " . $mail->ErrorInfo);
        return false;
    }
}

// Handle POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get JSON data from request body
    $jsonData = file_get_contents('php://input');
    $data = json_decode($jsonData, true);
    
    // Validate required fields
    if (!empty($data)) {
        $user_name = mysqli_real_escape_string($conn, $data['name']);
        $email = mysqli_real_escape_string($conn, $data['email']);
        $event_name = mysqli_real_escape_string($conn, $data['event_name']);
        $date = mysqli_real_escape_string($conn, $data['date']);
        $time = formatTime($data['time']);
        $time_zone = mysqli_real_escape_string($conn, $data['timezone']);
        $address = mysqli_real_escape_string($conn, $data['address']);
        
        // Get hours from booking table based on event name
        $hours = getEventHours($conn, $event_name);
        
        // Current timestamp for created_at
        $created_at = date('Y-m-d H:i:s');
        
        // Insert into database
        $sql = "INSERT INTO client_booking (user_name, email, event_name, date, time, time_zone, address, hours, created_at) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
                
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssssssss", 
            $user_name, 
            $email, 
            $event_name, 
            $date, 
            $time, 
            $time_zone, 
            $address, 
            $hours, 
            $created_at
        );
        
        if ($stmt->execute()) {
            // Prepare booking data for email
            $bookingData = [
                'user_name' => $user_name,
                'email' => $email,
                'event_name' => $event_name,
                'date' => $date,
                'time' => $time,
                'time_zone' => $time_zone,
                'address' => $address,
                'hours' => $hours,
                'created_at' => $created_at
            ];
            
            // Send email notification
            $emailSent = sendBookingEmail($bookingData);
            
            echo json_encode([
                'success' => true,
                'message' => 'Your booking request has been Sent successfully. A confirmation email has been sent to your email address. Please check your inbox for further details.',
                'email_sent' => $emailSent
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'message' => 'Error creating booking: ' . $stmt->error
            ]);
        }
        
        $stmt->close();
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Invalid data received'
        ]);
    }
    
    $conn->close();
    exit;
}
?>