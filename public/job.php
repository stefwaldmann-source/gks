<?php

declare(strict_types=1);

require __DIR__ . '/_boot.php';

$id = (int) ($_GET['id'] ?? 0);
$stmt = db()->prepare('SELECT * FROM jobs WHERE id = :id AND is_active = 1 LIMIT 1');
$stmt->execute(['id' => $id]);
$job = $stmt->fetch();

if (!$job) {
    http_response_code(404);
    $title = 'Job nicht gefunden';
    require __DIR__ . '/_header.php';
    echo '<p>Der Job wurde nicht gefunden.</p>';
    require __DIR__ . '/_footer.php';
    exit;
}

$title = $job['title'];
require __DIR__ . '/_header.php';
?>
<article class="card">
    <h2><?= e($job['title']) ?></h2>
    <p><strong>Standort:</strong> <?= e($job['location']) ?></p>
    <h3>Aufgaben</h3>
    <p><?= nl2br(e($job['tasks'])) ?></p>
    <h3>Anforderungen</h3>
    <p><?= nl2br(e($job['requirements'])) ?></p>
    <h3>Benefits</h3>
    <p><?= nl2br(e($job['benefits'])) ?></p>
    <a class="btn" href="mailto:<?= e(setting('job_email', 'jobs@gkshaustechnik.de')) ?>?subject=Bewerbung%20<?= rawurlencode($job['title']) ?>">Bewerbung senden</a>
</article>
<?php require __DIR__ . '/_footer.php'; ?>
