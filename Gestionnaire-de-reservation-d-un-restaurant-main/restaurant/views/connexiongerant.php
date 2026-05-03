<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/connexion.css">

    <title>Page de Connexion Gerant </title>

</head>
<body>
    <div class="contr">
        <h1>Page de Connexion Gérant</h1>
        <?php if (isset($erreur)) echo "<p style='color:red;'>$erreur</p>"; ?>
        <form method="POST" action="index.php?action=traiterConnexionGerant">
            <input type="text" id="login" name="login" placeholder="Identifiant" required>
            <input type="password" id="mdp" name="password" placeholder="Mot de passe" required>
            <button type="submit">Se connecter</button>
            <button onclick="window.location.href='index.php?action=accueil'">Retour</button>
        </form>
    </div>
</body>
</html>