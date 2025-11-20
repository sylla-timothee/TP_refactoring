<?php
require_once __DIR__ . '/db.php';

function addService($name, $type) {
    $db = loadDB();
    $id = count($db['services']) + 1;

    $db['services'][] = [
        "id" => $id,
        "name" => $name,
        "type" => $type,
        "slots" => []
    ];

    saveDB($db);
    return ["status" => "ok", "id" => $id];
}

function addSlot($sid, $slot) {
    $db = loadDB();

    foreach ($db['services'] as &$sv) {
        if ($sv['id'] == $sid) {
            $sv['slots'][] = $slot;
        }
    }

    saveDB($db);
    return ["status" => "ok"];
}

function bookService($email, $sid, $slot) {
    $db = loadDB();

    $db['bookings'][] = [
        "id" => count($db['bookings']) + 1,
        "email" => $email,
        "service" => $sid,
        "slot" => $slot
    ];

    saveDB($db);
    return ["status" => "ok"];
}

function cancelBooking($bid) {
    $db = loadDB();

    foreach ($db['bookings'] as $k => $b) {
        if ($b['id'] == $bid) {
            unset($db['bookings'][$k]);
        }
    }

    saveDB($db);
    return ["status" => "ok"];
}
