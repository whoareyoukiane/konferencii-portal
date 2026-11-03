<?php

// защита форм: в каждой форме скрытое поле с токеном сессии
class Csrf
{
    public static function token(): string
    {
        if (empty($_SESSION['csrf'])) {
            $_SESSION['csrf'] = bin2hex(random_bytes(32));
        }
        return $_SESSION['csrf'];
    }

    public static function valid(): bool
    {
        $sent = $_POST['_token'] ?? '';
        return is_string($sent) && hash_equals(self::token(), $sent);
    }
}
