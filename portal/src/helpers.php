<?php

// экранирование вывода
function e(?string $text): string
{
    return htmlspecialchars((string) $text, ENT_QUOTES, 'UTF-8');
}

function date_ru(string $date): string
{
    return date('d.m.Y', strtotime($date));
}
