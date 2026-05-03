<?php
// 1) Démarrage de session
session_start();

require_once __DIR__ . "/config/database.php";
$pdo = connectDB();

// 3) Chargement des contrôleurs
require_once __DIR__ . "/controllers/reservationController.php";
require_once __DIR__ . "/controllers/clientController.php";
require_once __DIR__ . "/controllers/gerantController.php";

// 4) Instanciation
$reservationController = new ReservationController($pdo);
$clientController      = new ClientController($pdo);
$gerantController      = new GerantController($pdo);

// 5) Dispatch de l’action
$action = $_GET['action'] ?? null;

if (!$action) {
    // Pas d'action : page d'accueil
    $reservationController->accueil();
    exit;
}

switch ($action) {
    case 'accueil':
        $reservationController->accueil();
        break;
    case 'connexion':
        $clientController->connexion();
        break;

    case 'verifConnexion':
        $clientController->verifConnexion($_POST);
        break;

    case 'deconnexion':
        $clientController->deconnexion();
        break;

    case 'reserver':
        $reservationController->reserver($_POST);
        break;
    case 'connexion':
            $clientController->connexion();
            break;
        
    case 'verifConnexion':
            $clientController->verifConnexion($_POST);
            break;
        
    case 'creerCompte':
            $clientController->creerCompte();
            break;
        
    case 'enregistrerCompte':
            $clientController->enregistrerCompte($_POST);
            break;
        
    case 'confirmation':
        $reservationController->confirmation();
        break;

    case 'espaceClient':
        $clientController->espaceClient($_SESSION['nom'] ?? '');
        break;

    case 'connexionGerant':
        $gerantController->connexion();
        break;

    case 'traiterConnexionGerant':
        $gerantController->traiterConnexion($_POST);
        break;

    case 'gestionResa':
        $gerantController->gestionResa();
        break;

    case 'deconnexionGerant':
        $gerantController->deconnexion();
        break;

    case 'annulerResaGerant':
        $gerantController->annulerReservation($_GET['id']);
        break;

    default:
        echo "Action inconnue : " . htmlspecialchars($action);
        break;
}
