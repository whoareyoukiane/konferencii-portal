<?php

class Auth
{
    public static function start(): void
    {
        session_start();
    }

    public static function login(array $user): void
    {
        $_SESSION['user_id'] = (int) $user['id'];
    }

    public static function logout(): void
    {
        $_SESSION = [];
        session_destroy();
    }

    public static function user(): ?array
    {
        if (empty($_SESSION['user_id'])) {
            return null;
        }
        return (new UserRepository())->findById((int) $_SESSION['user_id']);
    }

    public static function isAdmin(): bool
    {
        $user = self::user();
        return $user !== null && $user['role'] === 'admin';
    }
}
