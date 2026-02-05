<?php

declare(strict_types=1);

require __DIR__ . '/_boot.php';

$title = 'Startseite';
$heroTitle = setting('hero_title', 'Moderne Haustechnik für Ihr Zuhause');
$heroSubtitle = setting('hero_subtitle', 'Heizung, Sanitär, Klima und Energietechnik aus einer Hand.');
$heroButtonText = setting('hero_button_text', 'Jetzt beraten lassen');
$heroButtonUrl = setting('hero_button_url', '/page.php?slug=kontakt');
$heroImage = setting('hero_image', 'https://images.unsplash.com/photo-1505691938895-1758d7feb511?auto=format&fit=crop&w=1200&q=80');

$services = db()->query('SELECT * FROM service_boxes ORDER BY sort_order ASC, id ASC')->fetchAll();
$jobs = activeJobs(3);
$popupEnabled = setting('popup_enabled', '0') === '1';
$popupText = setting('popup_text');

require __DIR__ . '/_header.php';
?>

<?php if ($popupEnabled && $popupText !== ''): ?>
    <div class="popup"><?= nl2br(e($popupText)) ?></div>
<?php endif; ?>

<section class="hero">
    <img src="<?= e($heroImage) ?>" alt="Hero">
    <div>
        <h2><?= e($heroTitle) ?></h2>
        <p><?= e($heroSubtitle) ?></p>
        <a class="btn" href="<?= e($heroButtonUrl) ?>"><?= e($heroButtonText) ?></a>
    </div>
</section>

<h2>Unsere Leistungen</h2>
<section class="grid services">
    <?php foreach ($services as $service): ?>
        <article class="card">
            <img src="<?= e($service['image_url']) ?>" alt="<?= e($service['title']) ?>">
            <h3><?= e($service['title']) ?></h3>
            <p><?= e($service['description']) ?></p>
        </article>
    <?php endforeach; ?>
</section>

<h2>Karriere bei GKS</h2>
<section class="grid services">
    <?php foreach ($jobs as $job): ?>
        <article class="card">
            <h3><?= e($job['title']) ?></h3>
            <p><strong>Standort:</strong> <?= e($job['location']) ?></p>
            <p><?= e($job['short_description']) ?></p>
            <a class="btn" href="/job.php?id=<?= (int) $job['id'] ?>">Jetzt bewerben</a>
        </article>
    <?php endforeach; ?>
</section>

<?php require __DIR__ . '/_footer.php'; ?>
