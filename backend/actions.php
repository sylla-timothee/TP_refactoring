<?php
require_once 'db.php';

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

    // Empêcher double réservation
    foreach($DB['bookings'] as $b){
        if($b['service'] == $serviceId && $b['slot'] == $slot){
            return ["success"=>false, "msg"=>"Ce créneau est déjà réservé !"];
        }
    }

    // Ajouter la réservation
    $DB['bookings'][] = [
        "id" => count($DB['bookings']) + 1,
        "email" => $email,
        "service" => $serviceId,
        "slot" => $slot,
        "createdAt" => date("c")
    ];

    // Retirer le créneau de la liste des slots du service
    foreach($DB['services'] as &$s){
        if($s['id'] == $serviceId){
            $s['slots'] = array_values(array_filter($s['slots'], fn($slt) => $slt !== $slot));
            break;
        }
    }

    saveDB($DB);
    return ["success"=>true, "msg"=>"Réservation confirmée !"];
}


function cancelBooking($bookingId, $email){
    global $DB;

    foreach($DB['bookings'] as $k => $b){
        if($b['id'] == $bookingId && $b['email'] == $email){

            if(strtotime($b['slot']) < time()){
                return ["success"=>false, "msg"=>"Impossible d'annuler un créneau passé !"];
            }

            // Réajouter le créneau au service
            foreach($DB['services'] as &$s){
                if($s['id'] == $b['service']){
                    // Si le créneau n'est pas déjà dedans (sécurité)
                    if(!in_array($b['slot'], $s['slots'])){
                        $s['slots'][] = $b['slot'];
                        sort($s['slots']); // tri optionnel
                    }
                    break;
                }
            }

            // Supprimer la réservation
            unset($DB['bookings'][$k]);
            $DB['bookings'] = array_values($DB['bookings']);

            saveDB($DB);
            return ["success"=>true, "msg"=>"Réservation annulée !"];
        }
    }

    return ["success"=>false, "msg"=>"Réservation introuvable"];
}

