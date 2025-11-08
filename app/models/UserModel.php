<?php
require_once __DIR__ . '/../../config/database.php';

class UserModel {
    private $db;

    public function __construct() {
        global $db;
        $this->db = $db;
    }

   public function getAllUsers() {
    $stmt = $this->db->query("
        SELECT 
            nickname, 
            first_name, 
            last_name, 
            email, 
            is_admin, 
            active, 
            banned_until
        FROM Users
        ORDER BY nickname
    ");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


    public function deleteUserByNickname($nickname) {
    $stmt = $this->db->prepare("DELETE FROM Users WHERE nickname = :nickname");
    return $stmt->execute([':nickname' => $nickname]);
}

/**
 * Banea o desbanea un usuario.
 * 
 * @param string $nickname Nickname del usuario.
 * @param string|null $bannedUntil Fecha hasta la cual estará baneado en formato 'YYYY-MM-DD HH:MM:SS'.
 *                                    Si es null, se desbanea al usuario.
 * @return bool Devuelve true si la operación se realizó correctamente.
 */
public function getUserByEmail(string $email) {
    $stmt = $this->db->prepare("SELECT * FROM Users WHERE email = :email LIMIT 1");
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC); // Devuelve el usuario o false si no existe
}

public function updatePassword($user_id, $hashedPassword) {
    $stmt = $this->db->prepare("UPDATE Users SET password_hash = :password_hash WHERE user_id = :user_id");
    return $stmt->execute([
        ':password_hash' => $hashedPassword,
        ':user_id' => $user_id
    ]);
}


public function banUser($nickname, $bannedUntil) {
    $stmt = $this->db->prepare("UPDATE Users SET banned_until = :banned_until WHERE nickname = :nickname");
    return $stmt->execute([
        ':banned_until' => $bannedUntil,
        ':nickname' => $nickname
    ]);
}

public function editUser($nickname, $firstName, $lastName, $email, $isAdmin, $password = null) {
    // Si se proporciona contraseña nueva, la hasheamos
    if (!empty($password)) {
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $this->db->prepare("
            UPDATE Users
            SET first_name = :first_name,
                last_name = :last_name,
                email = :email,
                is_admin = :is_admin,
                password_hash = :password_hash
            WHERE nickname = :nickname
        ");
        return $stmt->execute([
            ':first_name' => $firstName,
            ':last_name'  => $lastName,
            ':email'      => $email,
            ':is_admin'   => $isAdmin,
            ':password_hash' => $passwordHash,
            ':nickname'   => $nickname
        ]);
    } else {
        // Si no hay nueva contraseña
        $stmt = $this->db->prepare("
            UPDATE Users
            SET first_name = :first_name,
                last_name = :last_name,
                email = :email,
                is_admin = :is_admin
            WHERE nickname = :nickname
        ");
        return $stmt->execute([
            ':first_name' => $firstName,
            ':last_name'  => $lastName,
            ':email'      => $email,
            ':is_admin'   => $isAdmin,
            ':nickname'   => $nickname
        ]);
    }
}


}
?>