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
<header class="site-header">
    <div class="container inner">
        <a class="logo" href="/">
            GKS
            <small>Haustechnik</small>
        </a>

        <nav class="nav" aria-label="Hauptnavigation">
            <a href="/">Start</a>
            <a href="/page.php?slug=heizung">Leistungen</a>
            <a href="/page.php?slug=notdienst">Notdienst</a>
            <a href="/jobs.php">Karriere</a>
            <a href="/page.php?slug=kontakt">Kontakt</a>
        </nav>

        <a class="btn" href="/page.php?slug=kontakt">Termin anfragen</a>
    </div>
</header>

<main>
