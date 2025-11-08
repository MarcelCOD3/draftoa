<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$lang = $_SESSION['lang'] ?? 'es';

require_once $_SERVER['DOCUMENT_ROOT'] . '/draftosaurus/app/controllers/UserController.php';
$userController = new UserController();

// Manejar registro
$registerError = '';
$registerSuccess = false;
$prevData = ['nickname'=>'','first_name'=>'','last_name'=>'','email'=>''];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['register'])) {
    $data = [
        'nickname'   => trim($_POST['nickname'] ?? ''),
        'first_name' => trim($_POST['first_name'] ?? ''),
        'last_name'  => trim($_POST['last_name'] ?? ''),
        'email'      => trim($_POST['email'] ?? ''),
        'password'   => $_POST['password'] ?? ''
    ];

    $prevData = $data;
    $confirmPassword = $_POST['confirmPassword'] ?? '';

    if ($data['password'] !== $confirmPassword) {
        $registerError = $langTexts['password_mismatch'];
    } else {
        $result = $userController->register($data);
        if ($result['success']) {
            $registerSuccess = true;
            $prevData = ['nickname'=>'','first_name'=>'','last_name'=>'','email'=>''];
        } else {
            $registerError = $result['error'] ?? $langTexts['register_error'];
        }
    }
}
?>

<!DOCTYPE html>
<html lang="<?= $lang ?>">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Draftosaurus - <?= $langTexts['register_title'] ?></title>

    <!-- Bootstrap y FontAwesome -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Estilos propios -->
    <link rel="stylesheet" href="/draftosaurus/public/css/styles.css">
    <link rel="stylesheet" href="/draftosaurus/public/css/layouts/navbar.css">
    <link rel="stylesheet" href="/draftosaurus/public/css/views/register.css">
    <link rel="stylesheet" href="/draftosaurus/public/css/layouts/footer.css">
</head>

