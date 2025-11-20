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

    // Lister tous les services
    case 'listServices':
        echo json_encode($DB['services']);
        break;

    // Lister les réservations pour l'utilisateur connecté
    case 'listBookings':
        $userBookings = array_filter($DB['bookings'], fn($b)=>$b['email']==$email);
        echo json_encode(array_values($userBookings));
        break;

    // Ajouter une réservation
    case 'bookService':
        $serviceId = (int)($_POST['serviceId'] ?? 0);
        $slot = $_POST['slot'] ?? null;
        if(!$serviceId || !$slot){
            echo json_encode(["success"=>false,"msg"=>"Service ou créneau manquant"]);
            break;
        }
        $res = bookService($email, $serviceId, $slot);
        echo json_encode($res);
        break;

    // Annuler une réservation
    case 'cancelBooking':
        $bookingId = (int)($_POST['bookingId'] ?? 0);
        if(!$bookingId){
            echo json_encode(["success"=>false,"msg"=>"ID réservation manquant"]);
            break;
        }
        $res = cancelBooking($bookingId, $email);
        echo json_encode($res);
        break;

    default:
        echo json_encode(["success"=>false,"msg"=>"Action inconnue"]);
        break;
}
