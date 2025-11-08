<?php
require_once __DIR__ . '/../../config/database.php';

class PlayerModel {
    private $db;

    public function __construct() {
        global $db;
        $this->db = $db;
    }

    public function getRanking() {
    $sql = "
    SELECT 
        u.user_id,
        u.nickname, -- <--- agregamos el nickname
        COUNT(gp.game_id) AS partidas,
        SUM(gp.score) AS puntaje,
        SUM(gp.score = gp_max.max_score) AS victorias
    FROM Users u
    LEFT JOIN GamePlayers gp ON u.user_id = gp.user_id
    LEFT JOIN (
        SELECT game_id, MAX(score) AS max_score
        FROM GamePlayers
        GROUP BY game_id
    ) gp_max ON gp.game_id = gp_max.game_id
    GROUP BY u.user_id
    ORDER BY puntaje DESC;
    ";

    try {
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        $ranking = [];
        $pos = 1;
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $row['pos'] = $pos++;
            $ranking[] = $row;
        }
        return $ranking;
    } catch (PDOException $e) {
        die("Error al obtener ranking: " . $e->getMessage());
    }
}


public function getUserStats($user_id) {
    $sql = "
        SELECT 
            COUNT(gp.game_id) AS partidas,
            SUM(gp.score = gp_max.max_score) AS victorias,
            SUM(gp.score) AS puntaje_total
        FROM GamePlayers gp
        LEFT JOIN (
            SELECT game_id, MAX(score) AS max_score
            FROM GamePlayers
            GROUP BY game_id
        ) gp_max ON gp.game_id = gp_max.game_id
        WHERE gp.user_id = :user_id
    ";

    $stmt = $this->db->prepare($sql);
    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $stmt->execute();
    $stats = $stmt->fetch(PDO::FETCH_ASSOC);

    return [
        'partidas' => (int)($stats['partidas'] ?? 0),
        'victorias' => (int)($stats['victorias'] ?? 0),
        'puntaje_total' => (int)($stats['puntaje_total'] ?? 0)
    ];
}




}
?>