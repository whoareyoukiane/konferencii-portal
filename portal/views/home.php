<section class="hero">
    <h1>Заявки на конференции онлайн</h1>
    <p>Выберите мероприятие, помещение и способ оплаты. Статус заявки виден в личном кабинете.</p>
    <p><a class="btn" href="/events">Все мероприятия</a></p>
</section>

<h2>Ближайшие мероприятия</h2>
<div class="cards">
    <?php foreach ($events as $event): ?>
        <?php require __DIR__ . '/_event_card.php'; ?>
    <?php endforeach; ?>
</div>
