<?php

// экранирование вывода
function e(?string $text): string
{
    return htmlspecialchars((string) $text, ENT_QUOTES, 'UTF-8');
}

// скрытое поле с токеном для каждой формы с методом post
function csrf_field(): string
{
    return '<input type="hidden" name="_token" value="' . e(Csrf::token()) . '">';
}

function date_ru(string $date): string
{
    return date('d.m.Y', strtotime($date));
}
