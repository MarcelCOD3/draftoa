<?php
require_once __DIR__ . '/../models/PlayerModel.php';

class RankingController {
    private $model;

    public function __construct() {
        $this->model = new PlayerModel();
    }

    // Trae los jugadores
    public function getPlayers() {
        return $this->model->getRanking();
    }
}
?>