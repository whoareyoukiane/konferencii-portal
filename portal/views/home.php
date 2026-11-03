<section class="hero">
    <div>
        <h1>Заявки на конференции онлайн</h1>
        <p>Выберите мероприятие, помещение и способ оплаты. Статус заявки виден в личном кабинете.</p>
        <a class="btn" href="/events">Все мероприятия</a>
    </div>
    <img src="/img/hero.jpg" alt="Зал конференции, слушатели" width="1280" height="640">
</section>

<h2>Ближайшие мероприятия</h2>
<div class="cards">
    <?php foreach ($events as $event): ?>
        <?php require __DIR__ . '/_event_card.php'; ?>
    <?php endforeach; ?>
</div>