<body>
    <div id="app" class="d-flex flex-column min-vh-100">

        <?php include $_SERVER['DOCUMENT_ROOT'] . '/draftosaurus/app/views/layouts/navbar.php'; ?>

        <main class="home-container flex-grow-1">
            <h1 class="title text-center"><?= $langTexts['register_heading'] ?></h1>

            <div class="row justify-content-center py-3">
                <div class="col-md-8">
                    <div class="card shadow-sm profile-card">
                        <div class="card-body">
                            <?php if($registerError): ?>
                            <div class="alert alert-danger"><?= htmlspecialchars($registerError) ?></div>
                            <?php elseif($registerSuccess): ?>
                            <div class="alert alert-success"><?= $langTexts['register_success'] ?></div>
                            <?php endif; ?>

                            <form method="POST" id="registerForm" novalidate>
                                <input type="hidden" name="register" value="1">

                                <!-- Nickname -->
                                <div class="mb-3">
                                    <label for="nickname" class="form-label"><?= $langTexts['nickname'] ?></label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-user"></i></span>
                                        <input type="text" class="form-control" id="nickname" name="nickname"
                                            value="<?= htmlspecialchars($prevData['nickname']) ?>"
                                            placeholder="<?= $langTexts['nickname'] ?>"
                                            title="<?= $langTexts['nickname'] ?>" required>
                                        <span class="input-group-text" id="nicknameStatus"></span>
                                    </div>
                                </div>

                                <!-- First Name -->
                                <div class="mb-3">
                                    <label for="first_name" class="form-label"><?= $langTexts['first_name'] ?></label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-id-card"></i></span>
                                        <input type="text" class="form-control" id="first_name" name="first_name"
                                            value="<?= htmlspecialchars($prevData['first_name']) ?>"
                                            placeholder="<?= $langTexts['first_name'] ?>"
                                            title="<?= $langTexts['first_name'] ?>" required>
                                    </div>
                                </div>

                                <!-- Last Name -->
                                <div class="mb-3">
                                    <label for="last_name" class="form-label"><?= $langTexts['last_name'] ?></label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-id-card-alt"></i></span>
                                        <input type="text" class="form-control" id="last_name" name="last_name"
                                            value="<?= htmlspecialchars($prevData['last_name']) ?>"
                                            placeholder="<?= $langTexts['last_name'] ?>"
                                            title="<?= $langTexts['last_name'] ?>" required>
                                    </div>
                                </div>

                                <!-- Email -->
                                <div class="mb-3">
                                    <label for="email" class="form-label"><?= $langTexts['email'] ?></label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                        <input type="email" class="form-control" id="email" name="email"
                                            value="<?= htmlspecialchars($prevData['email']) ?>"
                                            placeholder="<?= $langTexts['email'] ?>" title="<?= $langTexts['email'] ?>"
                                            required>
                                    </div>
                                </div>

                                <!-- Password -->
                                <div class="mb-3">
                                    <label for="password" class="form-label"><?= $langTexts['password'] ?></label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                        <input type="password" class="form-control" id="password" name="password"
                                            placeholder="<?= $langTexts['password'] ?>"
                                            title="<?= $langTexts['password'] ?>" required>
                                        <span class="input-group-text toggle-password" data-target="#password"
                                            title="<?= $langTexts['show-hide'] ?>">
                                            <i class="fas fa-eye"></i>
                                        </span>
                                    </div>
                                </div>

                                <!-- Confirm Password -->
                                <div class="mb-3">
                                    <label for="confirmPassword"
                                        class="form-label"><?= $langTexts['confirm_password'] ?></label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                        <input type="password" class="form-control" id="confirmPassword"
                                            name="confirmPassword" placeholder="<?= $langTexts['confirm_password'] ?>"
                                            title="<?= $langTexts['confirm_password'] ?>" required>
                                        <span class="input-group-text toggle-password" data-target="#confirmPassword"
                                            title="<?= $langTexts['show-hide'] ?>">
                                            <i class="fas fa-eye"></i>
                                        </span>
                                    </div>
                                </div>

                                <!-- Accept Terms -->
                                <div class="mb-3 form-check">
                                    <input type="checkbox" class="form-check-input" id="acceptTerms">
                                    <label class="form-check-label" for="acceptTerms">
                                        <?= $langTexts['terms_accept'] ?>
                                        <a href="#" class="terms-link" data-bs-toggle="modal"
                                            data-bs-target="#termsModal" title="<?= $langTexts['terms_link'] ?>">
                                            <?= $langTexts['terms_link'] ?>
                                        </a>
                                    </label>
                                </div>

                                <!-- Submit -->
                                <button type="submit" class="btn btn-custom w-100" id="registerBtn" disabled
                                    title="<?= $langTexts['register_button'] ?>">
                                    <?= $langTexts['register_button'] ?>
                                </button>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </main>

        <?php include $_SERVER['DOCUMENT_ROOT'] . '/draftosaurus/app/views/layouts/footer.php'; ?>

        <!-- Terms Modal -->
        <div class="modal fade modal-dark" id="termsModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content modal-dark">
                    <div class="modal-header">
                        <h5 class="modal-title"><?= $langTexts['terms_title'] ?></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            title="<?= $langTexts['close'] ?>"></button>
                    </div>
                    <div class="modal-body" style="max-height:60vh; overflow-y:auto;">
                        <h2 class="title"><?= $langTexts['terms_intro_title'] ?></h2>
                        <p><?= $langTexts['terms_intro_text'] ?></p>
                        <h2 class="title"><?= $langTexts['terms_age_title'] ?></h2>
                        <p><?= $langTexts['terms_age_text'] ?></p>
                        <h2 class="title"><?= $langTexts['terms_account_title'] ?></h2>
                        <p><?= $langTexts['terms_account_text'] ?></p>
                        <h2 class="title"><?= $langTexts['terms_usage_title'] ?></h2>
                        <p><?= $langTexts['terms_usage_text'] ?></p>
                        <h2 class="title"><?= $langTexts['terms_content_title'] ?></h2>
                        <p><?= $langTexts['terms_content_text'] ?></p>
                        <h2 class="title"><?= $langTexts['terms_responsibility_title'] ?></h2>
                        <p><?= $langTexts['terms_responsibility_text'] ?></p>
                        <h2 class="title"><?= $langTexts['terms_modifications_title'] ?></h2>
                        <p><?= $langTexts['terms_modifications_text'] ?></p>
                        <h2 class="title"><?= $langTexts['terms_contact_title'] ?></h2>
                        <p><?= $langTexts['terms_contact_text'] ?></p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                            title="<?= $langTexts['close'] ?>">
                            <?= $langTexts['close'] ?>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>
        <script src="/draftosaurus/public/js/register.js"></script>
    </div>
</body>

</html>