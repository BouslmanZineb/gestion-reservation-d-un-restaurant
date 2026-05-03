<?php if (session_status() === PHP_SESSION_NONE) session_start(); ?>
<?php
require_once(__DIR__.'/../config/database.php');
require_once(__DIR__.'/../models/reservation.php');
require_once(__DIR__.'/../controllers/reservationController.php');

$pdo = connectDB();
$reservationModel = new Reservation($pdo);
$reservationController = new ReservationController($pdo);

$reservation = $_SESSION['derniere_reservation'] ?? null;
$nom = $_SESSION['nom'] ?? '';


if (isset($_POST['confirmer_modif'])) {
  $nom_client = $_POST['nom'];
    $id_reservation = isset($_POST['id_reservation']) ? (int) $_POST['id_reservation'] : null;

    $nouvelle_date = $_POST['nouvelle_date'];
    $nouvelle_heure = $_POST['nouvelle_heure'];
    $nb_personnes = $_POST['nb_personnes'];

    $reservationController->modifierReservation($id_reservation, $nouvelle_date, $nouvelle_heure, $nb_personnes, $nom_client);

    // Mise à jour de la session
    $_SESSION['derniere_reservation']['nom'] = $nom_client;

    $_SESSION['derniere_reservation']['date'] = $nouvelle_date;
    $_SESSION['derniere_reservation']['heure'] = $nouvelle_heure;
    $_SESSION['derniere_reservation']['nb_personnes'] = $nb_personnes;

    $_SESSION['flash_message'] = " Réservation modifiée avec succès.";
    header("Location: index.php?action=confirmation");
    exit();
}

$nom = $_SESSION['nom'] ?? '';

?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Confirmation de Réservation</title>
  <link rel="stylesheet" href="css/conf.css">
</head>
<body>

<?php if (isset($_SESSION['flash_message'])): ?>
    <div class="flash-message">
        <?= htmlspecialchars($_SESSION['flash_message']) ?>
    </div>
    <?php unset($_SESSION['flash_message']); ?>
<?php endif; ?>

<h2> Réservation confirmée</h2>


<?php if ($reservation): ?>
  <div class="info-box">
  <p><strong>Nom :</strong> <?= htmlspecialchars($reservation['nom'] ?? $nom) ?></p>
  <p><strong>Nombre de personnes :</strong> <?= htmlspecialchars($reservation['nb_personnes']) ?></p>
    <p><strong>Date :</strong> <?= htmlspecialchars($reservation['date']) ?></p>
    <p><strong>Heure :</strong> <?= htmlspecialchars($reservation['heure']) ?></p>

    <form method="post">
      <button type="submit" name="modifier" class="modifier-btn">✏️ Modifier cette réservation</button>
    </form>

    <form method="post" class="formulaire-modif">
  <input type="hidden" name="id_reservation" value="<?= htmlspecialchars($reservation['id']) ?>">

  <label for="nom">Nom :</label>
  <input type="text" name="nom" value="<?= htmlspecialchars($reservation['nom'] ?? $nom) ?>" required>

  <label for="nouvelle_date">Nouvelle date :</label>
  <input type="date" name="nouvelle_date" value="<?= htmlspecialchars($reservation['date']) ?>" required>

  <label for="nouvelle_heure">Nouvelle heure :</label>
  <input type="time" name="nouvelle_heure" value="<?= htmlspecialchars($reservation['heure']) ?>" required>

  <label for="nb_personnes">Nouveau nombre de personnes :</label>
  <input type="number" name="nb_personnes" min="1" value="<?= htmlspecialchars($reservation['nb_personnes']) ?>" required>

  <button type="submit" name="confirmer_modif"> Confirmer la modification</button>
</form>

  </div>
<?php else: ?>
  <p style="color:red;">Aucune réservation trouvée.</p>
<?php endif; ?>

<div class="button-container">
  <form action="index.php?action=espaceClient" method="get">
  <button onclick="window.location.href='index.php?action=espaceClient'">Voir Mes Reservation</button>
  </form>
  <form action="index.php?action=accueil" method="get">
    <button type="submit" class="btn-custom"> Retour à l'accueil</button>
  </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
  const boutonModifier = document.querySelector('button[name="modifier"]');
  const formulaireModif = document.querySelector('.formulaire-modif');

  boutonModifier.addEventListener('click', function (e) {
    e.preventDefault();
    formulaireModif.style.display = formulaireModif.style.display === 'none' ? 'block' : 'none';
  });
});
</script>

</body>
</html>
