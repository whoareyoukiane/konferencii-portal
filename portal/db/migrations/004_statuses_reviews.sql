-- статусы заявок выносим в отдельную таблицу, добавляем отзывы

CREATE TABLE statuses (
    id INTEGER PRIMARY KEY,
    name TEXT NOT NULL UNIQUE
);

INSERT INTO statuses (id, name) VALUES (1, 'новая'), (2, 'назначено'), (3, 'завершено');

-- пересобираем заявки: вместо текста статуса ссылка на таблицу statuses
CREATE TABLE requests_new (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    user_id INTEGER NOT NULL REFERENCES users(id),
    event_id INTEGER NOT NULL REFERENCES events(id),
    status_id INTEGER NOT NULL DEFAULT 1 REFERENCES statuses(id),
    room TEXT NOT NULL,
    payment TEXT NOT NULL,
    created_at TEXT NOT NULL DEFAULT (datetime('now', 'localtime')),
    UNIQUE (user_id, event_id)
);

-- данные переносим как есть, статус ищем по названию
INSERT INTO requests_new (id, user_id, event_id, status_id, room, payment, created_at)
SELECT r.id, r.user_id, r.event_id, s.id, r.room, r.payment, r.created_at
FROM requests r
JOIN statuses s ON s.name = r.status;

DROP TABLE requests;
ALTER TABLE requests_new RENAME TO requests;

CREATE TABLE reviews (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    request_id INTEGER NOT NULL UNIQUE REFERENCES requests(id) ON DELETE CASCADE,
    text TEXT NOT NULL,
    rating INTEGER NOT NULL CHECK (rating BETWEEN 1 AND 5),
    created_at TEXT NOT NULL DEFAULT (datetime('now', 'localtime'))
);
