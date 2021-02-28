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
    logData('INFO','Die $baseUrl variable hat kein slash am Ende, hänge eins an');
    $baseUrl .= '/';
}
define('BASE_URL', $baseUrl);
$projectUrl = $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] . $baseUrl;

$route = null;

if (false !== $indexPHPPosition) {
    logData('INFO','index.php steht in der URL, entferne es aus der Route');
    $route = substr($url, $indexPHPPosition);
    $route = str_replace('index.php', '', $route);
}


$userId = getCurrentUserId();
$countCartItems = countProductsInCart($userId);
$isEmail = false;

if (!$route) {
    logData('INFO','Wir sind auf der Startseite');
    require_once __DIR__ . '/actions/index.php';
    logEnd();
    exit();
}

$routeParts = explode('/', $route);
logData('INFO','Wir haben mehrere Routeparts',$routeParts);
if (strpos($route, '/cart/add/') !== false) {
    logData('INFO','Wir sind auf der URL /cart/add');
    require_once __DIR__ . '/actions/cart.add.php';
    logEnd();
    exit();
}
if (strpos($route, '/cart') !== false) {
    logData('INFO','Wir sind auf der URL /cart');
    require_once __DIR__ . '/actions/cart.php';
    logEnd();
    exit();
}
if (strpos($route, '/login') !== false) {
    logData('INFO','Wir sind auf der URL /login');
    require_once __DIR__ . '/actions/login.php';
    logEnd();
    exit();
}
if (strpos($route, '/checkout') !== false) {
    logData('INFO','Wir sind auf der URL /checkout');
    require_once __DIR__ . '/actions/checkout.php';
    logEnd();
    exit();
}

if (strpos($route, '/logout') !== false) {
    logData('INFO','Wir sind auf der URL /logout');
    require_once __DIR__ . '/actions/logout.php';
    logEnd();
    exit();
}
if (strpos($route, '/selectDeliveryAddress') !== false) {
    logData('INFO','Wir sind auf der URL /selectDeliveryAddress');
    require_once __DIR__ . '/actions/selectDeliveryAddress.php';
    logEnd();
    exit();
}
if (strpos($route, '/deliveryAddress/add') !== false) {
    logData('INFO','Wir sind auf der URL /deliveryAddress/add');
    require_once __DIR__ . '/actions/deliveryAddress.add.php';
    logEnd();
    exit();
}

if (strpos($route, '/selectPayment') !== false) {
    logData('INFO','Wir sind auf der URL /selectPayment');
    require_once __DIR__ . '/actions/selectPayment.php';
    logEnd();
    exit();
}

if (strpos($route, '/paymentComplete') !== false) {
    logData('INFO','Wir sind auf der URL /paymentComplete');
    require_once __DIR__ . '/actions/paymentComplete.php';
    logEnd();
    exit();
}

if (strpos($route, '/completeOrder') !== false) {
    logData('INFO','Wir sind auf der URL /completeOrder');
    require_once __DIR__ . '/actions/completeOrder.php';
    logEnd();
    exit();
}
if (strpos($route, '/register') !== false) {
    logData('INFO','Wir sind auf der URL /register');
    require_once __DIR__ . '/actions/register.php';
    logEnd();
    exit();
}

if (strpos($route, '/invoice') !== false) {
    logData('INFO','Wir sind auf der URL /invoice');
    require_once __DIR__ . '/actions/invoice.php';
    logEnd();
    exit();
}

if (strpos($route, '/account/activate') !== false) {
    logData('INFO','Wir sind auf der URL /account/activate');
    require_once __DIR__ . '/actions/account.activate.php';
    logEnd();
    exit();
}

if (strpos($route, '/activationMail') !== false) {
    logData('INFO','Wir sind auf der URL /activationMail');
    require_once __DIR__ . '/actions/activationMail.php';
    logEnd();
    exit();
}
if (strpos($route, '/product/new') !== false) {
    logData('INFO','Wir sind auf der URL /product/new');
    require_once __DIR__ . '/actions/product.new.php';
    logEnd();
    exit();
}
if (strpos($route, '/product/edit') !== false) {
    logData('INFO','Wir sind auf der URL /product/edit');
    require_once __DIR__ . '/actions/product.edit.php';
    logEnd();
    exit();
}
if (strpos($route, '/product/image/select') !== false) {
    logData('INFO','Wir sind auf der URL /product/image/select');
    require_once __DIR__ . '/actions/product.image.select.php';
    logEnd();
    exit();
}
if (strpos($route, '/product/image') !== false) {
    logData('INFO','Wir sind auf der URL /product/image');
    require_once __DIR__ . '/actions/product.image.php';
    logEnd();
    exit();
}
if (strpos($route, '/product') !== false) {
    logData('INFO','Wir sind auf der URL /product');
    require_once __DIR__ . '/actions/product.php';
    logEnd();
    exit();
}
if (strpos($route, '/category/new') !== false) {
    logData('INFO','Wir sind auf der URL /category/new');
    require_once __DIR__ . '/actions/category.new.php';
    logEnd();
    exit();
}
if (strpos($route, '/category/delete') !== false) {
    logData('INFO','Wir sind auf der URL /category/delete');
    require_once __DIR__ . '/actions/category.delete.real.php';
    logEnd();
    exit();
}

if (strpos($route, '/categoryDelete/cancel') !== false) {
    logData('INFO','Wir sind auf der URL /categoryDelete/cancel');
    require_once __DIR__ . '/actions/category.delete.cancel.php';
    logEnd();
    exit();
}
if (strpos($route, '/categoryDelete') !== false) {
    logData('INFO','Wir sind auf der URL /categoryDelete');
    require_once __DIR__ . '/actions/category.delete.php';
    logEnd();
    exit();
}
if (strpos($route, '/category/assign') !== false) {
    logData('INFO','Wir sind auf der URL /category/assign');
    require_once __DIR__ . '/actions/category.assign.php';
    logEnd();
    exit();
}

if (strpos($route, '/dashboard') !== false) {
    logData('INFO','Wir sind auf der URL /dashboard');
    require_once __DIR__ . '/actions/dashboard.php';
    logEnd();
    exit();
}

logData('WARNING','URL wurde nicht gefunden',['route'=>$route]);
http_response_code(404);
require_once TEMPLATES_DIR.'/404.php';
logEnd();