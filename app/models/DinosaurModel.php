<?php
require_once __DIR__ . '/../../config/database.php';

class DinosaurModel {
    private $db;

    public function __construct() {
        global $db;
        $this->db = $db;
    }

    public function getAllDinosaurs() {
        try {
            $stmt = $this->db->prepare("SELECT dino_id, species, weight, sprite_frame1, sprite_frame2 FROM Dinosaurs ORDER BY species ASC");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            die("Error al obtener los dinosaurios: ". $e->getMessage());
        }
    }
}
?>