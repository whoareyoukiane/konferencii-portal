<?php
// пароли были открытым текстом: считаем хеши и удаляем старый столбец
// файл подключается из migrate.php, переменная $db уже есть

$db->exec('ALTER TABLE users ADD COLUMN password_hash TEXT');

$users = $db->query('SELECT id, password FROM users')->fetchAll();
$update = $db->prepare('UPDATE users SET password_hash = ? WHERE id = ?');
foreach ($users as $user) {
    $update->execute([password_hash($user['password'], PASSWORD_DEFAULT), $user['id']]);
}

$db->exec('ALTER TABLE users DROP COLUMN password');
echo 'Захешировано паролей: ' . count($users) . "\n";
