<?php

ini_set('error_reporting', E_ALL);
ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);

require __DIR__.'/app/autoload.php';

new Autoload();

new Core();

