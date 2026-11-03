<h1>Мои заявки</h1>
<p><a class="btn" href="/requests/new">Новая заявка</a></p>
<?php if (!$requests): ?>
    <p class="empty">Заявок пока нет. Выберите мероприятие и подайте первую.</p>
<?php endif; ?>
<div class="cards">
    <?php foreach ($requests as $r): ?>
        <article class="card">
            <span class="badge"><?= e($r['status']) ?></span>
            <h3><?= e($r['event_title']) ?></h3>
            <p class="meta"><?= date_ru($r['event_date']) ?>, <?= e($r['room']) ?>, <?= e($r['payment']) ?></p>
            <p class="meta">Заявка № <?= (int) $r['id'] ?> от <?= date_ru($r['created_at']) ?></p>
        </article>
    <?php endforeach; ?>
</div>
