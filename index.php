<?php
session_start();
error_reporting(-1);
ini_set('display_errors', 'On');

define('CONFIG_DIR', __DIR__ . '/config');
define('LOG_DIR', __DIR__ . '/logs');
define('ASSETS_DIR', __DIR__ . '/assets');
define('TEMPLATES_DIR', __DIR__ . '/templates');
define('STORAGE_DIR', __DIR__ . '/storage');
define('BIN_DIR', __DIR__ . '/bin');
define('ACTIONS_DIR',__DIR__.'/actions');
require __DIR__ . '/includes.php';