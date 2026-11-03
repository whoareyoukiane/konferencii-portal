<?php

class UserRepository
{
    public function findByLogin(string $login): ?array
    {
        $st = Database::get()->prepare('SELECT * FROM users WHERE login = ?');
        $st->execute([$login]);
        return $st->fetch() ?: null;
    }

    public function findById(int $id): ?array
    {
        $st = Database::get()->prepare('SELECT * FROM users WHERE id = ?');
        $st->execute([$id]);
        return $st->fetch() ?: null;
    }

    public function create(string $login, string $password, string $email, string $phone, string $role = 'participant'): int
    {
        $st = Database::get()->prepare('INSERT INTO users (login, password, email, phone, role) VALUES (?, ?, ?, ?, ?)');
        $st->execute([$login, $password, $email, $phone, $role]);
        return (int) Database::get()->lastInsertId();
    }
}
