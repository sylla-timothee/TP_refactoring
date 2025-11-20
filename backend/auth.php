<?php
session_start();

$CURRENT_EMAIL = $_SESSION['email'] ?? ($_POST['mail'] ?? null);
if(isset($_POST['mail'])){
    $_SESSION['email'] = $_POST['mail'];
}

function getRole(){
    global $DB, $CURRENT_EMAIL;
    foreach($DB['users'] as $u){
        if($u['email'] == $CURRENT_EMAIL) return $u['role'];
    }
    return "anon";
}
