<?php
class Client {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
       
    }
    public function getByEmail($email) {
        $sql = "SELECT * FROM client WHERE mail = :email";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(["email" => $email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    
    public function updateClient($data){
        $sql = "UPDATE client SET nom=:nom, prenom=:prenom, dateN=:dateN, mail=:mail, mdp=:mdp WHERE id=:id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            "nom" => $data["nom"],
            "prenom" => $data["prenom"],
            "dateN" => $data["dateN"],
            "mail" => $data["mail"],
            "mdp" => $data["mdp"],
            "id" => $data["id"]
        ]);
    }    
    public function deleteClient($id){
        $sql = "DELETE FROM client WHERE id=:id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(["id"=>$id]);
    } 

    public function createClient($user){
        $sql = "INSERT INTO client(nom, prenom, dateN, mail, mdp)
                VALUES(:nom, :prenom, :dateN, :mail, :mdp)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($user);
    }
    
    
    public function verifLogin($email, $password) {
        $sql = "SELECT * FROM client WHERE mail = :email AND mdp = :password";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(["email" => $email, "password" => $password]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public function getById($id) {
        $sql = "SELECT * FROM client WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    
}
?>