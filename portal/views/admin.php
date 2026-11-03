<h1>Заявки участников</h1>
<form method="get" action="/admin" class="filters">
    <div class="field">
        <label for="status">Статус</label>
        <select id="status" name="status">
            <option value="">Все статусы</option>
            <?php foreach (RequestRepository::STATUSES as $s): ?>
                <option<?= $status === $s ? ' selected' : '' ?>><?= e($s) ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="field">
        <label for="event">Мероприятие</label>
        <select id="event" name="event">
            <option value="">Все мероприятия</option>
            <?php foreach ($events as $ev): ?>
                <option value="<?= (int) $ev['id'] ?>"<?= $eventId === (int) $ev['id'] ? ' selected' : '' ?>><?= e($ev['title']) ?></option>
            <?php endforeach; ?>
        </select>
    </div>
    <button class="btn" type="submit">Показать</button>
</form>
<p class="meta">Найдено заявок: <?= count($requests) ?></p>
<div class="cards">
    <?php foreach ($requests as $r): ?>
        <article class="card">
            <span class="badge"><?= e($r['status']) ?></span>
            <h3><?= e($r['event_title']) ?></h3>
            <p class="meta"><?= date_ru($r['event_date']) ?>, <?= e($r['room']) ?>, <?= e($r['payment']) ?></p>
            <p class="meta"><?= e($r['login']) ?>, <?= e($r['email']) ?>, <?= e($r['phone']) ?></p>
            <p class="meta">Заявка № <?= (int) $r['id'] ?> от <?= date_ru($r['created_at']) ?></p>
            <div class="row">
                <?php if ($r['status'] !== 'завершено'): ?>
                    <form method="post" action="/admin/requests/<?= (int) $r['id'] ?>/status" class="inline">
                        <?= csrf_field() ?>
                        <button class="btn small" type="submit"><?= $r['status'] === 'новая' ? 'Назначить' : 'Завершить' ?></button>
                    </form>
                <?php endif; ?>
                <form method="post" action="/admin/requests/<?= (int) $r['id'] ?>/delete" class="inline">
                    <?= csrf_field() ?>
                    <button class="btn small danger" type="submit">Удалить</button>
                </form>
            </div>
        </article>
    <?php endforeach; ?>
</div>
