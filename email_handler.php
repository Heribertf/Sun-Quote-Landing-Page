<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
header('Content-Type: application/json');

include_once './includes/config.php';
include_once './includes/connection.php';
require './vendor/autoload.php';

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

function sendEmailToQueue($clientName, $clientEmail, $company, $bookedDate)
{
    $connection = new AMQPStreamConnection('localhost', 5672, 'guest', 'guest');
    $channel = $connection->channel();

    $channel->queue_declare('email_queue', false, true, false, false);

    $data = [
        'clientName' => $clientName,
        'clientEmail' => $clientEmail,
        'company' => $company,
        'bookedDate' => $bookedDate
    ];

    $message = new AMQPMessage(json_encode($data), ['delivery_mode' => AMQPMessage::DELIVERY_MODE_PERSISTENT]);
    $channel->basic_publish($message, '', 'email_queue');

    $channel->close();
    $connection->close();

    return true;
}

function handleInsertion($clientName, $clientEmail, $company, $bookedDate, $conn)
{
    $query1 = "INSERT INTO bookings (client_name, client_email, company, booking_date) VALUES ( ?,?, ?,?)";
    $stmt1 = mysqli_prepare($conn, $query1);
    mysqli_stmt_bind_param($stmt1, "ssss", $clientName, $clientEmail, $company, $bookedDate);

    if (mysqli_stmt_execute($stmt1)) {
        $sendToQueue = sendEmailToQueue($clientName, $clientEmail, $company, $bookedDate);
        if ($sendToQueue) {
            return [
                'success' => true,
                'message' => 'Booking successful. Emails will be sent shortly.'
            ];
        } else {
            return [
                'success' => false,
                'message' => 'An error occurred while processing your request.'
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