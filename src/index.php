<?php

require 'db_cfg.php';
$routes = require 'routes.php';

spl_autoload_register(
    static function ($class) {
        require str_replace('\\', '/', $class) . '.php';
    }
);

(new App\Api($routes))->run();
