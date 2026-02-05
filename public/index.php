<?php

declare(strict_types=1);

require __DIR__ . '/_boot.php';

$title = 'Startseite';
$heroTitle = setting('hero_title', 'Moderne Haustechnik aus einer Hand');
$heroSubtitle = setting('hero_subtitle', 'Heizung · Sanitär · Klima · Notdienst');
$heroButtonText = setting('hero_button_text', 'Jetzt beraten lassen');
$heroButtonUrl = setting('hero_button_url', '/page.php?slug=kontakt');
$heroImage = setting('hero_image', 'https://images.unsplash.com/photo-1581091226825-a6a2a5aee158?auto=format&fit=crop&w=1700&q=80');

$services = db()->query('SELECT * FROM service_boxes ORDER BY sort_order ASC, id ASC')->fetchAll();
$serviceSlugMap = [
    'heizung' => 'heizung',
    'sanitaer' => 'sanitaer',
    'klima & lueftung' => 'lueftung-klima',
    'lueftung & klima' => 'lueftung-klima',
    'solar' => 'solar',
    'bad & wellness' => 'sanitaer',
    'wartung & service' => 'kontakt',
];
$jobs = activeJobs(3);
$popupEnabled = setting('popup_enabled', '0') === '1';
$popupText = setting('popup_text');

require __DIR__ . '/_header.php';
?>

<section class="hero" style="background-image:url('<?= e($heroImage) ?>')">
    <div class="container hero-content">
        <h1><?= e($heroTitle) ?></h1>
        <p><?= e($heroSubtitle) ?></p>
        <p><a class="btn" href="<?= e($heroButtonUrl) ?>"><?= e($heroButtonText) ?></a></p>
    </div>
</section>

<div class="container">
    <?php if ($popupEnabled && $popupText !== ''): ?>
        <div class="notice"><?= nl2br(e($popupText)) ?></div>
    <?php endif; ?>

    <h2 class="section-title">Leistungen</h2>
    <section class="service-grid">
        <?php foreach ($services as $service): ?>
            <?php
            $serviceKey = strtolower(strtr($service['title'], ['Ä' => 'Ae', 'Ö' => 'Oe', 'Ü' => 'Ue', 'ä' => 'ae', 'ö' => 'oe', 'ü' => 'ue']));
            $serviceSlug = $serviceSlugMap[$serviceKey] ?? 'kontakt';
            ?>
            <a class="service-card" href="/page.php?slug=<?= e($serviceSlug) ?>">
                <span>•</span>
                <strong><?= e($service['title']) ?></strong>
                <p><?= e($service['description']) ?></p>
            </a>
        <?php endforeach; ?>
    </section>

    <h2 class="section-title">Karriere</h2>
    <section class="jobs-grid">
        <?php foreach ($jobs as $job): ?>
            <article class="card">
                <h3><?= e($job['title']) ?></h3>
                <p><strong>Standort:</strong> <?= e($job['location']) ?></p>
                <p><?= e($job['short_description']) ?></p>
                <a class="btn" href="/job.php?id=<?= (int) $job['id'] ?>">Jetzt bewerben</a>
            </article>
        <?php endforeach; ?>
    </section>
</div>

<?php require __DIR__ . '/_footer.php'; ?>
