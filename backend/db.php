<?php
$DB = json_decode(file_get_contents(__DIR__ . '/../data.json'), true);
if(!$DB){
    $DB = ["services"=>[], "users"=>[], "bookings"=>[]];
}

function saveDB($DB){
    file_put_contents(__DIR__ . '/../data.json', json_encode($DB, JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE));
}
