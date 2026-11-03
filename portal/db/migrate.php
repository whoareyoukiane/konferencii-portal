<?php
// применяет файлы из db/migrations по порядку: .sql и .php
require __DIR__ . '/../src/Database.php';

$db = Database::get();
$db->exec('CREATE TABLE IF NOT EXISTS schema_migrations (name TEXT PRIMARY KEY, applied_at TEXT NOT NULL DEFAULT CURRENT_TIMESTAMP)');

$done = $db->query('SELECT name FROM schema_migrations')->fetchAll(PDO::FETCH_COLUMN);
$files = glob(__DIR__ . '/migrations/*.{sql,php}', GLOB_BRACE);
sort($files);

foreach ($files as $file) {
    $name = basename($file);
    if (in_array($name, $done, true)) {
        continue;
    }
    echo "Применяю $name
";
    if (str_ends_with($name, '.sql')) {
        $db->exec(file_get_contents($file));
    } else {
        require $file;
    }
    $db->prepare('INSERT INTO schema_migrations (name) VALUES (?)')->execute([$name]);
}
echo "Готово
";
