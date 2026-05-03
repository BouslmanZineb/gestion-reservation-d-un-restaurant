<?php if (session_status() === PHP_SESSION_NONE) session_start(); ?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="css/espace.css">
    <title>Espace Client</title>
</head>
<body>
    <h1>Espace Client</h1>
    <div class="container">

        <?php if (!empty($client)): ?>
        <div class="info-user">
            <h2>Bienvenue, <?= htmlspecialchars($client['prenom']) ?> <?= htmlspecialchars($client['nom']) ?> !</h2>
            <p><strong>Nom :</strong> <?= htmlspecialchars($client['nom']) ?></p>
            <p><strong>Prénom :</strong> <?= htmlspecialchars($client['prenom']) ?></p>
            <p><strong>Email :</strong> <?= htmlspecialchars($client['mail']) ?></p>
            <p><strong>Date de naissance :</strong> <?= htmlspecialchars($client['daten']) ?></p>
        </div>
        <?php else: ?>
        <div class="info-user">
            <p style="color: red;"> Informations client non disponibles.</p>
        </div>
        <?php endif; ?>

        <div class="reservations">
            <h3>Mes Réservations</h3>
            <div class="reservation-list">
                <?php if (!empty($reservations)): ?>
                    <?php foreach ($reservations as $resa): ?>
                        <div class="reservation-card">
                            <div class="date"><strong>Date :</strong> <?= htmlspecialchars($resa['date']) ?></div>
                            <div class="time"><strong>Heure :</strong> <?= htmlspecialchars($resa['heure']) ?></div>
                            <div class="persons"><strong>Personnes :</strong> <?= htmlspecialchars($resa['nb_personnes']) ?></div>

                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>Vous n'avez encore aucune réservation.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div class="btn-deconnexion">
        <a href="index.php?action=deconnexion"> Déconnexion</a>
        <a href= "index.php?action=accueil"> Retour à l'acceuil</a>
    </div>
</body>
</html>
