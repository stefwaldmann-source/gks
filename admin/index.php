<?php

declare(strict_types=1);

require_once __DIR__ . '/../includes/functions.php';
requireAdmin();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';

    if ($action === 'save_setting') {
        $key = $_POST['key'] ?? '';
        $value = $_POST['value'] ?? '';
        $stmt = db()->prepare('INSERT INTO settings(`key`, value) VALUES(:k, :v) ON DUPLICATE KEY UPDATE value = VALUES(value)');
        $stmt->execute(['k' => $key, 'v' => $value]);
        flash('Einstellung gespeichert.');
    }

    if ($action === 'save_page') {
        $id = (int) ($_POST['id'] ?? 0);
        $data = [
            'title' => trim($_POST['title'] ?? ''),
            'slug' => trim($_POST['slug'] ?? ''),
            'intro' => trim($_POST['intro'] ?? ''),
            'content' => trim($_POST['content'] ?? ''),
            'is_published' => isset($_POST['is_published']) ? 1 : 0,
            'sort_order' => (int) ($_POST['sort_order'] ?? 0),
        ];

        if ($id > 0) {
            $sql = 'UPDATE pages SET title=:title, slug=:slug, intro=:intro, content=:content, is_published=:is_published, sort_order=:sort_order WHERE id=:id';
            $stmt = db()->prepare($sql);
            $data['id'] = $id;
            $stmt->execute($data);
        } else {
            $sql = 'INSERT INTO pages(title, slug, intro, content, is_published, sort_order) VALUES(:title,:slug,:intro,:content,:is_published,:sort_order)';
            db()->prepare($sql)->execute($data);
        }
        flash('Seite gespeichert.');
    }

    if ($action === 'delete_page') {
        db()->prepare('DELETE FROM pages WHERE id = :id')->execute(['id' => (int) $_POST['id']]);
        flash('Seite gelöscht.');
    }

    if ($action === 'save_job') {
        $id = (int) ($_POST['id'] ?? 0);
        $data = [
            'title' => trim($_POST['title'] ?? ''),
            'short_description' => trim($_POST['short_description'] ?? ''),
            'tasks' => trim($_POST['tasks'] ?? ''),
            'requirements' => trim($_POST['requirements'] ?? ''),
            'benefits' => trim($_POST['benefits'] ?? ''),
            'location' => trim($_POST['location'] ?? ''),
            'is_active' => isset($_POST['is_active']) ? 1 : 0,
        ];
        if ($id > 0) {
            $sql = 'UPDATE jobs SET title=:title, short_description=:short_description, tasks=:tasks, requirements=:requirements, benefits=:benefits, location=:location, is_active=:is_active WHERE id=:id';
            $data['id'] = $id;
            db()->prepare($sql)->execute($data);
        } else {
            $sql = 'INSERT INTO jobs(title, short_description, tasks, requirements, benefits, location, is_active) VALUES(:title,:short_description,:tasks,:requirements,:benefits,:location,:is_active)';
            db()->prepare($sql)->execute($data);
        }
        flash('Job gespeichert.');
    }

    if ($action === 'delete_job') {
        db()->prepare('DELETE FROM jobs WHERE id = :id')->execute(['id' => (int) $_POST['id']]);
        flash('Job gelöscht.');
    }

    if ($action === 'save_service') {
        $id = (int) ($_POST['id'] ?? 0);
        $data = [
            'title' => trim($_POST['title'] ?? ''),
            'description' => trim($_POST['description'] ?? ''),
            'image_url' => trim($_POST['image_url'] ?? ''),
            'sort_order' => (int) ($_POST['sort_order'] ?? 0),
        ];
        if ($id > 0) {
            $sql = 'UPDATE service_boxes SET title=:title, description=:description, image_url=:image_url, sort_order=:sort_order WHERE id=:id';
            $data['id'] = $id;
            db()->prepare($sql)->execute($data);
        } else {
            $sql = 'INSERT INTO service_boxes(title, description, image_url, sort_order) VALUES(:title,:description,:image_url,:sort_order)';
            db()->prepare($sql)->execute($data);
        }
        flash('Leistungsbox gespeichert.');
    }

    if ($action === 'delete_service') {
        db()->prepare('DELETE FROM service_boxes WHERE id = :id')->execute(['id' => (int) $_POST['id']]);
        flash('Leistungsbox gelöscht.');
    }

    header('Location: /admin/index.php');
    exit;
}

$pages = db()->query('SELECT * FROM pages ORDER BY sort_order ASC, id ASC')->fetchAll();
$jobs = db()->query('SELECT * FROM jobs ORDER BY created_at DESC')->fetchAll();
$services = db()->query('SELECT * FROM service_boxes ORDER BY sort_order ASC, id ASC')->fetchAll();
$msg = flash();
?>
<!doctype html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adminbereich</title>
    <link rel="stylesheet" href="/assets/css/style.css">
