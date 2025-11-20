<?php
require_once 'db.php';
require_once 'auth.php';

function addService($name, $description = "", $duration = 30){
    global $DB;
    if(!$name) return false;
    $id = count($DB['services']) + 1;
    $DB['services'][] = [
        "id" => $id,
        "name" => $name,
        "description" => $description,
        "duration" => $duration,
        "slots" => []
    ];
    saveDB($DB);
    return true;
}

function addSlot($serviceId, $datetime){
    global $DB;
    foreach($DB['services'] as &$s){
        if($s['id'] == $serviceId){
            $s['slots'][] = $datetime;
            saveDB($DB);
            return true;
        }
    }
    return false;
}

function bookService($email, $serviceId, $slot){
    global $DB;
    // Vérifier double booking
    foreach($DB['bookings'] as $b){
        if($b['email'] == $email && $b['service'] == $serviceId && $b['slot'] == $slot){
            return ["success"=>false, "msg"=>"Vous avez déjà réservé ce créneau !"];
        }
    }
    $DB['bookings'][] = [
        "id" => count($DB['bookings']) + 1,
        "email" => $email,
        "service" => $serviceId,
        "slot" => $slot,
        "createdAt" => date("c")
    ];
    saveDB($DB);
    return ["success"=>true];
}

function cancelBooking($bookingId, $email){
    global $DB;
    foreach($DB['bookings'] as $k => $b){
        if($b['id'] == $bookingId && $b['email'] == $email){
            if(strtotime($b['slot']) < time()){
                return ["success"=>false, "msg"=>"Impossible d'annuler un créneau passé !"];
            }
            unset($DB['bookings'][$k]);
            $DB['bookings'] = array_values($DB['bookings']); // réindexer
            saveDB($DB);
            return ["success"=>true];
        }
    }
    return ["success"=>false, "msg"=>"Réservation introuvable"];
}
