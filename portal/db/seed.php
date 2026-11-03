<?php
// тестовые данные для проверки, запускать после db/migrate.php
require __DIR__ . '/../src/Database.php';
require __DIR__ . '/../src/UserRepository.php';

$db = Database::get();
if ($db->query('SELECT COUNT(*) FROM events')->fetchColumn() > 0) {
    echo "Данные уже есть\n";
    exit;
}

$events = [
    ['Веб-разработка: итоги года', '2026-09-18', 'Москва, Экспоцентр', 'Доклады о том, что изменилось во фронтенде и бэкенде за год. Секции по PHP, JavaScript и тестированию.', 'event-1.jpg'],
    ['Безопасность веб-приложений', '2026-10-09', 'Санкт-Петербург, Ленэкспо', 'Разбор типичных уязвимостей на примерах: SQL-инъекции, XSS, подмена сессии.', 'event-2.jpg'],
    ['Данные и аналитика', '2026-11-20', 'Москва, Крокус Экспо', 'Кейсы по базам данных, отчётам и запросам. Мастер-класс по оптимизации SQL.', 'event-3.jpg'],
    ['День дизайна интерфейсов', '2026-12-04', 'Казань, Kazan Expo', 'Адаптивные интерфейсы, дизайн-системы и доступность. Разбор студенческих работ.', 'event-4.jpg'],
    ['DevOps Weekend', '2026-12-18', 'Екатеринбург, Экспо', 'Контейнеры, CI/CD и мониторинг. Два дня практики в малых группах.', 'event-5.jpg'],
];
$st = $db->prepare('INSERT INTO events (title, date, place, description, image) VALUES (?, ?, ?, ?, ?)');
foreach ($events as $e) {
    $st->execute($e);
}

$users = new UserRepository();
$users->create('admin', 'Admin2026!', 'admin@konferencii.test', '+79000000001', 'admin');
$users->create('artem_v', 'Artem2026pass', 'artem@konferencii.test', '+79000000002');
$users->create('olga_p', 'Olga2026pass', 'olga@konferencii.test', '+79000000003');

// статусы: 1 новая, 2 назначено, 3 завершено
$st = $db->prepare('INSERT INTO requests (user_id, event_id, status_id, room, payment, created_at) VALUES (?, ?, ?, ?, ?, ?)');
$st->execute([2, 1, 3, 'Большой зал', 'Банковская карта', '2026-08-30 12:10:00']);
$st->execute([3, 1, 3, 'Зал «Север»', 'Счёт для организации', '2026-09-02 09:40:00']);
$st->execute([2, 2, 3, 'Зал «Север»', 'Банковская карта', '2026-09-25 18:05:00']);
$st->execute([2, 3, 2, 'Большой зал', 'Наличными на месте', '2026-10-20 14:30:00']);
$st->execute([3, 4, 1, 'Переговорная 2', 'Счёт для организации', '2026-10-22 11:00:00']);

$st = $db->prepare('INSERT INTO reviews (request_id, text, rating, created_at) VALUES (?, ?, ?, ?)');
$st->execute([1, 'Хорошая организация, понравилась секция по тестированию. Хотелось бы больше практики.', 4, '2026-09-20 10:00:00']);

echo "Тестовые данные добавлены\n";
