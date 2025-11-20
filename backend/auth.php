<?php
require_once __DIR__ . '/db.php';

function getCurrentEmail() {
    if (isset($_POST['mail'])) {
        setcookie('email', $_POST['mail']);
        return $_POST['mail'];
    }
    return $_COOKIE['email'] ?? null;
}

function getRole($email) {
    $db = loadDB();
    foreach ($db['users'] as $u) {
        if ($u['email'] === $email) return $u['role'];
    }
    return "anon";
}
