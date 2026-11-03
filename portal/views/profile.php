<h1>Личный кабинет</h1>
<dl class="profile">
    <div><dt>Логин</dt><dd><?= e($user['login']) ?></dd></div>
    <div><dt>Почта</dt><dd><?= e($user['email']) ?></dd></div>
    <div><dt>Телефон</dt><dd><?= e($user['phone']) ?></dd></div>
    <div><dt>Роль</dt><dd><?= $user['role'] === 'admin' ? 'администратор' : 'участник' ?></dd></div>
    <div><dt>Заявок подано</dt><dd><?= (int) $requestCount ?></dd></div>
</dl>
<?php if ($user['role'] !== 'admin'): ?>
    <a class="btn" href="/requests">Мои заявки</a>
<?php endif; ?>
