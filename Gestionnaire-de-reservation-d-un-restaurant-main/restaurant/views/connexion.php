<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/connexion.css">
    <title>Page de Connexion Client</title>
</head>
<body>


    <div class="contr">
        <h1>Page de Connexion Client</h1>
        <form id="form" method="POST" action="index.php?action=verifConnexion">
    <input type="text" name="mail" id="mail" placeholder="Identifiant" required>
    <input type="password" name="mdp" id="mdp" placeholder="Mot de passe" required>
    <button type="submit">Se connecter</button>
            <button onclick="window.location.href='index.php?action=creerCompte'">Cree Mon Compte</button>
            <button onclick="window.location.href='index.php?action=accueil'">Retour</button>

        </form>

    </div>
</body>
</html>