</head>
<body>
<main class="container">
    <h1>Adminbereich</h1>
    <p>Eingeloggt als <?= e($_SESSION['admin_name']) ?> · <a href="/admin/logout.php">Logout</a></p>
    <?php if ($msg): ?><div class="alert"><?= e($msg) ?></div><?php endif; ?>

    <section class="card">
        <h2>Startseiten-Teaser & Popup</h2>
        <?php foreach (['logo_url','hero_title_image','hero_title','hero_subtitle','hero_button_text','hero_button_url','hero_image','teaser_strip_image','about_title','about_text','stat_1_value','stat_1_label','stat_2_value','stat_2_label','stat_3_value','stat_3_label','stat_4_value','stat_4_label','popup_text','opening_hours','job_email'] as $settingKey): ?>
            <form method="post">
                <input type="hidden" name="action" value="save_setting">
                <input type="hidden" name="key" value="<?= e($settingKey) ?>">
                <label><?= e($settingKey) ?></label>
                <input name="value" value="<?= e(setting($settingKey)) ?>">
                <button class="btn" type="submit">Speichern</button>
            </form>
        <?php endforeach; ?>
        <form method="post">
            <input type="hidden" name="action" value="save_setting">
            <input type="hidden" name="key" value="popup_enabled">
            <label>Popup aktiv (1/0)</label>
            <input name="value" value="<?= e(setting('popup_enabled', '0')) ?>">
            <button class="btn" type="submit">Speichern</button>
        </form>
    </section>

    <section class="card">
        <h2>CMS-Seiten</h2>
        <table><tr><th>Titel</th><th>Slug</th><th>Status</th><th>Aktion</th></tr>
            <?php foreach ($pages as $p): ?>
            <tr><td><?= e($p['title']) ?></td><td><?= e($p['slug']) ?></td><td><?= $p['is_published'] ? 'online':'offline' ?></td>
                <td><form method="post"><input type="hidden" name="action" value="delete_page"><input type="hidden" name="id" value="<?= (int)$p['id'] ?>"><button>löschen</button></form></td></tr>
            <?php endforeach; ?>
        </table>
        <h3>Neue/Seite bearbeiten</h3>
        <form method="post">
            <input type="hidden" name="action" value="save_page">
            <label>ID (leer = neu)</label><input name="id">
            <label>Titel</label><input name="title" required>
            <label>Slug</label><input name="slug" required>
            <label>Einleitung</label><textarea name="intro"></textarea>
            <label>Inhalt</label><textarea name="content" rows="6"></textarea>
            <label>Sortierung</label><input name="sort_order" type="number" value="0">
            <label><input type="checkbox" name="is_published" checked> Veröffentlicht</label>
            <button class="btn" type="submit">Seite speichern</button>
        </form>
    </section>

    <section class="card">
        <h2>Jobs</h2>
        <table><tr><th>Titel</th><th>Standort</th><th>Status</th><th>Aktion</th></tr>
            <?php foreach ($jobs as $j): ?>
            <tr><td><?= e($j['title']) ?></td><td><?= e($j['location']) ?></td><td><?= $j['is_active'] ? 'aktiv':'inaktiv' ?></td>
                <td><form method="post"><input type="hidden" name="action" value="delete_job"><input type="hidden" name="id" value="<?= (int)$j['id'] ?>"><button>löschen</button></form></td></tr>
            <?php endforeach; ?>
        </table>
        <h3>Job erstellen/bearbeiten</h3>
        <form method="post">
            <input type="hidden" name="action" value="save_job">
            <label>ID (leer = neu)</label><input name="id">
            <label>Titel</label><input name="title" required>
            <label>Kurzbeschreibung</label><textarea name="short_description"></textarea>
            <label>Aufgaben</label><textarea name="tasks"></textarea>
            <label>Anforderungen</label><textarea name="requirements"></textarea>
            <label>Benefits</label><textarea name="benefits"></textarea>
            <label>Standort</label><input name="location">
            <label><input type="checkbox" name="is_active" checked> Aktiv</label>
            <button class="btn" type="submit">Job speichern</button>
        </form>
    </section>

    <section class="card">
        <h2>Leistungs-Boxen</h2>
        <table><tr><th>Titel</th><th>Sortierung</th><th>Aktion</th></tr>
            <?php foreach ($services as $s): ?>
                <tr><td><?= e($s['title']) ?></td><td><?= (int)$s['sort_order'] ?></td>
                <td><form method="post"><input type="hidden" name="action" value="delete_service"><input type="hidden" name="id" value="<?= (int)$s['id'] ?>"><button>löschen</button></form></td></tr>
            <?php endforeach; ?>
        </table>
        <form method="post">
            <input type="hidden" name="action" value="save_service">
            <label>ID (leer = neu)</label><input name="id">
            <label>Titel</label><input name="title" required>
            <label>Beschreibung</label><textarea name="description"></textarea>
            <label>Bild-URL</label><input name="image_url">
            <label>Sortierung</label><input name="sort_order" type="number" value="0">
            <button class="btn" type="submit">Box speichern</button>
        </form>
    </section>
</main>
</body>
</html>
