<!doctype html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= e($title ?? 'Конференции.РФ') ?></title>
    <link rel="icon" href="/img/favicon.svg" type="image/svg+xml">
    <link rel="stylesheet" href="/css/style.css">
</head>
<body>
<header class="top">
    <div class="top-in">
        <a class="logo" href="/">Конференции<b>.РФ</b></a>
        <button class="burger" type="button" aria-label="Меню">Меню</button>
        <nav class="nav">
            <a href="/events">Мероприятия</a>
            <?php if (!$user): ?>
                <a href="/login">Вход</a>
                <a href="/register">Регистрация</a>
            <?php else: ?>
                <?php if ($user['role'] === 'admin'): ?>
                    <a href="/admin">Заявки</a>
                <?php else: ?>
                    <a href="/requests">Мои заявки</a>
                <?php endif; ?>
                <a href="/profile">Кабинет</a>
                <span class="who"><?= e($user['login']) ?></span>
                <form method="post" action="/logout" class="inline"><?= csrf_field() ?><button type="submit">Выйти</button></form>
            <?php endif; ?>
        </nav>
    </div>
</header>
<main>
    <?php if ($flash): ?>
        <p class="flash"><?= e($flash) ?></p>
    <?php endif; ?>
    <?= $content ?>
</main>
<footer>Конференции.РФ, учебный проект, 2026</footer>
<script src="/js/menu.js"></script>
<script src="/js/validate.js"></script>
</body>
</html>
