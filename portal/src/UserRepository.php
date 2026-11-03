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

    // пароль приходит обычным текстом, в базу уходит только хеш
    public function create(string $login, string $password, string $email, string $phone, string $role = 'participant'): int
    {
        $st = Database::get()->prepare('INSERT INTO users (login, password_hash, email, phone, role) VALUES (?, ?, ?, ?, ?)');
        $st->execute([$login, password_hash($password, PASSWORD_DEFAULT), $email, $phone, $role]);
        return (int) Database::get()->lastInsertId();
    }
}
