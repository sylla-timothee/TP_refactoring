<?php
require_once __DIR__ . '/backend/auth.php';
$email = getCurrentEmail();
$role = getRole($email);
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Services</title>
    <script src="frontend/assets/app.js" defer></script>
</head>
<body>

<h1>Cas d'étude – Gestion des services</h1>

<form method="post">
    <label>Email: <input name="mail" value="<?= htmlspecialchars($email) ?>"></label>
    <button>Se connecter</button>
</form>

<p>Rôle: <b><?= htmlspecialchars($role) ?></b></p>

<div>
    <h3>Services</h3>
    <div id="services"></div>
</div>

<div>
    <h3>Réservations</h3>
    <div id="bookings"></div>
</div>

</body>
</html>
