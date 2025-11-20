<?php

function loadDB() {
    $path = __DIR__ . '/../data.json';
    $data = json_decode(file_get_contents($path), true);
    
    if (!$data) {
        $data = ["services" => [], "users" => [], "bookings" => []];
    }
    return $data;
}

function saveDB($db) {
    $path = __DIR__ . '/../data.json';
    file_put_contents($path, json_encode($db, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
}
