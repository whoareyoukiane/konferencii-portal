<h1>Регистрация</h1>
<form method="post" action="/register" class="form" data-validate="register" novalidate>
    <?= csrf_field() ?>
    <div class="field<?= isset($errors['login']) ? ' bad' : '' ?>">
        <label for="login">Логин</label>
        <input id="login" name="login" value="<?= e($old['login'] ?? '') ?>" autocomplete="username">
        <p class="err"><?= e($errors['login'] ?? '') ?></p>
    </div>
    <div class="field<?= isset($errors['email']) ? ' bad' : '' ?>">
        <label for="email">Почта</label>
        <input id="email" name="email" type="email" value="<?= e($old['email'] ?? '') ?>" autocomplete="email">
        <p class="err"><?= e($errors['email'] ?? '') ?></p>
    </div>
    <div class="field<?= isset($errors['phone']) ? ' bad' : '' ?>">
        <label for="phone">Телефон</label>
        <input id="phone" name="phone" type="tel" value="<?= e($old['phone'] ?? '') ?>" placeholder="+7 900 123-45-67" autocomplete="tel">
        <p class="err"><?= e($errors['phone'] ?? '') ?></p>
    </div>
    <div class="field<?= isset($errors['password']) ? ' bad' : '' ?>">
        <label for="password">Пароль</label>
        <input id="password" name="password" type="password" autocomplete="new-password">
        <p class="err"><?= e($errors['password'] ?? '') ?></p>
    </div>
    <button class="btn" type="submit">Зарегистрироваться</button>
</form>
<p>Уже есть аккаунт? <a href="/login">Войти</a></p>
