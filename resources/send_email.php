<?php
// Load PHPMailer manually
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
require 'PHPMailer/src/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Database Connection
$servername = "localhost";
$username = "root"; 
$password = "#Yukendran@2004&09"; 
$dbname = "attendance_db"; 

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch attendance records with student details
$sql = "SELECT 
            s.firstname, 
            s.lastname, 
            s.email, 
            a.attendanceStatus, 
            a.dateMarked, 
            a.unit 
        FROM tblstudents s
        INNER JOIN tblattendance a 
        ON s.registrationNumber = a.studentRegistrationNumber";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $mail = new PHPMailer(true);
        try {
            // SMTP Configuration
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'bookmycab69@gmail.com'; // ✅ Your Gmail
            $mail->Password = 'lhwk lzlg dsuz cmka'; // ✅ Your App Password
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;

            // Email Settings
            $mail->setFrom('bookmycab69@gmail.com', 'Attendance Admin');
            $mail->addAddress($row['email'], $row['firstname'] . ' ' . $row['lastname']);
            $mail->Subject = "📢 Attendance Status Notification";

            // Email Content
            $message = "Dear " . $row['firstname'] . " " . $row['lastname'] . ",\n\n";
            $message .= "This is to inform you about your attendance record:\n";
            $message .= "--------------------------------------------\n";
            $message .= "📚 Course Unit: " . $row['unit'] . "\n";
            $message .= "📅 Date Marked: " . $row['dateMarked'] . "\n";
            $message .= "✅ Attendance Status: " . strtoupper($row['attendanceStatus']) . "\n";
            $message .= "--------------------------------------------\n\n";
            $message .= "Please ensure you maintain good attendance.\n\n";
            $message .= "Best regards,\nAttendance Management System";

            $mail->Body = $message;

            if ($mail->send()) {
                echo "✅ Email successfully sent to: " . $row['email'] . "<br>";
            } else {
                echo "❌ Failed to send email to: " . $row['email'] . "<br>";
            }
        } catch (Exception $e) {
            echo "❌ Email error: {$mail->ErrorInfo} <br>";
        }
    }
} else {
    echo "⚠️ No attendance records found.";
}

$conn->close();
?>
