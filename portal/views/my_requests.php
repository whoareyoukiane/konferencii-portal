<h1>Мои заявки</h1>
<p><a class="btn small" href="/requests/new">Новая заявка</a></p>
<?php if (!$requests): ?>
    <p class="empty">Заявок пока нет. Выберите мероприятие и подайте первую.</p>
<?php endif; ?>
<div class="cards">
    <?php foreach ($requests as $r): ?>
        <article class="card">
            <span class="badge <?= status_class($r['status']) ?>"><?= e($r['status']) ?></span>
            <h3><?= e($r['event_title']) ?></h3>
            <p class="meta"><?= date_ru($r['event_date']) ?>, <?= e($r['room']) ?>, <?= e($r['payment']) ?></p>
            <p class="meta">Заявка № <?= (int) $r['id'] ?> от <?= date_ru($r['created_at']) ?></p>

            <?php if ($r['review_id']): ?>
                <p class="stars"><?= str_repeat('★', (int) $r['rating']) . str_repeat('☆', 5 - (int) $r['rating']) ?></p>
                <p><?= e($r['review_text']) ?></p>
            <?php elseif ($r['status'] === 'завершено' && $r['event_date'] < date('Y-m-d')): ?>
                <form method="post" action="/requests/<?= (int) $r['id'] ?>/review" class="review">
                    <?= csrf_field() ?>
                    <div class="field">
                        <label for="rating<?= (int) $r['id'] ?>">Оценка</label>
                        <select id="rating<?= (int) $r['id'] ?>" name="rating">
                            <?php foreach ([5, 4, 3, 2, 1] as $n): ?>
                                <option value="<?= $n ?>"><?= $n ?> из 5</option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="field">
                        <label for="text<?= (int) $r['id'] ?>">Отзыв</label>
                        <textarea id="text<?= (int) $r['id'] ?>" name="text" rows="3" maxlength="500"></textarea>
                    </div>
                    <button class="btn small" type="submit">Отправить отзыв</button>
                </form>
            <?php else: ?>
                <p class="meta">Отзыв можно оставить после завершения мероприятия</p>
            <?php endif; ?>
        </article>
    <?php endforeach; ?>
</div>
