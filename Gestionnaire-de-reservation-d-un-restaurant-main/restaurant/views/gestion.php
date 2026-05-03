<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width" , initial-scale="1.0">
    <link rel="stylesheet" href="css/gestion.css">
    <title>gestion restaurant</title>
</head>

<script>
    const reservations = <?php echo json_encode($reservations); ?>;
</script>
<script src="js/gestion.js"></script>

<body onload="creerCalendrier()">

    <div class="boutons-utilisateur">
        <button onclick="window.location.href='index.php?action=deconnexion'">Se Déconnecter</button>
    </div>

    <div class="conteneurGlobal">
        <div class="conteneur">
            <h1>Délice de Marrakech</h1>
            <h1 dir="rtl" style="font-family: 'Amiri', serif;">شهيوات مراكش</h1>

            <h2>Gestion des réservations</h2>

            <h1 id="mois"></h1>
            <div class="navMois">
                <button onclick="moisPrecedent()">&lt;</button>
                <span id="mois"></span>
                <button onclick="moisSuivant()">&gt;</button>
            </div>
            <div id="calendrier"></div>
        </div>

        <div id="infosCreneau" class="infosCreneau" style="display: none;">
            <h3>Informations du créneau</h3>
            <div id="infos"></div>
            <button onclick="fermer()">Fermer</button>
        </div>
    </div>

</body>

</html>