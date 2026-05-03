<?php
require_once __DIR__ . "/../models/reservation.php";

class ReservationController {
    private $reservationModel;
    public function __construct($pdo) {
        $this->reservationModel = new Reservation($pdo);
    }

    public function accueil() {
        $date = $_POST['date'] ?? date('Y-m-d');
        $creneauxStatut = $this->reservationModel->getCreneauxEtStatut($date);
        require __DIR__ . '/../views/accueil.php';
    }

    public function reserver($post) {
        if (!isset($_SESSION['client_id'])) {
            $_SESSION['reservation_en_attente'] = $post;
            header("Location: index.php?action=connexion");
            exit;
        }
    
        $dateDuJour = date('Y-m-d');
        if ($post['date'] < $dateDuJour) {
            // Réafficher le formulaire avec un message d'erreur
            $creneauxStatut = $this->reservationModel->getCreneauxEtStatut($dateDuJour);
            $erreurDate = "La date choisie est déjà passée.";
            require __DIR__ . '/../views/accueil.php';
            return;
        }
    
        $nbPersonnesExistantes = $this->reservationModel->getTotalPersonnes($post['date'], $post['heure']);
    
        if (($nbPersonnesExistantes + $post['nb_personnes']) > 30) {
            $creneauxStatut = $this->reservationModel->getCreneauxEtStatut($post['date']);
            $erreurDate = "Ce créneau est complet.";
            require __DIR__ . '/../views/accueil.php';
            return;
        }
        $id_reservation = $this->reservationModel->createReservation([
            'client_id' => $_SESSION['client_id'],
            'nom' => $_SESSION['nom'],
            'nb_personnes' => $post['nb_personnes'],
            'date' => $post['date'],
            'heure' => $post['heure']
        ]);
        
        
        $_SESSION['derniere_reservation'] = [
            'id' => $id_reservation,
            'date' => $post['date'],
            'heure' => $post['heure'],
            'nb_personnes' => $post['nb_personnes']
        ];
        

        header("Location: index.php?action=confirmation");
        exit;
    }

    public function confirmation() {
        require __DIR__ . "/../views/confirmation.php";
    }
    public function modifierReservation($id, $date, $heure, $nb_personnes, $nom) {
        $this->reservationModel->updateReservation([
            "id" => $id,
            "nom" => $nom,
            "nb_personnes" => $nb_personnes,
            "date" => $date,
            "heure" => $heure
        ]);
    }
    
    
}
