<?php
class Reservation {
    private $pdo;
    public function __construct($pdo) {
        $this->pdo = $pdo;
    }
    public function createReservation($data) {
        $stmt = $this->pdo->prepare("INSERT INTO reservation (client_id, nom, nb_personnes, date, heure) 
                                     VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([
            $data['client_id'],
            $data['nom'],
            $data['nb_personnes'],
            $data['date'],
            $data['heure']
        ]);
        return $this->pdo->lastInsertId();
    }
    
    public function updateReservation($data) {
        $sql = "UPDATE reservation 
                SET nom = :nom, nb_personnes = :nb_personnes, date = :date, heure = :heure 
                WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            "nom" => $data["nom"],
            "nb_personnes" => $data["nb_personnes"],
            "date" => $data["date"],
            "heure" => $data["heure"],
            "id" => $data["id"]
        ]);
    }
    public function deleteReservation($id) {
        $sql = "DELETE FROM reservation WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['id' => $id]);
    }
    public function getAllByClient($client_id) {
        $stmt = $this->pdo->prepare("SELECT * FROM reservation WHERE client_id = ?");
        $stmt->execute([$client_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    

    public function getCreneauxEtStatut(string $date): array {
        $creneauxFixes = ["19:00","20:00","20:30","21:00"];
        $sql = "SELECT heure, SUM(nb_personnes) AS total_personnes
                FROM reservation
                WHERE date = :date
                GROUP BY heure";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(["date" => $date]);
        $resultats = $stmt->fetchAll(PDO::FETCH_KEY_PAIR);
        $statut = [];
        foreach ($creneauxFixes as $h) {
            $statut[$h] = $resultats[$h] ?? 0;
        }
        return $statut;
    }

    public function getAllReservation() {
        $sql = "SELECT * FROM reservation";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
        public function getTotalPersonnes(string $date, string $heure, ?int $excludeId = null): int {
        if ($excludeId) {
            $sql = "SELECT SUM(nb_personnes) FROM reservation 
                    WHERE date = ? AND heure = ? AND id != ?";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$date, $heure, $excludeId]);
        } else {
            $sql = "SELECT SUM(nb_personnes) FROM reservation 
                    WHERE date = ? AND heure = ?";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$date, $heure]);
        }
        return (int)$stmt->fetchColumn();
    }
}
