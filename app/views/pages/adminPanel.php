<?php
if (session_status() === PHP_SESSION_NONE) session_start();

// Comprobar si es admin
if (empty($_SESSION['is_admin']) || !in_array($_SESSION['is_admin'], [1, true], true)) {
    header('Location: /draftosaurus/public/index.php?page=main');
    exit();
}

// Controlador
require_once $_SERVER['DOCUMENT_ROOT'].'/draftosaurus/app/controllers/AdminController.php';
$adminController = new AdminController();

// Manejo de acciones POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Eliminar usuario
    if (!empty($_POST['delete_nickname'])) {
        $adminController->deleteUser($_POST['delete_nickname']);
        header('Location: /draftosaurus/public/index.php?page=adminPanel');
        exit();
    }

    // Bannear usuario
    if (!empty($_POST['ban_nickname']) && !empty($_POST['ban_days'])) {
        $nickname = $_POST['ban_nickname'];
        $days = (int)$_POST['ban_days'];
        $banUntil = date('Y-m-d H:i:s', strtotime("+$days days"));
        $adminController->banUser($nickname, $banUntil);
        header('Location: /draftosaurus/public/index.php?page=adminPanel');
        exit();
    }

    // Desbanear usuario
    if (!empty($_POST['unban_nickname'])) {
        $nickname = $_POST['unban_nickname'];
        $adminController->banUser($nickname, null); // null quita el baneo
        header('Location: /draftosaurus/public/index.php?page=adminPanel');
        exit();
    }

    // Editar usuario
    if (!empty($_POST['edit_nickname'])) {
        $nickname = $_POST['edit_nickname'];
        $firstName = trim($_POST['first_name']);
        $lastName = trim($_POST['last_name']);
        $email = trim($_POST['email']);
        $isAdmin = $_POST['role'] === 'Admin' ? 1 : 0;
        $password = trim($_POST['password']) ?: null;

        $adminController->editUser($nickname, $firstName, $lastName, $email, $isAdmin, $password);

        $_SESSION['editUserFeedback'] = "Usuario '$nickname' actualizado correctamente.";
        header('Location: /draftosaurus/public/index.php?page=adminPanel');
        exit();
    }
}

// Obtener todos los usuarios
$usuarios = $adminController->getAllUsers();
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Panel de Administración</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/draftosaurus/public/css/views/adminPanel.css">
</head>

<body>
    <?php include __DIR__ . '/../layouts/navbar.php'; ?>

    <div class="container-fluid py-5">
        <h1 class="mb-4">Panel de Administración</h1>
        <h2 class="mb-3">Usuarios registrados</h2>

        <!-- Alertas de edición -->
        <?php if (!empty($_SESSION['editUserFeedback'])): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?= htmlspecialchars($_SESSION['editUserFeedback']) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php unset($_SESSION['editUserFeedback']); ?>
        <?php endif; ?>

        <table class="table table-striped table-hover table-bordered align-middle text-center">
            <thead>
                <tr>
                    <th>Nickname</th>
                    <th>Nombre</th>
                    <th>Apellido</th>
                    <th>Email</th>
                    <th>Rol</th>
                    <th>Estado</th>
                    <th>Baneado hasta</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($usuarios as $u): ?>
                <tr>
                    <td><?= htmlspecialchars($u['nickname']) ?></td>
                    <td><?= htmlspecialchars($u['first_name']) ?></td>
                    <td><?= htmlspecialchars($u['last_name']) ?></td>
                    <td><?= htmlspecialchars($u['email']) ?></td>
                    <td><?= $u['is_admin'] ? 'Admin' : 'Jugador' ?></td>
                    <td><?= $u['active'] ? 'Activo' : 'Inactivo' ?></td>
                    <td><?= $u['banned_until'] ?? '-' ?></td>
                    <td class="d-flex justify-content-center gap-1 flex-wrap">

                        <!-- Editar -->
                        <button type="button" class="btn btn-sm btn-warning" data-bs-toggle="modal"
                            data-bs-target="#editUserModal" data-nickname="<?= htmlspecialchars($u['nickname']) ?>"
                            data-first_name="<?= htmlspecialchars($u['first_name']) ?>"
                            data-last_name="<?= htmlspecialchars($u['last_name']) ?>"
                            data-email="<?= htmlspecialchars($u['email']) ?>"
                            data-role="<?= $u['is_admin'] ? 'Admin' : 'Jugador' ?>">
                            <i class="fas fa-edit"></i>
                        </button>

                        <!-- Eliminar -->
                        <form method="post" style="display:inline;">
                            <input type="hidden" name="delete_nickname" value="<?= htmlspecialchars($u['nickname']) ?>">
                            <button type="submit" class="btn btn-sm btn-danger"
                                onclick="return confirm('¿Eliminar usuario <?= htmlspecialchars($u['nickname']) ?>?');">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </form>

                        <!-- Bannear -->
                        <?php if (empty($u['banned_until'])): ?>
                        <form method="post" class="d-flex gap-1 align-items-center">
                            <input type="hidden" name="ban_nickname" value="<?= htmlspecialchars($u['nickname']) ?>">
                            <input type="number" name="ban_days" min="1" max="365" class="form-control form-control-sm"
                                placeholder="días" style="width:70px;">
                            <button type="submit" class="btn btn-sm btn-dark"><i class="fas fa-ban"></i></button>
                        </form>
                        <?php else: ?>
                        <!-- Desbanear -->
                        <form method="post">
                            <input type="hidden" name="unban_nickname" value="<?= htmlspecialchars($u['nickname']) ?>">
                            <button type="submit" class="btn btn-sm btn-success"><i class="fas fa-check"></i></button>
                        </form>
                        <?php endif; ?>

                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- Modal Editar Usuario -->
    <div class="modal fade" id="editUserModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form method="post">
                    <div class="modal-header">
                        <h5 class="modal-title"><i class="fas fa-edit me-2"></i>Editar Usuario</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="edit_nickname" id="edit_nickname">
                        <div class="mb-3">
                            <label>Nombre</label>
                            <input type="text" class="form-control" name="first_name" id="edit_first_name" required>
                        </div>
                        <div class="mb-3">
                            <label>Apellido</label>
                            <input type="text" class="form-control" name="last_name" id="edit_last_name" required>
                        </div>
                        <div class="mb-3">
                            <label>Email</label>
                            <input type="email" class="form-control" name="email" id="edit_email" required>
                        </div>
                        <div class="mb-3">
                            <label>Rol</label>
                            <select class="form-select" name="role" id="edit_role">
                                <option value="Jugador">Jugador</option>
                                <option value="Admin">Admin</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label>Nueva Contraseña (opcional)</label>
                            <input type="password" class="form-control" name="password"
                                placeholder="Dejar vacío no cambia">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary">Guardar cambios</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    // Pasar datos del usuario al modal al abrirlo
    var editModal = document.getElementById('editUserModal');
    editModal.addEventListener('show.bs.modal', function(event) {
        var button = event.relatedTarget;
        document.getElementById('edit_nickname').value = button.getAttribute('data-nickname');
        document.getElementById('edit_first_name').value = button.getAttribute('data-first_name');
        document.getElementById('edit_last_name').value = button.getAttribute('data-last_name');
        document.getElementById('edit_email').value = button.getAttribute('data-email');
        document.getElementById('edit_role').value = button.getAttribute('data-role');
    });
    </script>

    <?php include __DIR__ . '/../layouts/footer.php'; ?>
</body>

</html>