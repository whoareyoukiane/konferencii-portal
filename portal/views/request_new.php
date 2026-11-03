<h1>Заявка на участие</h1>
<form method="post" action="/requests" class="form" data-validate="request" novalidate>
    <?= csrf_field() ?>
    <div class="field<?= isset($errors['event_id']) ? ' bad' : '' ?>">
        <label for="event_id">Мероприятие</label>
        <select id="event_id" name="event_id">
            <option value="">Выберите мероприятие</option>
            <?php foreach ($events as $ev): ?>
                <option value="<?= (int) $ev['id'] ?>"<?= ($old['event_id'] ?? 0) == $ev['id'] ? ' selected' : '' ?>>
                    <?= e($ev['title']) ?> (<?= date_ru($ev['date']) ?>)
                </option>
            <?php endforeach; ?>
        </select>
        <p class="err"><?= e($errors['event_id'] ?? '') ?></p>
    </div>
    <div class="field<?= isset($errors['room']) ? ' bad' : '' ?>">
        <label for="room">Помещение</label>
        <select id="room" name="room">
            <option value="">Выберите помещение</option>
            <?php foreach (RequestRepository::ROOMS as $room): ?>
                <option<?= ($old['room'] ?? '') === $room ? ' selected' : '' ?>><?= e($room) ?></option>
            <?php endforeach; ?>
        </select>
        <p class="err"><?= e($errors['room'] ?? '') ?></p>
    </div>
    <div class="field<?= isset($errors['payment']) ? ' bad' : '' ?>">
        <label for="payment">Способ оплаты</label>
        <select id="payment" name="payment">
            <option value="">Выберите способ</option>
            <?php foreach (RequestRepository::PAYMENTS as $pay): ?>
                <option<?= ($old['payment'] ?? '') === $pay ? ' selected' : '' ?>><?= e($pay) ?></option>
            <?php endforeach; ?>
        </select>
        <p class="err"><?= e($errors['payment'] ?? '') ?></p>
    </div>
    <button class="btn" type="submit">Отправить заявку</button>
</form>
