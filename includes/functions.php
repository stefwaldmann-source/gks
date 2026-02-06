<?php

declare(strict_types=1);

require_once __DIR__ . '/db.php';

session_start();

function setting(string $key, string $default = ''): string
{
    $stmt = db()->prepare('SELECT value FROM settings WHERE `key` = :k LIMIT 1');
    $stmt->execute(['k' => $key]);
    $row = $stmt->fetch();

    return $row['value'] ?? $default;
}

function isAdmin(): bool
{
    return isset($_SESSION['admin_id']);
}

function requireAdmin(): void
{
    if (!isAdmin()) {
        header('Location: /admin/login.php');
        exit;
    }
}

function e(?string $value): string
{
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}

function flash(?string $message = null): ?string
{
    if ($message !== null) {
        $_SESSION['flash'] = $message;
        return null;
    }

    if (!isset($_SESSION['flash'])) {
        return null;
    }

    $msg = $_SESSION['flash'];
    unset($_SESSION['flash']);

    return $msg;
}

function activeJobs(int $limit = 0): array
{
    $sql = 'SELECT * FROM jobs WHERE is_active = 1 ORDER BY created_at DESC';
    if ($limit > 0) {
        $sql .= ' LIMIT ' . (int) $limit;
    }

    return db()->query($sql)->fetchAll();
}

function pages(): array
{
    return db()->query('SELECT * FROM pages WHERE is_published = 1 ORDER BY sort_order ASC, title ASC')->fetchAll();
}
