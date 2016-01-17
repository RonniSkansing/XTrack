<?php
require __DIR__.'/../vendor/autoload.php';
$config = require __DIR__.'/../application/config.php';

// Arya sets debug to TRUE be default
define('DEBUG', $config['DEBUG']);

require __DIR__.'/bootstrap.php';
