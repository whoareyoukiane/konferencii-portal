<h1>Вход</h1>
<form method="post" action="/login" class="form" novalidate>
    <?php if ($error): ?>
        <p class="note-error"><?= e($error) ?></p>
    <?php endif; ?>
    <div class="field">
        <label for="login">Логин</label>
        <input id="login" name="login" value="<?= e($old['login'] ?? '') ?>" autocomplete="username">
    </div>
    <div class="field">
        <label for="password">Пароль</label>
        <input id="password" name="password" type="password" autocomplete="current-password">
    </div>
    <button class="btn" type="submit">Войти</button>
</form>
<p>Нет аккаунта? <a href="/register">Зарегистрироваться</a></p>
