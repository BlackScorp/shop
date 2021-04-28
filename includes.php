<?php

require_once __DIR__ . '/function/404.php';

require_once CONFIG_DIR . '/companyData.php';

if (!file_exists(CONFIG_DIR . '/mail.php')) {
    redirectMissingConfig('config/mail.php');
}
require_once CONFIG_DIR . '/mail.php';

require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/function/utilities.php';

logData('INFO','Include alle notwendigen Dateien für den Script');

require_once __DIR__ . '/function/database.php';
require_once __DIR__ . '/function/cart.php';
require_once __DIR__ . '/function/user.php';
require_once __DIR__ . '/function/product.php';
require_once __DIR__ . '/function/deliveryAddresses.php';
require_once __DIR__ . '/function/paypal.php';
require_once __DIR__ . '/function/orders.php';
require_once __DIR__ . '/function/category.php';
require_once __DIR__ . '/function/reviews.php';
require_once __DIR__ . '/routes.php';
