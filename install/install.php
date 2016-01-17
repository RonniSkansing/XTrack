<?php
require __DIR__.'/../vendor/autoload.php';
require __DIR__.'/../application/config.php';
$injector = require __DIR__.'/../application/bindings.php';
$sqlite = $injector->make('SQLite3');

// add drop before create
$sqlite->exec('
  CREATE TABLE requests
  (
    id INTEGER PRIMARY KEY,
    time UNSIGNED INT NOT NULL,
    protocol VARCHAR(16) NOT NULL,
    method VARCHAR(16) NOT NULL,
    uri STRING NOT NULL,
    port UNSIGNED INTEGER  NOT NULL,
    agent VARCHAR(255) NULL,
    ip VARCHAR(32) NULL,
    headers STRING NULL,
    body STRING NULL
  );

  CREATE TABLE users
  (
    id INTEGER PRIMARY KEY,
    username STRING NOT NULL,
    password VARCHAR(255) NOT NULL
  );

  INSERT INTO users (
    username, password
  ) VALUES (
    "admin",
    "$2y$10$N1vuy3eECEOnO80o327VMeQruHwXhNxYc2lsOCgjd8rNBhY3H.QpO"
  );
');
echo 'DONE'.PHP_EOL;
