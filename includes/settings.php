<?php
/**
 * Helpers pour lire les site_settings et about_sections,
 * + parser markdown via Parsedown.
 */

require_once __DIR__ . '/../vendor/autoload.php';

/**
 * Récupère toutes les settings sous forme [key => ['value' => ..., 'is_markdown' => ...]]
 * Cache en mémoire pour ne pas hammer la DB sur une même requête.
 */
function loadSiteSettings(): array
{
    static $cache = null;
    if ($cache !== null) return $cache;

    global $pdo;
    $cache = [];
    try {
        $stmt = $pdo->query("SELECT `key`, `value`, `is_markdown` FROM site_settings");
        foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $row) {
            $cache[$row['key']] = ['value' => $row['value'], 'is_markdown' => (int)$row['is_markdown']];
        }
    } catch (Exception $e) {
        // Table absente -> tableau vide
    }
    return $cache;
}

/**
 * Récupère une setting brute (ou $default).
 */
function setting(string $key, string $default = ''): string
{
    $s = loadSiteSettings();
    return $s[$key]['value'] ?? $default;
}

/**
 * Récupère une setting et la rend en HTML :
 *  - si is_markdown=1 : passe par Parsedown
 *  - sinon : htmlspecialchars + nl2br
 */
function settingHtml(string $key, string $default = ''): string
{
    $s = loadSiteSettings();
    if (!isset($s[$key])) {
        return nl2br(htmlspecialchars($default, ENT_QUOTES, 'UTF-8'));
    }

    $value = $s[$key]['value'] ?? '';
    if (!empty($s[$key]['is_markdown'])) {
        $parsedown = new Parsedown();
        $parsedown->setSafeMode(true);
        return $parsedown->text($value);
    }
    return nl2br(htmlspecialchars($value, ENT_QUOTES, 'UTF-8'));
}

/**
 * Rend du markdown en HTML (utilisé pour about_sections).
 */
function renderMarkdown(string $md): string
{
    $parsedown = new Parsedown();
    $parsedown->setSafeMode(true);
    return $parsedown->text($md);
}

/**
 * Récupère les sections About visibles dans l'ordre.
 */
function loadAboutSections(bool $visibleOnly = true): array
{
    global $pdo;
    try {
        $sql = "SELECT * FROM about_sections";
        if ($visibleOnly) $sql .= " WHERE visible = 1";
        $sql .= " ORDER BY sort_order, id";
        return $pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
        return [];
    }
}
