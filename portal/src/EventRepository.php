<?php

class EventRepository
{
    public function all(): array
    {
        return Database::get()->query('SELECT * FROM events ORDER BY date')->fetchAll();
    }

    public function find(int $id): ?array
    {
        $st = Database::get()->prepare('SELECT * FROM events WHERE id = ?');
        $st->execute([$id]);
        return $st->fetch() ?: null;
    }
}
