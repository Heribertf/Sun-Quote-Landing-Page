<?php
header('Content-Type: application/json');

include_once './includes/config.php';
include_once './includes/connection.php';
require './vendor/autoload.php';


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

function bookingEmail($clientName, $clientEmail, $company, $bookedDate)
{
    date_default_timezone_set('Africa/Nairobi');

    $mail = new PHPMailer(true);

    try {
        $mail->SMTPDebug = SMTP::DEBUG_OFF;
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = smtp_username;
        $mail->Password = smtp_pass;
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        //$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // TLS encryption
        //$mail->Port = 587; // Port for TLS
        $mail->Port = 465; // Port for SMTPS
        $mail->setFrom(smtp_username, 'Sun Quote Pro');
        $mail->addAddress('heribertfel20@gmail.com', 'Dev Felix');
        $mail->addReplyTo($clientEmail, $clientName);

        $mail->isHTML(true);
        $mail->Subject = 'Demo Booking';
        $mail->Body = '
            <html>
            <head>
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>Demo Booking</title>
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
                        <h3>New Demo Booking</h3>
                        <p>Hello <strong>Sun Quote,</strong></p>
                        <p>You got a new demo booking from <strong>' . $clientName . '</strong>. Below are the booking details:</p>
                        <p><strong>Client Name: </strong>' . $clientName . '<br><strong>Client Email: </strong>' . $clientEmail . '<br><strong>Company: </strong>' . $company . '<br><strong>Booked Date: </strong>' . $bookedDate . '</p>
                    </div>
                    <footer>Sun Quote Pro</footer>
                </div>
            </body>
            </html>
        ';

        $mail->send();
        return true; // Email sent successfully
    } catch (Exception $e) {
        return false; // Email sending failed
    }
}

function replyEmail($clientName, $clientEmail, $bookedDate)
{
    date_default_timezone_set('Africa/Nairobi');

    $mail = new PHPMailer(true);

    try {
        $mail->SMTPDebug = SMTP::DEBUG_OFF;
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = smtp_username;
        $mail->Password = smtp_pass;
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        //$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; // TLS encryption
        //$mail->Port = 587; // Port for TLS
        $mail->Port = 465; // Port for SMTPS
        $mail->setFrom(smtp_username, 'Sun Quote Pro');
        $mail->addAddress($clientEmail, $clientName);
        $mail->addReplyTo(smtp_username, 'Sun Quote Pro');

        $mail->isHTML(true);
        $mail->Subject = 'Demo Booking Confirmation';
        $mail->Body = '
            <html>
            <head>
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>Booking Confirmed</title>
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
                        <h3>Demo Booking Confirmed</h3>
                        <p><strong>Dear ' . $clientName . ',</strong></p>
                        <p>Thank you for showing interest with Sun Quote Pro. Your booking scheduled on <strong>' . $bookedDate . '</strong> has been received successfully and we are
                        more than happy to walk with you through the next steps.</p>
                        <p>We look forward to help you empower your business with Sun Quote Pro.</p>
                        <p>Thank you.</p>
                    </div>
                    <footer>Sun Quote Pro</footer>
                </div>
            </body>
            </html>
        ';

        $mail->send();
        return true; // Email sent successfully
    } catch (Exception $e) {
        return false; // Email sending failed
    }
}

function handleInsertion($clientName, $clientEmail, $company, $bookedDate, $conn)
{
    $query1 = "INSERT INTO bookings (client_name, client_email, company, booking_date) VALUES ( ?,?, ?,?)";
    $stmt1 = mysqli_prepare($conn, $query1);
    mysqli_stmt_bind_param($stmt1, "ssss", $clientName, $clientEmail, $company, $bookedDate);

    if (mysqli_stmt_execute($stmt1)) {
        $booking_email = bookingEmail($clientName, $clientEmail, $company, $bookedDate);
        if ($booking_email) {
            $reply_email = replyEmail($clientName, $clientEmail, $bookedDate);
            if ($reply_email) {
                return [
                    'success' => true,
                    'message' => 'Booking successful.'
                ];
            } else {
                return [
                    'success' => false,
                    'message' => 'An error occurred while processing your request.'
                ];
            }
        } else {
            return [
                'success' => false,
                'message' => 'Unable to complete booking request.'
            ];
        }

    }
    mysqli_stmt_close($stmt1);
}

function insertBooking()
{
    global $conn;

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $clientName = trim($_POST['name']);
        $clientEmail = trim($_POST['email']);
        $company = trim($_POST['company']);
        $bookedDate = trim($_POST['bkDate']);

        $response = handleInsertion($clientName, $clientEmail, $company, $bookedDate, $conn);

        echo json_encode($response);
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_GET['action'])) {
        $action = $_GET['action'];
        switch ($action) {
            case 'booking':
                insertBooking();
                break;
            default:
                echo json_encode(['success' => false, 'message' => 'Invalid request']);
                break;
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Action cannot be determined']);
    }
}

mysqli_close($conn);