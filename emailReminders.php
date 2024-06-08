<?php
include_once './includes/config.php';
include_once './includes/connection.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

function sendReminder($clientName, $clientEmail, $bookedDate)
{
    date_default_timezone_set('Africa/Nairobi');
    require './vendor/autoload.php';

    $mail = new PHPMailer(true);

    try {
        $mail->SMTPDebug = SMTP::DEBUG_OFF;
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'felixprogrammer76@gmail.com';
        $mail->Password = 'yodxzwuqsjprfqde';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        //$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // TLS encryption
        //$mail->Port = 587; // Port for TLS
        $mail->Port = 465; // Port for SMTPS
        $mail->setFrom('felixprogrammer76@gmail.com', 'Sun Quote Pro');
        $mail->addAddress($clientEmail, $clientName);
        $mail->addReplyTo('felixprogrammer76@gmail.com', 'Sun Quote Pro');

        $mail->isHTML(true);
        $mail->Subject = 'Demo Booking Reminder';
        $mail->Body = '
            <html>
            <head>
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>Booking Reminder</title>
                <style>
                    body {
                        font-family: Arial, sans-serif;
                        background-color: #f4f4f4;
                        margin: 0;
                        padding: 0;
                    }

                    .container {
                        max-width: 576px;
                        margin: 0 auto;
                        padding: 20px;
                        background-color: #ffffff;
                        border-radius: 10px;
                        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
                    }
        
                    .card {
                        border: 1px solid #e1e1e1;
                        border-radius: 5px;
                        padding: 20px;
                        background-color: #ffffff;
                        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
                        max-width: 550px;

                    }

                    h3 {
                        color: #333333;
                        font-size: 1.5rem;
                        text-align: center;
                    }

                    p {
                        color: #555555;
                        font-size: 1rem;
                    }

                    a.button {
                        display: inline-block;
                        padding: 1rem 2rem;
                        background-color: #075C52;
                        color: #ffffff;
                        text-decoration: none;
                        border-radius: 5px;
                        font-size: 0.875rem;
                    }

                    img {
                        max-width: 100%;
                        height: auto;
                    }

                    footer {
                        margin-top: 10px;
                        text-align: center;
                        color: #ffffff;
                        font-size: 0.875rem; /* 14px */
                        background: linear-gradient(to right, #3b8276, #2e6f65, #235b53, #174740, #0b325e);
                        padding: 10px;
                        max-width: 550px;
                        border-radius: 0 0 10px 10px; /* Rounded bottom corners */
                    }
                </style>
            </head>
            <body>
                <div class="container">
                    <div class="card">
                        <h3>Demo Booking Reminder</h3>
                        <p><strong>Dear ' . $clientName . ',</strong></p>
                        <p>This is a reminder that you have a Sun Quote Pro demo booking scheduled for <strong>' . $bookedDate . '</strong>.</p>
                        <p>Best Regards.</p>
                        <p>Sun Quote Pro Team.</p>
                    </div>
                    <footer>Sun Quote Pro</footer>
                </div>
            </body>
            </html>
        ';

        $mail->send();
        return true;
    } catch (Exception $e) {
        return false;
    }
}

$tomorrow = date('Y-m-d', strtotime('+1 day'));
$start_time = $tomorrow . ' 00:00:00';
$end_time = $tomorrow . ' 23:59:59';

$sql = "SELECT booking_id, client_name, client_email, DATE_FORMAT(booking_date, '%d-%b-%Y %h:%i %p') AS booked_date FROM bookings WHERE status = 0 AND booking_date BETWEEN '$start_time' AND '$end_time'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $client_name = $row["client_name"];
        $client_email = $row["client_email"];
        $booking_date = $row["booked_date"];
        $booking_id = $row["booking_id"];

        $reminderEmail = sendReminder($client_name, $client_email, $booking_date);

        if ($reminderEmail) {
            $update_query = "UPDATE bookings SET status = 1 WHERE booking_id = ?";
            $stmt1 = mysqli_prepare($conn, $update_query);
            mysqli_stmt_bind_param($stmt1, "i", $booking_id);
            mysqli_stmt_execute($stmt1);
            mysqli_stmt_close($stmt1);

            echo "Email sent to " . $client_email . "\n";
        } else {
            echo "Failed to send email to " . $client_email . "\n";
        }
    }
} else {
    echo "No appointments found for tomorrow.";
}
$conn->close();