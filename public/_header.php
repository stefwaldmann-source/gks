<?php
/** @var string $title */
?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e($title) ?> | <?= e($siteName) ?></title>
    <link rel="stylesheet" href="/assets/css/style.css">
</head>
<body>
<header>
    <div class="container">
        <h1><?= e($siteName) ?></h1>
        <nav>
            <a href="/">Start</a>
            <a href="/jobs.php">Jobs</a>
            <?php foreach ($mainPages as $navPage): ?>
                <a href="/page.php?slug=<?= e($navPage['slug']) ?>"><?= e($navPage['title']) ?></a>
            <?php endforeach; ?>
            <a href="/admin/login.php">Admin</a>
        </nav>
    </div>
</header>
<main class="container">
