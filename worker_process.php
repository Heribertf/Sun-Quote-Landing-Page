<?php
require './vendor/autoload.php';
include_once './includes/config.php';

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;
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
        $mail->Port = 465;
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

$connection = new AMQPStreamConnection('localhost', 5672, 'guest', 'guest');
$channel = $connection->channel();

$channel->queue_declare('email_queue', false, true, false, false);
echo ' [*] Waiting for messages. To exit press CTRL+C', "\n";

$callback = function ($msg) {
    $data = json_decode($msg->body, true);
    $clientName = $data['clientName'];
    $clientEmail = $data['clientEmail'];
    $company = $data['company'];
    $bookedDate = $data['bookedDate'];

    $bookingEmail = bookingEmail($clientName, $clientEmail, $company, $bookedDate);
    $replyEmail = replyEmail($clientName, $clientEmail, $bookedDate);

    if ($bookingEmail && $replyEmail) {
        echo " [x] Emails sent successfully\n";
        $msg->delivery_info['channel']->basic_ack($msg->delivery_info['delivery_tag']);
    } else {
        echo " [x] Failed to send emails\n";
        $msg->delivery_info['channel']->basic_reject($msg->delivery_info['delivery_tag'], false);
    }
};

$channel->basic_qos(null, 1, null);
$channel->basic_consume('email_queue', '', false, false, false, false, $callback);

function checkQueueStatus($channel, $queueName)
{
    list($queue, $messageCount, $consumerCount) = $channel->queue_declare($queueName, true);
    return $messageCount;
}

while (true) {
    $channel->wait(null, false, 1); // Timeout set to 1 second
    $messageCount = checkQueueStatus($channel, 'email_queue');
    if ($messageCount == 0 && empty($channel->callbacks)) {
        break;
    }
}

$channel->close();
$connection->close();
