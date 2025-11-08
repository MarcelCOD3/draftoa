<?php
require_once __DIR__ . '/../../config/database.php';

class RecoveryPassModel {
    private $db;

    public function __construct() {
        global $db;
        $this->db = $db;
    }

    // Crear token con expiración pasada desde PHP
  public function createToken($user_id, $token) {
    $stmt = $this->db->prepare("
        INSERT INTO RecoveryPass (user_id, token, expires_at, used) 
        VALUES (?, ?, DATE_ADD(NOW(), INTERVAL 1 HOUR), 0)
    ");
    return $stmt->execute([$user_id, $token]);
}


    // Obtener usuario por token válido (no usado y no expirado)
    public function getUserByToken($token) {
        $stmt = $this->db->prepare("
            SELECT rp.user_id, u.email, rp.token, rp.expires_at, rp.used
            FROM RecoveryPass rp
            JOIN Users u ON rp.user_id = u.user_id
            WHERE rp.token = ?
        ");
        $stmt->execute([$token]);
        return $stmt->fetch();
    }

    // Marcar token específico como usado
   public function markTokenUsed($token) {
    $stmt = $this->db->prepare("UPDATE RecoveryPass SET used = 1 WHERE token = ?");
    return $stmt->execute([$token]);
}


    // Eliminar tokens antiguos de un usuario (opcional)
    public function deleteTokens($user_id) {
        $stmt = $this->db->prepare("DELETE FROM RecoveryPass WHERE user_id = ?");
        return $stmt->execute([$user_id]);
    }
}