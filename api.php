<?php
header('Content-Type: application/json');

require_once __DIR__ . '/backend/db.php';
require_once __DIR__ . '/backend/actions.php';
require_once __DIR__ . '/backend/auth.php';

$action = $_GET['action'] ?? null;

switch ($action) {

    case "listServices":
        echo json_encode(loadDB()['services']);
        break;

    case "listBookings":
        $email = $_GET['email'] ?? null;
        $db = loadDB();
        $out = array_filter($db['bookings'], fn($b) => $b['email'] === $email);
        echo json_encode(array_values($out));
        break;

    case "addService":
        echo json_encode(addService($_POST['name'], $_POST['type']));
        break;

    case "addSlot":
        echo json_encode(addSlot($_POST['sid'], $_POST['slot']));
        break;

    case "book":
        echo json_encode(bookService($_POST['email'], $_POST['sid'], $_POST['slot']));
        break;

    case "cancel":
        echo json_encode(cancelBooking($_POST['bid']));
        break;

    default:
        echo json_encode(["error" => "unknown action"]);
}
