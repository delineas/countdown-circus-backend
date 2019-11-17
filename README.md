# Countdown Circus

## Install

PHP Dependencies

```
composer install
```

Create SQLite database:

```
mkdir database
cd database
touch db.sqlite
```

SQL Crete table

```
CREATE TABLE countdowns (
id INTEGER PRIMARY KEY AUTOINCREMENT,
title text NOT NULL,
date text NOT NULL
);
INSERT INTO countdowns (title, date) VALUES ('Boda de Perico', '2019-12-31');
```
