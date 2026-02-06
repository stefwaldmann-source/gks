<?php

declare(strict_types=1);

require __DIR__ . '/_boot.php';

$title = 'Startseite';
$heroTitle = setting('hero_title', 'Moderne Haustechnik aus einer Hand');
$heroSubtitle = setting('hero_subtitle', 'Heizung · Sanitär · Klima · Notdienst');
$heroButtonText = setting('hero_button_text', 'Jetzt beraten lassen');
$heroButtonUrl = setting('hero_button_url', '/page.php?slug=kontakt');
$heroImage = setting('hero_image', 'https://images.unsplash.com/photo-1581091226825-a6a2a5aee158?auto=format&fit=crop&w=1700&q=80');
$heroTitleImage = setting('hero_title_image');
$teaserStripImage = setting('teaser_strip_image', 'https://images.unsplash.com/photo-1621905252507-b35492cc74b4?auto=format&fit=crop&w=1700&q=80');

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

$aboutTitle = setting('about_title', 'Wir freuen uns auf Ihre Anfrage!');
$aboutText = setting('about_text', 'Als zuverlässiger Partner für Heizung, Sanitär und Lüftung begleiten wir Ihr Projekt von der Planung bis zur Wartung. Persönlich, transparent und handwerklich sauber.');
$statCards = [
    ['value' => setting('stat_1_value', '10'), 'label' => setting('stat_1_label', 'Mitarbeiter')],
    ['value' => setting('stat_2_value', '2'), 'label' => setting('stat_2_label', 'Standorte')],
    ['value' => setting('stat_3_value', '6870'), 'label' => setting('stat_3_label', 'Aufträge')],
    ['value' => setting('stat_4_value', '3'), 'label' => setting('stat_4_label', 'Azubis')],
];

require __DIR__ . '/_header.php';
?>

<section class="hero" style="background-image:url('<?= e($heroImage) ?>')">
    <div class="container hero-content">
        <?php if ($heroTitleImage !== ''): ?>
            <img class="hero-title-image" src="<?= e($heroTitleImage) ?>" alt="Teaser Titelbild">
        <?php endif; ?>
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

    <section class="stats-band">
        <h2>Wir liefern Ergebnisse – Qualität, die messbar ist</h2>
        <div class="stats-grid">
            <?php foreach ($statCards as $stat): ?>
                <article class="stat-card">
                    <strong><?= e($stat['value']) ?></strong>
                    <span><?= e($stat['label']) ?></span>
                </article>
            <?php endforeach; ?>
        </div>
    </section>

    <section class="info-grid">
        <article class="info-card">
            <h3>Schnelle Hilfe</h3>
            <p>Notdienst und Service für Heizungs- und Sanitärstörungen in der Region.</p>
            <p><strong>0911 / 6507 900</strong></p>
            <a class="btn" href="/page.php?slug=notdienst">Zum Notdienst</a>
        </article>
        <article class="info-card form-look">
            <h3>Schreiben Sie uns</h3>
            <p>Für Angebote, Rückfragen oder Terminwünsche.</p>
            <a class="btn" href="/page.php?slug=kontakt">Kontakt aufnehmen</a>
        </article>
        <article class="info-card">
            <h3>Karriere bei uns</h3>
            <p>Starte deine Karriere bei GKS Haustechnik – jetzt offene Stellen ansehen.</p>
            <a class="btn" href="/jobs.php">Zu den Jobs</a>
        </article>
    </section>

    <section class="teaser-strip" style="background-image:url('<?= e($teaserStripImage) ?>')">
        <div class="teaser-text">
            <h3>Bestell dir deine Wärmepumpe</h3>
            <p>Alles aus einer Hand: Beratung, Einbau, Wartung und Service.</p>
        </div>
    </section>

    <section class="about-section card">
        <h2><?= e($aboutTitle) ?></h2>
        <p><?= e($aboutText) ?></p>
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
