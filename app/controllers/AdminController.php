<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/draftosaurus/app/models/UserModel.php';

class AdminController {
    private $userModel;

    public function __construct() {
        $this->userModel = new UserModel();
    }

    public function getAllUsers() {
        return $this->userModel->getAllUsers();

        
    }

    public function deleteUser($nickname) {
    return $this->userModel->deleteUserByNickname($nickname);
}

/**
 * Banea o desbanea un usuario.
 *
 * @param string $nickname Nickname del usuario.
 * @param string|null $bannedUntil Fecha hasta la cual estará baneado en formato 'YYYY-MM-DD HH:MM:SS'.
 *                                  Si es null, se desbanea al usuario.
 * @return bool
 */
public function banUser($nickname, $bannedUntil) {
    return $this->userModel->banUser($nickname, $bannedUntil);
}

public function editUser($nickname, $firstName, $lastName, $email, $isAdmin, $password = null) {
    return $this->userModel->editUser($nickname, $firstName, $lastName, $email, $isAdmin, $password);
}



}


?>