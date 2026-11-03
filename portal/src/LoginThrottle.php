<?php

// не больше 5 неудачных входов за 10 минут с одного адреса на один логин
class LoginThrottle
{
    private const MAX = 5;
    private const WINDOW = 600;

    public static function blocked(string $ip, string $login): bool
    {
        $st = Database::get()->prepare('SELECT COUNT(*) FROM login_attempts WHERE ip = ? AND login = ? AND created_at > ?');
        $st->execute([$ip, $login, time() - self::WINDOW]);
        return (int) $st->fetchColumn() >= self::MAX;
    }

    public static function fail(string $ip, string $login): void
    {
        $st = Database::get()->prepare('INSERT INTO login_attempts (ip, login, created_at) VALUES (?, ?, ?)');
        $st->execute([$ip, $login, time()]);
    }

    public static function clear(string $ip, string $login): void
    {
        $st = Database::get()->prepare('DELETE FROM login_attempts WHERE ip = ? AND login = ?');
        $st->execute([$ip, $login]);
    }
}
