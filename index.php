<?php
session_start(); // Toujours démarrer la session en haut

require_once 'backend/db.php';
require_once 'backend/auth.php';
require_once 'backend/actions.php';

// Déterminer l'email courant
if(isset($_POST['mail'])){
    $CURRENT_EMAIL = $_POST['mail'];
    setcookie('email', $CURRENT_EMAIL, time()+3600, "/");
    $_COOKIE['email'] = $CURRENT_EMAIL; 
} else {
    $CURRENT_EMAIL = $_COOKIE['email'] ?? null;
}

// Déconnexion
if(isset($_POST['logout'])){
    setcookie('email', '', time()-3600, "/");
    $CURRENT_EMAIL = null;
    header("Location: index.php");
    exit;
}
?>

?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Services</title>
    <link rel="stylesheet" href="frontend/assets/styles.css">
    <script src="frontend/assets/app.js" defer></script>
</head>
<body>

<div class="main-container">

    <h1>Cas d'étude – Gestion des services</h1>

    <!-- Connexion par email -->
   <?php if(!$CURRENT_EMAIL): ?>
    <div class="row card">
        <form method="post">
            <label>Votre email : 
                <input name="mail" required>
            </label>
            <button class="btn">Se connecter</button>
        </form>
    </div>
<?php else: ?>
    <div style="margin-bottom:15px;">
        Connecté en tant que : <b><?= htmlspecialchars($CURRENT_EMAIL) ?></b>
        <form method="post" style="display:inline;">
            <input type="hidden" name="logout" value="1">
            <button class="btn" style="margin-left:10px;">Se déconnecter</button>
        </form>
    </div>
<?php endif; ?>




    <!-- Catalogue et réservations -->
    <div class="row">
        <div class="card" style="flex:1">
            <h3>Services</h3>
            <div id="services"></div>
        </div>

        <div class="card" style="flex:1">
            <h3>Mes réservations</h3>
            <div id="bookings"></div>
        </div>
    </div>

    <!-- Admin rudimentaire -->
    <?php if(getRole() === "admin"): ?>
    <div class="card">
        <h3>Administration</h3>
        <form method="post" class="row">
            <input type="hidden" name="act" value="addservice">
            <input name="name" placeholder="Nom du service" required>
            <input name="description" placeholder="Description (optionnelle)">
            <input name="duration" type="number" placeholder="Durée (minutes)">
            <button class="btn">Ajouter service</button>
        </form>

        <form method="post" class="row">
            <input type="hidden" name="act" value="addslot">
            <input name="sid" placeholder="Service ID" required>
            <input name="slot" placeholder="YYYY-MM-DD HH:MM" required>
            <button class="btn">Ajouter créneau</button>
        </form>

        <form method="post" class="row">
            <input type="hidden" name="act" value="cancel">
            <input name="bid" placeholder="Booking ID" required>
            <button class="btn danger">Annuler réservation</button>
        </form>
    </div>
    <?php endif; ?>

</div> <!-- /main-container -->

</body>
</html>
