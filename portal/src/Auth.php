<?php

class Auth
{
    private const IDLE_LIMIT = 1800; // 30 минут без действий

    public static function start(): void
    {
        session_set_cookie_params([
            'lifetime' => 0,
            'path' => '/',
            'httponly' => true,
            'samesite' => 'Strict',
            'secure' => !empty($_SERVER['HTTPS']),
        ]);
        session_start();

        // если долго ничего не делал, сессия заканчивается
        if (isset($_SESSION['last_seen']) && time() - $_SESSION['last_seen'] > self::IDLE_LIMIT) {
            $_SESSION = [];
        }
        $_SESSION['last_seen'] = time();
    }

    public static function login(array $user): void
    {
        session_regenerate_id(true); // новый идентификатор после входа
        $_SESSION['user_id'] = (int) $user['id'];
    }

    public static function logout(): void
    {
        $_SESSION = [];
        if (ini_get('session.use_cookies')) {
            $p = session_get_cookie_params();
            setcookie(session_name(), '', time() - 3600, $p['path'], $p['domain'], $p['secure'], $p['httponly']);
        }
        session_destroy();
    }

    public static function user(): ?array
    {
        if (empty($_SESSION['user_id'])) {
            return null;
        }
        return (new UserRepository())->findById((int) $_SESSION['user_id']);
    }
}
