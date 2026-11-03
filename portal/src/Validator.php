<?php

// проверки полей, ошибка возвращается текстом, если всё хорошо - null
class Validator
{
    public static function login(string $value): ?string
    {
        if (!preg_match('/^[A-Za-z0-9_]{3,20}$/', $value)) {
            return 'Логин: от 3 до 20 символов, латиница, цифры и «_»';
        }
        return null;
    }

    public static function password(string $value): ?string
    {
        if (strlen($value) < 8) {
            return 'Пароль не короче 8 символов';
        }
        if (trim($value) === '') {
            return 'Пароль не может состоять из одних пробелов';
        }
        // bcrypt читает только первые 72 байта, остальное отбрасывает
        if (strlen($value) > 72) {
            return 'Пароль не длиннее 72 байт (кириллическая буква занимает 2 байта)';
        }
        return null;
    }

    public static function email(string $value): ?string
    {
        if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
            return 'Введите почту в формате name@site.ru';
        }
        return null;
    }

    // телефон приводим к виду +7XXXXXXXXXX, если не получилось - null
    public static function normalizePhone(string $value): ?string
    {
        // кроме цифр можно только пробелы, плюс, скобки и дефис
        if (!preg_match('/^[\d\s+()\-]+$/', $value)) {
            return null;
        }
        $digits = preg_replace('/\D/', '', $value);
        if (strlen($digits) === 11 && ($digits[0] === '7' || $digits[0] === '8')) {
            return '+7' . substr($digits, 1);
        }
        return null;
    }

    public static function phone(string $value): ?string
    {
        if (self::normalizePhone($value) === null) {
            return 'Телефон в формате +7 900 123-45-67';
        }
        return null;
    }
}
