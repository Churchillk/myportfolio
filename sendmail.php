<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'phpmailer/Exception.php';
require 'phpmailer/PHPMailer.php';
require 'phpmailer/SMTP.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate the comment field
    if (empty($_POST['comment'])) {
        die("Comment cannot be empty");
    }

    // Sanitize the comment
    $comment = htmlspecialchars($_POST['comment']);

    // Set your email address where you want to receive the comments
    $to = 'your-email@example.com';

    // Set the subject of the email
    $subject = 'New Comment on Your Website';

    // Compose the email message
    $message = "You have a new comment on your website:\n\n";
    $message .= "Comment: $comment\n";

    // Create a PHPMailer object
    $mail = new PHPMailer(true);

    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host       = 'smtp.example.com'; // Your SMTP server
        $mail->SMTPAuth   = true;
        $mail->Username   = 'your-smtp-username';
        $mail->Password   = 'your-smtp-password';
        $mail->SMTPSecure = 'tls';
        $mail->Port       = 587;

        // Recipients
        $mail->setFrom('webmaster@example.com', 'Webmaster');
        $mail->addAddress($to);

        // Content
        $mail->isHTML(false);
        $mail->Subject = $subject;
        $mail->Body    = $message;

        // Send the email
        $mail->send();

        // Optionally, you can redirect the user to a thank you page
        header('Location: thank_you.html');
        exit();
    } catch (Exception $e) {
        echo "Error sending email: {$mail->ErrorInfo}";
    }
}
?>

<!-- Your HTML form -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comment Form</title>
</head>
<body>

    <h1>Leave a Comment</h1>

    <form method="post" action="">
        <label for="comment">Comment:</label>
        <textarea name="comment" id="comment" rows="4" cols="50" required></textarea>

        <br>

        <input type="submit" value="Submit Comment">
    </form>

</body>
</html>
