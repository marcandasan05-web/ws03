<?php

/**
 * Get the base path
 * 
 * 
 * @param string $path
 * @return string
 */

function basePath($path = '')
{
    return __DIR__ . '/' . $path;
}

/**
 * Load view
 * 
 * @param string $name
 * @return void
 */

function loadView($name, $data = [])
{
    $viewPath = basePath("App/views/{$name}.view.php");

    if (file_exists($viewPath)) {
        extract($data);
        require $viewPath;
    } else {
        echo "View {$name} not found.";
    }

}

/**
 * Load partials
 * 
 * @param string $name
 * @return void
 */

function loadPartial($name, $data = [])
{
    $partialPath = basePath("App/views/partials/{$name}.php");

    if (file_exists($partialPath)) {
        if (!empty($data)) {
            extract($data);
        }
        require $partialPath;
    } else {
        echo "Partial '{$name}' not found.";
    }
}

function formatSalary($salary) {
    return '$' . number_format(floatval($salary));
}

/**
 * Job categories for search and filtering.
 *
 * @return array<string, string> slug => label
 */
function jobCategories(): array
{
    return [
        '' => 'All Categories',
        'software-development' => 'Software Development',
        'devops-cloud' => 'DevOps & Cloud',
        'data-ai' => 'Data & AI',
        'design-ux' => 'Design & UX',
        'cybersecurity' => 'Cybersecurity',
        'mobile' => 'Mobile Development',
    ];
}

function categoryLabel(?string $slug): string
{
    $categories = jobCategories();
    return $categories[$slug ?? ''] ?? 'General';
}

function formatTagList(?string $tags): array
{
    if ($tags === null || trim($tags) === '') {
        return [];
    }

    return array_filter(array_map('trim', explode(',', $tags)));
}

/**
 * Sanitize Data
 * 
 * @param string $dirty
 * @return string
 * 
 */

function sanitize($dirty) {
    return filter_var(trim($dirty), FILTER_SANITIZE_SPECIAL_CHARS);
}

/**
 * Redirect to a given uel
 * 
 * @param string $url
 * @return void
 */
/**
 * Normalize the request URI for routing (strip app base path)
 */
function normalizeUri(): string
{
    $uri = rawurldecode(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
    $basePath = rawurldecode(str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'])));

    if ($basePath !== '/' && $basePath !== '' && str_starts_with($uri, $basePath)) {
        $uri = substr($uri, strlen($basePath)) ?: '/';
    }

    if ($uri === '/index.php' || str_starts_with($uri, '/index.php/')) {
        $uri = substr($uri, strlen('/index.php')) ?: '/';
    }

    if ($uri === '' || $uri === false) {
        return '/';
    }

    return str_starts_with($uri, '/') ? $uri : '/' . $uri;
}

/**
 * Application base path (e.g. /ITWS-03 Job Listing Axle/public)
 */
function baseUrl($path = '')
{
    static $base = null;

    if ($base === null) {
        $base = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME']));
        $base = rtrim($base, '/');
    }

    if ($path === '' || $path === '/') {
        return $base === '' ? '/' : $base . '/';
    }

    return $base . '/' . ltrim($path, '/');
}

/**
 * Build an app route URL
 */
function url($path = '/')
{
    return baseUrl($path);
}

/**
 * Build a public asset URL (css, images, etc.)
 */
function asset($path)
{
    return baseUrl($path);
}

function redirect($url)
{
    if (str_starts_with($url, '/')) {
        $url = url($url);
    }

    header("Location: {$url}");
    exit;
}

function e($value): string
{
    return htmlspecialchars((string) $value, ENT_QUOTES, 'UTF-8');
}

function isLoggedIn(): bool
{
    return isset($_SESSION['user']);
}

function currentUser(): ?array
{
    return $_SESSION['user'] ?? null;
}

function currentUserId(): ?int
{
    return isset($_SESSION['user']['id']) ? (int) $_SESSION['user']['id'] : null;
}

function requireAuth(): void
{
    if (!isLoggedIn()) {
        $_SESSION['error_message'] = 'Please log in to continue.';
        redirect('/login');
    }
}

function isEmployer(): bool
{
    return isLoggedIn() && (currentUser()['role'] ?? '') === 'employer';
}

function requireEmployer(): void
{
    requireAuth();

    if (!isEmployer()) {
        setFlash('error_message', 'Only employer accounts can post or manage job listings.');
        redirect('/listings');
    }
}

function setFlash(string $key, string $message): void
{
    $_SESSION[$key] = $message;
}

function getFlash(string $key): ?string
{
    if (!isset($_SESSION[$key])) {
        return null;
    }

    $message = $_SESSION[$key];
    unset($_SESSION[$key]);
    return $message;
}