<?php
$to = "receiver@example.com";
$subject = "Test Email";
$message = "This is a test email from XAMPP.";
$headers = "From: bookmycab69@gmail.com";

if (mail($to, $subject, $message, $headers)) {
    echo "Email sent successfully!";
} else {
    echo "Failed to send email.";
}
?>
