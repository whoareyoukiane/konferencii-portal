<h1>Мероприятия</h1>
<div class="cards">
    <?php foreach ($events as $event): ?>
        <?php require __DIR__ . '/_event_card.php'; ?>
    <?php endforeach; ?>
</div>
