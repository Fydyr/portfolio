<?php

require_once 'BaseController.php';
require_once __DIR__ . '/../includes/db.php';
require_once __DIR__ . '/../includes/settings.php';

class AboutController extends BaseController
{
    private const GITHUB_CACHE    = __DIR__ . '/../assets/docs/.github-repos-cache.json';
    private const GITHUB_TTL_SEC  = 3600; // 1h
    private const GITHUB_MAX      = 6;

    public function index(): void
    {
        global $pdo;

        $birthDate = new DateTime('2005-03-15');
        $age       = (new DateTime())->diff($birthDate)->y;

        // Skills + passions pour les sections (déjà en DB)
        $skillsCount    = 0;
        $passionsCount  = 0;
        $projectsCount  = 0;
        try { $skillsCount   = (int)$pdo->query("SELECT COUNT(*) FROM skills WHERE visible = 1")->fetchColumn(); } catch (Exception $e) {}
        try { $passionsCount = (int)$pdo->query("SELECT COUNT(*) FROM passions WHERE visible = 1")->fetchColumn(); } catch (Exception $e) {}
        try { $projectsCount = (int)$pdo->query("SELECT COUNT(*) FROM projects WHERE visibilite = 1")->fetchColumn(); } catch (Exception $e) {}

        // Settings éditables
        $heroSubtitleRaw = setting('about_hero_subtitle', "{$age} ans, étudiant en BUT Informatique.");
        $heroSubtitle    = nl2br(htmlspecialchars(str_replace('%age%', (string)$age, $heroSubtitleRaw), ENT_QUOTES, 'UTF-8'));
        $bioHtml         = settingHtml('about_bio', '');
        $githubUser      = setting('github_user', 'Fydyr');
        $sections        = loadAboutSections();

        $repos = $this->fetchGithubRepos($githubUser);
        $hasCv = is_file(__DIR__ . '/../assets/docs/mon_cv.pdf');

        echo $this->view('about', compact(
            'age', 'skillsCount', 'passionsCount', 'projectsCount',
            'repos', 'hasCv', 'githubUser',
            'heroSubtitle', 'bioHtml', 'sections'
        ));
    }

    /**
     * Récupère les derniers repos publics depuis l'API GitHub, avec cache fichier.
     * Si l'API échoue (offline, rate limit), on retourne le cache même expiré.
     */
    private function fetchGithubRepos(string $githubUser): array
    {
        $cache = self::GITHUB_CACHE;

        if (is_file($cache) && (time() - filemtime($cache) < self::GITHUB_TTL_SEC)) {
            $data = json_decode((string)file_get_contents($cache), true);
            if (is_array($data)) return $data;
        }

        $url = 'https://api.github.com/users/' . urlencode($githubUser)
             . '/repos?sort=pushed&direction=desc&per_page=' . self::GITHUB_MAX;

        $ctx = stream_context_create([
            'http' => [
                'method'        => 'GET',
                'header'        => [
                    'User-Agent: portfolio-' . $githubUser,
                    'Accept: application/vnd.github+json',
                ],
                'timeout'       => 5,
                'ignore_errors' => true,
            ],
        ]);

        $raw = @file_get_contents($url, false, $ctx);
        if ($raw === false) {
            return $this->staleCacheOrEmpty();
        }

        $data = json_decode($raw, true);
        if (!is_array($data) || isset($data['message'])) {
            return $this->staleCacheOrEmpty();
        }

        $repos = [];
        foreach ($data as $r) {
            if (!empty($r['fork'])) continue;
            $repos[] = [
                'name'        => $r['name']        ?? '',
                'full_name'   => $r['full_name']   ?? '',
                'description' => $r['description'] ?? '',
                'html_url'    => $r['html_url']    ?? '',
                'language'    => $r['language']    ?? null,
                'stars'       => (int)($r['stargazers_count'] ?? 0),
                'forks'       => (int)($r['forks_count']      ?? 0),
                'pushed_at'   => $r['pushed_at']   ?? null,
            ];
            if (count($repos) >= self::GITHUB_MAX) break;
        }

        if (!empty($repos)) {
            @file_put_contents($cache, json_encode($repos, JSON_UNESCAPED_UNICODE));
        }
        return $repos;
    }

    private function staleCacheOrEmpty(): array
    {
        if (is_file(self::GITHUB_CACHE)) {
            $data = json_decode((string)file_get_contents(self::GITHUB_CACHE), true);
            if (is_array($data)) return $data;
        }
        return [];
    }
}
