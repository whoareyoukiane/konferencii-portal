<article class="card">
    <?php if ($event['image']): ?>
        <img src="/img/<?= e($event['image']) ?>" alt="" width="640" height="360">
    <?php endif; ?>
    <h3><?= e($event['title']) ?></h3>
    <p class="meta"><?= date_ru($event['date']) ?>, <?= e($event['place']) ?></p>
    <p><?= e($event['description']) ?></p>
    <?php if ($event['rating'] !== null): ?>
        <p class="stars" title="Средняя оценка участников"><?= str_repeat('★', (int) round($event['rating'])) ?> <span class="meta"><?= e((string) $event['rating']) ?></span></p>
    <?php endif; ?>
    <?php if ($event['date'] >= date('Y-m-d')): ?>
        <a class="btn" href="/requests/new?event=<?= (int) $event['id'] ?>">Подать заявку</a>
    <?php else: ?>
        <span class="meta">Мероприятие прошло</span>
    <?php endif; ?>
</article>
