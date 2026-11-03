<?php

class EventRepository
{
    public function all(): array
    {
        // rating: средняя оценка по отзывам или null
        return Database::get()->query(
            'SELECT e.*,
                    (SELECT ROUND(AVG(rv.rating), 1) FROM reviews rv
                       JOIN requests r ON r.id = rv.request_id
                      WHERE r.event_id = e.id) AS rating
               FROM events e ORDER BY e.date'
        )->fetchAll();
    }

    public function find(int $id): ?array
    {
        $st = Database::get()->prepare('SELECT * FROM events WHERE id = ?');
        $st->execute([$id]);
        return $st->fetch() ?: null;
    }
}
