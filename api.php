<?php
header('Content-Type: application/json');
require_once 'backend/db.php';
require_once 'backend/auth.php';
require_once 'backend/actions.php';

$action = $_GET['action'] ?? 'listServices';

switch($action){
    case 'listServices':
        echo json_encode($DB['services']);
        break;

    case 'listBookings':
        $email = $_GET['email'] ?? $CURRENT_EMAIL;
        $userBookings = array_filter($DB['bookings'], fn($b)=>$b['email']==$email);
        echo json_encode(array_values($userBookings));
        break;

    default:
        echo json_encode(["status"=>"error","msg"=>"Action inconnue"]);
}
