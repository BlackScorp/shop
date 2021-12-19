<?php

$urlParts = parse_url($_SERVER['REQUEST_URI']);
$url = $urlParts['path'];
$https = $_SERVER['REQUEST_SCHEME'] === 'https';


$indexPHPPosition = strpos($url, 'index.php');
$baseUrl = $url;
logData('INFO', 'Starte Routing');
if (false !== $indexPHPPosition) {
    $baseUrl = substr($baseUrl, 0, $indexPHPPosition);
    logData('INFO', 'Es gibt eine index.php in URL');
}

if (substr($baseUrl, -1) !== '/') {
    logData('INFO', 'Die $baseUrl variable hat kein slash am Ende, hänge eins an');
    $baseUrl .= '/';
}
define('BASE_URL', $baseUrl);
$projectUrl = $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] . $baseUrl;


$route = null;
if (false !== $indexPHPPosition) {
    logData('INFO', 'index.php steht in der URL, entferne es aus der Route');
    $route = substr($url, $indexPHPPosition);
    $route = str_replace('index.php', '', $route);
}
if (!$route) {
    $route = '/';
}


$userId = getCurrentUserId();

$countCartItems = countProductsInCart($userId);
$isEmail = false;
router('/404', function () use ($userId, $baseUrl, $isEmail, $countCartItems) {
    http_response_code(404);
    require_once TEMPLATES_DIR . '/404.php';
    logEnd();
});

router('/account/activate/(\S+)/(\S+)', function (string $username, string $activationKey) use ($userId, $baseUrl, $isEmail, $countCartItems) {
    logData('INFO', 'Wir sind auf der URL /account/activate');
    require_once __DIR__ . '/actions/account.activate.php';
    logEnd();
}, 'GET');

router('/activationMail/(\S+)', function ($username) use ($userId, $baseUrl, $projectUrl, $isEmail, $countCartItems) {
    logData('INFO', 'Wir sind auf der URL /activationMail');
    require_once __DIR__ . '/actions/activationMail.php';
    logEnd();
}, 'GET');



router('/checkout', function () use ($userId, $baseUrl, $isEmail, $countCartItems) {
    logData('INFO', 'Wir sind auf der URL /checkout');
    require_once __DIR__ . '/actions/checkout.php';
    logEnd();
}, 'GET');



router('/logout', function () use ($userId, $baseUrl, $isEmail, $countCartItems) {
    logData('INFO', 'Wir sind auf der URL /logout');
    require_once __DIR__ . '/actions/logout.php';
    logEnd();
}, 'GET');

router('/selectDeliveryAddress/(\d+)', function ($deliveryAddressId) use ($userId, $baseUrl, $isEmail, $countCartItems) {
    logData('INFO', 'Wir sind auf der URL /selectDeliveryAddress');
    require_once __DIR__ . '/actions/selectDeliveryAddress.php';
    logEnd();
}, 'GET');

router('/deliveryAddress/add', function () use ($userId, $baseUrl, $isEmail, $countCartItems) {
    logData('INFO', 'Wir sind auf der URL /deliveryAddress/add');
    require_once __DIR__ . '/actions/deliveryAddress.add.php';
    logEnd();
});

router('/selectPayment', function () use ($userId, $baseUrl, $isEmail, $countCartItems) {
    logData('INFO', 'Wir sind auf der URL /selectPayment');
    require_once __DIR__ . '/actions/selectPayment.php';
    logEnd();
});

router('/paymentComplete', function () use ($userId, $baseUrl, $isEmail, $countCartItems) {
    logData('INFO', 'Wir sind auf der URL /paymentComplete');
    require_once __DIR__ . '/actions/paymentComplete.php';
    logEnd();
}, 'GET');

router('/completeOrder', function () use ($userId, $baseUrl, $projectUrl, $isEmail, $countCartItems) {
    logData('INFO', 'Wir sind auf der URL /completeOrder');
    require_once __DIR__ . '/actions/completeOrder.php';
    logEnd();
});

router('/invoice/(\d+)(/\S+)?', function (int $invoiceId, string $securityKeyString = null) use ($userId, $baseUrl, $isEmail, $countCartItems) {
    logData('INFO', 'Wir sind auf der URL /invoice');
    require_once __DIR__ . '/actions/invoice.php';
    logEnd();
}, 'GET');


router('/product/new', function () use ($userId, $baseUrl, $isEmail, $countCartItems) {
    logData('INFO', 'Wir sind auf der URL /product/new');
    require_once __DIR__ . '/actions/product.new.php';
    logEnd();
});

router('/product/edit/(\S+)', function (string $slug) use ($userId, $baseUrl, $isEmail, $countCartItems) {
    logData('INFO', 'Wir sind auf der URL /product/edit');
    require_once __DIR__ . '/actions/product.edit.php';
    logEnd();
});
router('/product/image/select/(\S+)/(\S+)', function (string $slug, string $fileName) use ($userId, $baseUrl, $isEmail, $countCartItems) {
    logData('INFO', 'Wir sind auf der URL /product/image/select');
    require_once __DIR__ . '/actions/product.image.select.php';
    logEnd();
}, 'GET');

