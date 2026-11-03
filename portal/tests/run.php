<?php
// проверка правил Validator без браузера: php -c php.ini tests/run.php
require __DIR__ . '/../src/Validator.php';

$failed = 0;
$total = 0;

function check(string $name, $expected, $actual): void
{
    global $failed, $total;
    $total++;
    if ($expected === $actual) {
        echo "ok    $name\n";
    } else {
        $failed++;
        echo "FAIL  $name (ждали " . var_export($expected, true) . ", получили " . var_export($actual, true) . ")\n";
    }
}

// логин
check('логин из 3 символов', null, Validator::login('abc'));
check('логин из 2 символов', true, Validator::login('ab') !== null);
check('логин из 20 символов', null, Validator::login(str_repeat('a', 20)));
check('логин из 21 символа', true, Validator::login(str_repeat('a', 21)) !== null);
check('логин кириллицей', true, Validator::login('Арсений') !== null);

// пароль
check('пароль из 8 символов', null, Validator::password('12345678'));
check('пароль из 7 символов', true, Validator::password('1234567') !== null);
check('пароль из 8 пробелов', true, Validator::password('        ') !== null);
check('пароль из 72 байт', null, Validator::password(str_repeat('a', 72)));
check('пароль из 73 байт', true, Validator::password(str_repeat('a', 73)) !== null);
check('пароль кириллицей 37 букв (74 байта)', true, Validator::password(str_repeat('ы', 37)) !== null);

// почта
check('почта верная', null, Validator::email('user@mail.ru'));
check('почта без @', true, Validator::email('user.mail.ru') !== null);
check('почта без домена', true, Validator::email('a@b') !== null);

// телефон
check('телефон с +7 и дефисами', '+79001234567', Validator::normalizePhone('+7 900 123-45-67'));
check('телефон с 8 и скобками', '+79001234567', Validator::normalizePhone('8 (900) 123-45-67'));
check('телефон с буквами', null, Validator::normalizePhone('+7 900 123-45-67 abc'));
check('телефон из 5 цифр', null, Validator::normalizePhone('+79001'));
check('телефон начинается с 9', null, Validator::normalizePhone('+9 900 123 45 67'));

echo "\nПроверок: $total, не прошло: $failed\n";
exit($failed ? 1 : 0);
