<?php
use Arya\Application;


date_default_timezone_set(ini_get('date.timezone') ?: 'UTC');

if (!defined('DEBUG')) {
    define('DEBUG', TRUE);
}

if(DEBUG) {
  error_reporting(E_ALL | E_STRICT);
} else {
  // @todo no error reportings

}

/**
 * Parse errors cannot be handled inside the same file where they originate.
 * For this reason we have to include the application file externally here
 * so that our shutdown function can handle E_PARSE.
 */
register_shutdown_function(function() {
    $fatals = [
        E_ERROR,
        E_PARSE,
        E_USER_ERROR,
        E_CORE_ERROR,
        E_CORE_WARNING,
        E_COMPILE_ERROR,
        E_COMPILE_WARNING
    ];

    $lastError = error_get_last();

    if ($lastError && in_array($lastError['type'], $fatals)) {
        if (headers_sent()) {
            return;
        }

        header_remove();
        header("HTTP/1.0 500 Internal Server Error");

        if (DEBUG) {
            extract($lastError);
            $msg = sprintf("Fatal error: %s in %s on line %d", $message, $file, $line);
        } else {
            $msg = "Oops! Something went terribly wrong :(";
        }

        $msg = "<pre style=\"color:red;\">{$msg}</pre>";

        echo "<html><body><h1>500 Internal Server Error</h1><hr/>{$msg}</body></html>";
    }
});

$injector = require __DIR__.'/bindings.php';

$app = new Application($injector);
foreach(
  $routes = require __DIR__.'/routes/routes.php'
  as list($method, $uri, $action)
) {
  $app->route($method, $uri, $action);
}

$app->run();
