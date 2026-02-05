<?php

declare(strict_types=1);

require __DIR__ . '/_boot.php';

$slug = $_GET['slug'] ?? '';
$stmt = db()->prepare('SELECT * FROM pages WHERE slug = :slug AND is_published = 1 LIMIT 1');
$stmt->execute(['slug' => $slug]);
$page = $stmt->fetch();

if (!$page) {
    http_response_code(404);
    $title = 'Seite nicht gefunden';
    require __DIR__ . '/_header.php';
    echo '<p>Diese Seite wurde nicht gefunden.</p>';
    require __DIR__ . '/_footer.php';
    exit;
}

$title = $page['title'];
require __DIR__ . '/_header.php';
?>
<article class="card">
    <h2><?= e($page['title']) ?></h2>
    <p><?= nl2br(e($page['intro'])) ?></p>
    <hr>
    <div><?= nl2br(e($page['content'])) ?></div>
</article>
<?php require __DIR__ . '/_footer.php'; ?>
