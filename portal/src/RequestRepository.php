<?php

class RequestRepository
{
    public const STATUSES = ['новая', 'назначено', 'завершено'];
    public const ROOMS = ['Большой зал', 'Зал «Север»', 'Переговорная 2'];
    public const PAYMENTS = ['Банковская карта', 'Счёт для организации', 'Наличными на месте'];

    private const SELECT = 'SELECT r.*, e.title AS event_title, e.date AS event_date, u.login, u.email, u.phone
                              FROM requests r
                              JOIN events e ON e.id = r.event_id
                              JOIN users u ON u.id = r.user_id';

    public function create(int $userId, int $eventId, string $room, string $payment): int
    {
        $st = Database::get()->prepare('INSERT INTO requests (user_id, event_id, room, payment) VALUES (?, ?, ?, ?)');
        $st->execute([$userId, $eventId, $room, $payment]);
        return (int) Database::get()->lastInsertId();
    }

    public function find(int $id): ?array
    {
        $st = Database::get()->prepare(self::SELECT . ' WHERE r.id = ?');
        $st->execute([$id]);
        return $st->fetch() ?: null;
    }

    public function byUser(int $userId): array
    {
        $st = Database::get()->prepare(self::SELECT . ' WHERE r.user_id = ? ORDER BY r.id DESC');
        $st->execute([$userId]);
        return $st->fetchAll();
    }

    public function exists(int $userId, int $eventId): bool
    {
        $st = Database::get()->prepare('SELECT 1 FROM requests WHERE user_id = ? AND event_id = ?');
        $st->execute([$userId, $eventId]);
        return (bool) $st->fetch();
    }

    // фильтры необязательные
    public function all(?string $status = null, ?int $eventId = null): array
    {
        $sql = self::SELECT;
        $where = [];
        $args = [];
        if ($status) {
            $where[] = 'r.status = ?';
            $args[] = $status;
        }
        if ($eventId) {
            $where[] = 'r.event_id = ?';
            $args[] = $eventId;
        }
        if ($where) {
            $sql .= ' WHERE ' . implode(' AND ', $where);
        }
        $st = Database::get()->prepare($sql . ' ORDER BY r.id DESC');
        $st->execute($args);
        return $st->fetchAll();
    }

    public function setStatus(int $id, string $status): void
    {
        $st = Database::get()->prepare('UPDATE requests SET status = ? WHERE id = ?');
        $st->execute([$status, $id]);
    }

    public function delete(int $id): void
    {
        $st = Database::get()->prepare('DELETE FROM requests WHERE id = ?');
        $st->execute([$id]);
    }
}
