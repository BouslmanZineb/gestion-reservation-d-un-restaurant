<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/accueil.css">
    <link href="https://fonts.googleapis.com/css2?family=Amiri&display=swap" rel="stylesheet">
    <title>Délice de Marrakech</title>
</head>
<body>

<div class="boutons-utilisateur">
    <?php if (isset($_SESSION['client_id'])): ?>
        <button onclick="window.location.href='index.php?action=espaceClient'">Espace Client</button>
        <button onclick="window.location.href='index.php?action=deconnexion'">Se Déconnecter</button>
    <?php else: ?>
        <button onclick="window.location.href='index.php?action=connexionGerant'">Se connecter Gérant</button>
        <button onclick="window.location.href='index.php?action=connexion'">Se connecter client</button>
    <?php endif; ?>
</div>

<div class="conteneur">
    <h1>Délice de Marrakech</h1>
    <h1 dir="rtl" style="font-family: 'Amiri', serif;">شهيوات مراكش</h1>

    <?php if (isset($_SESSION['client_id'], $_SESSION['prenom'], $_SESSION['nom'])): ?>
    <div class="bienvenue">
        <h2>Bienvenue <?= htmlspecialchars($_SESSION['prenom']) ?> <?= htmlspecialchars($_SESSION['nom']) ?></h2>
    </div>
<?php endif; ?>


    <form method="post" action="index.php?action=reserver">
        <fieldset>
            <legend id="formulreser">Formulaire de réservation</legend>

            <label for="nom-du-client">Nom du client :</label><br>
            <input type="text" id="nom-du-client" name="nom" 
                   value="<?= htmlspecialchars($_SESSION['client_nom'] ?? ($reservationAttente['nom'] ?? ($_POST['nom'] ?? ''))) ?>" 
                   placeholder="Entrez votre nom" required><br><br>

            <label for="nbpersonne">Nombre de personnes :</label><br>
            <input type="number" id="nbpersonne" name="nb_personnes" 
                   value="<?= htmlspecialchars($reservationAttente['nb_personnes'] ?? ($_POST['nb_personnes'] ?? '')) ?>" 
                   min="1" max="10" required><br><br>

            <label for="datereserv">Date de réservation :</label><br>
            <input type="date" name="date" id="datereserv" 
                   value="<?= htmlspecialchars($reservationAttente['date'] ?? ($_POST['date'] ?? date('Y-m-d'))) ?>" 
                   min="<?= date('Y-m-d') ?>" required><br><br>

            <?php if (!empty($erreurDate)) : ?>
                <p style="color: red; font-weight: bold;"><?= $erreurDate ?></p>
            <?php endif; ?>

            <label for="heure-reservation">Sélectionnez votre créneau horaire :</label><br>
            <?php $heureChoisie = $reservationAttente['heure'] ?? ($_POST['heure'] ?? ''); ?>
            <select name="heure" required>
                <?php foreach ($creneauxStatut as $heure => $nb): ?>
                    <option value="<?= $heure ?>" 
                            <?= $nb >= 30 ? 'disabled' : '' ?> 
                            <?= $heure === $heureChoisie ? 'selected' : '' ?>>
                        <?= $heure ?> <?= $nb >= 30 ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <button type="submit" id="submit">Réservez votre créneau</button>
        </fieldset>
    </form>

        <br>
        
          
            <footer class="footer">
                <div class="footer-section horaires">
                    <h3>Horaires</h3>
                    <ul>
                        <li>Lundi : 19h00 - 23h00</li>
                        <li>Mardi : 19h00 - 23h00</li>
                        <li>Mercredi : 19h00 - 23h00</li>
                        <li>Jeudi : 19h00 - 23h00</li>
                        <li>Vendredi : 19h00 - 23h00</li>
                        <li>Samedi : 19h00 - 23h00</li>
                        <li>Dimanche : Fermé</li>
                    </ul>
                </div>
            
                <div class="footer-section avis">
                    <h3>Laissez un avis</h3>
                    <form action="avis.php" method="post" class="form-avis">
                        <textarea name="avis" rows="3" placeholder="Écrivez votre avis ici..." required></textarea><br>
                        <button type="submit">Envoyer</button>
                    </form>
                </div>
            
                <div class="footer-section contact">
                    <h3>Contact</h3>
                    <p>Téléphone : +212 606089347</p>
                    <p>Email : contact@delicedemarrakech.com</p>
                </div>
            </footer>
            <script>
    document.getElementById("datereserv").addEventListener("change", function() {
        this.form.submit();  // recharge les créneaux en fonction de la date
    });
</script>
</div>

<?php unset($_SESSION['reservation_en_attente']); ?>
</body>
</html>
