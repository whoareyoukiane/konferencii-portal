-- логин уникален без учёта регистра, чтобы нельзя было создать Admin рядом с admin
CREATE UNIQUE INDEX users_login_nocase ON users (login COLLATE NOCASE);
