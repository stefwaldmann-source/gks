<?php

declare(strict_types=1);

require __DIR__ . '/_boot.php';

$title = 'Jobs';
$jobs = activeJobs();
require __DIR__ . '/_header.php';
?>
<h2>Aktuelle Stellenangebote</h2>
<section class="grid services">
    <?php foreach ($jobs as $job): ?>
        <article class="card">
            <h3><?= e($job['title']) ?></h3>
            <p><strong>Standort:</strong> <?= e($job['location']) ?></p>
            <p><?= e($job['short_description']) ?></p>
            <a class="btn" href="/job.php?id=<?= (int) $job['id'] ?>">Details</a>
        </article>
    <?php endforeach; ?>
</section>
<?php require __DIR__ . '/_footer.php'; ?>
