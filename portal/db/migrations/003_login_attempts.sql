-- неудачные попытки входа, чтобы ограничить подбор пароля
CREATE TABLE login_attempts (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    ip TEXT NOT NULL,
    login TEXT NOT NULL,
    created_at INTEGER NOT NULL
);

CREATE INDEX idx_login_attempts ON login_attempts (ip, login, created_at);
