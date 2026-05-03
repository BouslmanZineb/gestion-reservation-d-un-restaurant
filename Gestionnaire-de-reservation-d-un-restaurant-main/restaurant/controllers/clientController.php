<?php
require_once __DIR__."/../models/Client.php";
require_once __DIR__."/../models/Reservation.php";

class ClientController {
    private $clientModel;
    private $reservationModel;

    public function __construct($pdo) {
        $this->clientModel = new Client($pdo);
        $this->reservationModel = new Reservation($pdo);
    }

    public function creerCompte() {
        require __DIR__."/../views/Inscription.php";
    }
    public function enregistrerCompte($post) {

         // on s'assure que la session est active
        $dateNaissance = $post["age"];
        $dateN = DateTime::createFromFormat('Y-m-d', $dateNaissance);
        $aujourdhui = new DateTime();
        $age = $aujourdhui->diff($dateN)->y;
    
        if ($age < 18) {
            $_SESSION['erreur_inscription'] = "L'inscription est réservée aux personnes majeures (18+).";
            header("Location: index.php?action=creerCompte");
            exit;
        }
        session_start();
    
        $data = [
            "nom" => $post["nom"],
            "prenom" => $post["prenom"],
            "dateN" => $dateNaissance,
            "mail" => $post["email"],
            "mdp" => password_hash($post["mot_de_passe"], PASSWORD_DEFAULT)
        ];
    
        // Vérifie si l'e-mail existe déjà
        if ($this->clientModel->getByEmail($data["mail"])) {
            $_SESSION['erreur_inscription'] = "Un compte avec cet e-mail existe déjà.";
            header("Location: index.php?action=creerCompte");
            exit;
        }
    
        // Création du compte
        $this->clientModel->createClient($data);
        $client = $this->clientModel->getByEmail($data["mail"]);
    
        // Création de la session
        $_SESSION["client_id"] = $client["id"];
        $_SESSION["nom"] = $client["nom"];
        $_SESSION["prenom"] = $client["prenom"];
    
        //  Redirection vers l’accueil
        // Si une réservation était en cours, elle est conservée
        header("Location: index.php?action=accueil");
        exit;
    }
    
    public function espaceClient() {
        session_start();
    
        // Vérifie que l'utilisateur est connecté
        if (!isset($_SESSION['client_id'])) {
            header("Location: index.php?action=connexion");
            exit;
        }
    
        // Récupérer les informations du client
        $client = $this->clientModel->getById($_SESSION['client_id']);
    
        // Si aucun client trouvé 
        if (!$client) {
            echo "Client introuvable.";
            exit;
        }
    
        // Récupérer toutes ses réservations
        $reservations = $this->reservationModel->getAllByClient($_SESSION['client_id']);
    
        // Afficher la vue espace utilisateur
        require __DIR__ . '/../views/EspaceUtilisateur.php';
    }
    
    public function connexion() {
        require_once __DIR__."/../views/connexion.php";
    }

    public function verifConnexion($post) {
        $client = $this->clientModel->getByEmail($post['mail']);

        if ($client && password_verify($post['mdp'], $client['mdp'])) {
            $_SESSION['client_id'] = $client['id'];
            $_SESSION['nom'] = $client['nom'];
            $_SESSION['prenom'] = $client['prenom'];
            header("Location: index.php?action=accueil");
            exit;
        }
         else {
            $_SESSION['erreur_connexion'] = "Email ou mot de passe incorrect.";
            header("Location: index.php?action=connexion");
            exit;
        }
    }
    
    public function deconnexion() {
        $_SESSION = [];
        session_destroy();
        header("Location: index.php?action=accueil");
        exit;
    }
    
    public function accueil() {

        
        require __DIR__."/../views/accueil.php";
    }

    public function reserver($post) {
        
        if (!isset($_SESSION['client_id'])) {
            header("Location: index.php?action=connexion");
            exit;
        }

        $post['client_id'] = $_SESSION['client_id'];
        $this->reservationModel->createReservation($post);
        header("Location: index.php?action=confirmation");
    }

    public function confirmation() {
        require __DIR__."/../views/Confirmation.php";
    }

   
    
    

    public function annulerReservation($id) {
        $this->reservationModel->deleteReservation($id);
        header("Location: index.php?action=espaceClient");
    }
}
?>