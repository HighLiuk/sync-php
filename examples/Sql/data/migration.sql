CREATE TABLE IF NOT EXISTS users(
  id integer PRIMARY KEY AUTOINCREMENT,
  name varchar(255) NOT NULL,
  email varchar(255) NOT NULL,
  UNIQUE (email)
);

