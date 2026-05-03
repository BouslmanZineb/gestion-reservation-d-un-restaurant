<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/inscription.css">
    <title>Création de compte</title>
</head>
<body>
    <div class="contr">
        <h1>Création de MonCompte</h1>
        <p id="indice">Merci de bien remplir le formulaire pour créer votre compte :</p>

        <?php
        if (isset($_SESSION['erreur_inscription'])) {
            echo '<p style="color:red; font-weight: bold;">' . $_SESSION['erreur_inscription'] . '</p>';
            unset($_SESSION['erreur_inscription']);
        }
        ?>

        <form method="post" action="index.php?action=enregistrerCompte">
            <fieldset>
                <legend id="legend">Inscrivez-vous</legend>

                <label for="nom">Nom :</label>
                <input type="text" name="nom" id="nom" required><br><br>

                <label for="prenom">Prénom :</label>
                <input type="text" name="prenom" id="prenom" required><br><br>

                <label for="age">Date de Naissance :</label>
                <input type="date" name="age" id="age"  required><br><br>


                <label for="email">Email :</label>
                <input type="email" name="email" id="email" required><br><br>

                <label for="tele">Téléphone :</label>
                <input type="text" name="tele" id="tele" required><br><br>

                <label for="mot_de_passe">Mot de passe :</label>
                <input type="password" name="mot_de_passe" id="mot_de_passe" required><br><br>

                <input type="submit" value="Envoyer" class="envoyer">
            </fieldset>
        </form>
    </div>

    <script src="ex2.js"></script>
</body>
</html>
