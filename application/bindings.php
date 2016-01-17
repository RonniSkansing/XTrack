<?php
/**
* Returns $injector
*/
$config = require __DIR__.'/config.php';
$injector = new Auryn\Injector;

$injector->define(
  'SQLite3',
  [
    ':filename' => __DIR__.'/storage/sqlite.db',
    ':flags' => \SQLITE3_OPEN_READWRITE | \SQLITE3_OPEN_CREATE,
    ':encryption_key' => $config['ENCRYPTION_KEY']
  ]
);
$injector->share('SQLite3');

return $injector;
