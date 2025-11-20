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
    <link rel="stylesheet" href="frontend/assets/styles.css">

</head>
<<body>
<div class="main-container">

<h1>Cas d'étude – Gestion des services</h1>

<form method="post">
    <label>Email: <input name="mail" value="<?= htmlspecialchars($email) ?>"></label>
    <button class="btn">Se connecter</button>
</form>

<p>Rôle: <b><?= htmlspecialchars($role) ?></b></p>

<div class="row">
    <div class="card">
        <h3>Services</h3>
        <div id="services"></div>
    </div>

    <div class="card">
        <h3>Réservations</h3>
        <div id="bookings"></div>
    </div>
</div>

</div> <!-- fin main-container -->
</body>
</