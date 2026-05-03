<?php
class GerantController {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }
    
    public function connexion() {
        require __DIR__ . "/../views/connexiongerant.php";
    }

    public function traiterConnexion($post) {
        $login = $post['login'] ?? '';
        $password = $post['password'] ?? '';

        $login_attendu = "admin";
        $mdp_attendu = "admin";

        if ($login === $login_attendu && $password === $mdp_attendu) {
            session_start();
            $_SESSION['gerant'] = true;
            header("Location: index.php?action=gestionResa");
            exit;
        } else {
            $erreur = "Identifiants incorrects";
            require __DIR__ . "/../views/connexiongerant.php";
        }
    }

    public function gestionResa() {
        require_once __DIR__ . '/../models/Reservation.php';
        $reservationModel = new Reservation($this->pdo);
        $reservations = $reservationModel->getAllReservation();
        
        require __DIR__ . '/../views/gestion.php';
    }
    
    public function annulerReservation($id) {
        require_once __DIR__ . '/../models/reservation.php';
        $reservationModel = new Reservation($this->pdo);
        $reservationModel->deleteReservation($id);
        header("Location: index.php?action=gestionResa");
        exit;
    }

    public function deconnexion() {
        session_start();
        unset($_SESSION['gerant']);
        session_destroy();
        header("Location: index.php?action=connexionGerant");
        exit;
    }
}
