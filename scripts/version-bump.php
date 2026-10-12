<?php
// Usage: php scripts/version-bump.php [--dry-run] X.Y.Z
$args = array_slice($argv, 1);
$dry_run = ($args[0] ?? '') === '--dry-run';
if ($dry_run) {
    array_shift($args);
}
$version = $args[0] ?? '';
if (count($args) !== 1 || !preg_match('/^[0-9]+\.[0-9]+\.[0-9]+$/D', $version)) {
    fwrite(STDERR, "Usage: php scripts/version-bump.php [--dry-run] X.Y.Z\n");
    exit(1);
}
chdir(dirname(__DIR__));
$patterns = [
    'cook-app.php' => '/^(\s*\*\s*Version:[ \t]*)([^\r\n]+)$/m',
    'README.md' => '/^(- Stable tag:[ \t]*)([^\r\n]+)$/m',
];
$updates = [];
foreach ($patterns as $path => $pattern) {
    $contents = file_get_contents($path);
    if ($contents === false || preg_match_all($pattern, $contents, $matches) !== 1) {
        fwrite(STDERR, "Expected exactly one version field in {$path}.\n");
        exit(1);
    }
    $current = trim($matches[2][0]);
    echo "{$path}: {$current} -> {$version}\n";
    $updates[$path] = preg_replace_callback($pattern, static function ($match) use ($version) {
        return $match[1] . $version;
    }, $contents);
}
if ($dry_run) {
    echo "Dry run: no files changed.\n";
    exit(0);
}
foreach ($updates as $path => $contents) {
    if (file_put_contents($path, $contents) === false) {
        fwrite(STDERR, "Could not write {$path}.\n");
        exit(1);
    }
}
