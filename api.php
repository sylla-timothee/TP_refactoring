<?php
header('Content-Type: application/json');

require_once 'backend/db.php';
require_once 'backend/auth.php';
require_once 'backend/actions.php';

$action = $_GET['action'] ?? null;
$email = $CURRENT_EMAIL ?? $_GET['email'] ?? null;

if(!$email){
    echo json_encode(["success"=>false, "msg"=>"Email non défini"]);
    exit;
}

switch($action){
    case 'listServices':
        echo json_encode($DB['services']);
        break;

    case 'listBookings':
        $userBookings = array_filter($DB['bookings'], fn($b)=>$b['email']==$email);
        echo json_encode(array_values($userBookings));
        break;

    case 'bookService':
        $serviceId = (int)($_POST['serviceId'] ?? 0);
        $slot = $_POST['slot'] ?? null;
        if(!$serviceId || !$slot){
            echo json_encode(["success"=>false,"msg"=>"Service ou créneau manquant"]);
            break;
        }
        echo json_encode(bookService($email, $serviceId, $slot));
        break;

    case 'cancelBooking':
        $bookingId = (int)($_POST['bookingId'] ?? 0);
        if(!$bookingId){
            echo json_encode(["success"=>false,"msg"=>"ID réservation manquant"]);
            break;
        }
        echo json_encode(cancelBooking($bookingId, $email));
        break;

    default:
        echo json_encode(["success"=>false,"msg"=>"Action inconnue"]);
        break;
}
