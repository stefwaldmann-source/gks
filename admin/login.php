<?php

declare(strict_types=1);

require_once __DIR__ . '/../includes/functions.php';

if (isAdmin()) {
    header('Location: /admin/index.php');
    exit;
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    $stmt = db()->prepare('SELECT * FROM users WHERE email = :email LIMIT 1');
    $stmt->execute(['email' => $email]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password_hash'])) {
        $_SESSION['admin_id'] = $user['id'];
        $_SESSION['admin_name'] = $user['name'];
        header('Location: /admin/index.php');
        exit;
    }

    $error = 'Login fehlgeschlagen.';
}
?>
<!doctype html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <link rel="stylesheet" href="/assets/css/style.css">
</head>
<body>
<main class="container">
    <h1>Admin Login</h1>
    <?php if ($error): ?><div class="alert"><?= e($error) ?></div><?php endif; ?>
    <form method="post" class="card">
        <label>E-Mail</label>
        <input type="email" name="email" required>
        <label>Passwort</label>
        <input type="password" name="password" required>
        <button class="btn" type="submit">Einloggen</button>
    </form>
</main>
</body>
</html>