router('/product/image/(\S+)/(\S+)', function (string $slug, string $fileName) use ($userId, $baseUrl, $isEmail, $countCartItems) {
    logData('INFO', 'Wir sind auf der URL /product/image');
    require_once __DIR__ . '/actions/product.image.php';
    logEnd();
}, 'GET');

router('/product/(\S+)', function (string $slug) use ($userId, $baseUrl, $isEmail, $countCartItems) {
    logData('INFO', 'Wir sind auf der URL /product');
    require_once __DIR__ . '/actions/product.php';
    logEnd();
}, 'GET');

router('/category/new/(\S+)/(\d+)', function (string $slug, int $categoryId) use ($userId, $baseUrl, $isEmail, $countCartItems) {
    logData('INFO', 'Wir sind auf der URL /category/new');
    require_once __DIR__ . '/actions/category.new.php';
    logEnd();
});


router('/category/delete', function (string $slug, int $categoryId) use ($userId, $baseUrl, $isEmail, $countCartItems) {
    logData('INFO', 'Wir sind auf der URL /category/delete');
    require_once __DIR__ . '/actions/category.delete.real.php';
    logEnd();
}, 'POST');

router('/categoryDelete/cancel', function () use ($userId, $baseUrl, $isEmail, $countCartItems) {
    logData('INFO', 'Wir sind auf der URL /categoryDelete/cancel');
    require_once __DIR__ . '/actions/category.delete.cancel.php';
    logEnd();
}, 'GET');

router('/categoryDelete/(\d+)/(\S+)', function (int $categoryId, string $slug)  use ($userId, $baseUrl, $isEmail, $countCartItems) {
    logData('INFO', 'Wir sind auf der URL /categoryDelete');
    require_once __DIR__ . '/actions/category.delete.php';
    logEnd();
}, 'GET');

router('/category/assign/(\S+)/(\d+)', function (string $slug, int $categoryId)  use ($userId, $baseUrl, $isEmail, $countCartItems) {
    logData('INFO', 'Wir sind auf der URL /category/assign');
    require_once __DIR__ . '/actions/category.assign.php';
    logEnd();
}, 'GET');

router('/dashboard', function () use ($userId, $baseUrl, $isEmail, $countCartItems) {
    logData('INFO', 'Wir sind auf der URL /dashboard');
    require_once __DIR__ . '/actions/dashboard.php';
    logEnd();
}, 'GET');

router('/orders/details/(\d+)', function (int $orderId)  use ($userId, $baseUrl, $isEmail, $countCartItems) {
    logData('INFO', 'Wir sind auf der URL /orders/details');
    require_once __DIR__ . '/actions/orders.details.php';
    logEnd();
}, 'GET');

router('/orders', function () use ($userId, $baseUrl, $isEmail, $countCartItems) {
    logData('INFO', 'Wir sind auf der URL /orders');
    require_once __DIR__ . '/actions/orders.php';
    logEnd();
}, 'GET');

router('/orders/changeStatus', function () use ($userId, $baseUrl, $isEmail, $countCartItems) {
    logData('INFO', 'Wir sind auf der URL /orders/changeStatus');
    require_once __DIR__ . '/actions/order.changeStatus.php';
    logEnd();
}, 'POST');

router('/reviews/(\S+)', function (string $slug) use ($userId, $baseUrl, $isEmail, $countCartItems) {
    logData('INFO', 'Wir sind auf der URL /reviews');
    require_once __DIR__ . '/actions/reviews.php';
    logEnd();
});

router('/404', function () use ($userId, $baseUrl, $isEmail, $countCartItems) {
    http_response_code(404);
    require_once TEMPLATES_DIR . '/404.php';
    logEnd();
});


router('/(\w+)?(/\w+)?(/\w+)?', function (string $controller = 'index', string $action = '/index', ?string $parameter = null) use ($userId, $baseUrl, $projectUrl, $isEmail, $countCartItems){
    if ($parameter !== null &&  strpos($parameter, '/') === 0) {
        $parameter = substr($parameter, 1);
    }
    $route = $controller . $action . '/' . $parameter;

    logData('INFO', 'Wir sind auf der Seite: ' . $route);
    $fileName = ACTIONS_DIR .'/'.$controller . $action . '.php';
    $templateFile = TEMPLATES_DIR .'/'. $controller . $action . '.php';
    $errorFilename = TEMPLATES_DIR.'/error.php';
    if (false === is_file($fileName)) {
        return router('/404');
    }
    $result = require_once $fileName;
    if (false === $result) {
        logData('ERROR',$error);
        $errorPage = require_once $errorFilename;
        logEnd();
        return $errorPage;
    }
    if (false === is_file($templateFile)) {

        $error = 'Template '.$templateFile.' not found';
        logData('ERROR',$error);
        $errorPage = require_once $errorFilename;
        logEnd();
        return $errorPage;
    }
    require_once $templateFile;
    logEnd();
});




$content = router($route);

if (false === $content) {
    echo router('/404');
    return;
}
echo $content;
