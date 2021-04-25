<?php

function isPost(): bool
{
    return strtoupper($_SERVER['REQUEST_METHOD']) === 'POST';
}

function isAjax(): bool
{
    return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && 'XMLHttpRequest' === $_SERVER['HTTP_X_REQUESTED_WITH'];
}

function escape(string $value): string
{
    return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
}

function getSecurityKey(): string
{
    $fileKey = getRandomHash(16);
    $fileName = 'key_' . $fileKey . '.txt';
    $key = getRandomHash(18);
    $securityKeyPath = STORAGE_DIR . '/security/' . $fileName;
    file_put_contents($securityKeyPath, $key);
    return $fileKey . '.' . $key;
}

function deleteSecurityKey(string $keyNamen): bool
{
    if (false === strpos($keyNamen, '.')) {
        return false;
    }
    $keyParts = explode('.', $keyNamen);
    $fileName = 'key_' . $keyParts[0] . '.txt';
    $securityKeyPath = STORAGE_DIR . '/security/' . $fileName;
    if (is_file($securityKeyPath)) {
        return unlink($securityKeyPath);
    }
    return false;
}

function createPdfFromUrl(string $srcUrl, string $targetFile): bool
{
    $securityKey = getSecurityKey();
    $publicUrl = $srcUrl . '/' . $securityKey;
    $bin = '/usr/bin/wkhtmltopdf';

    if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
        $bin = realpath(BIN_DIR . '\wkhtmltopdf.exe');
    }
    if (false === is_file($bin) && false === is_executable($bin)) {
        deleteSecurityKey($securityKey);
        logData('ERROR', 'PDF Kann nicht erzeugt werden weil Datei nicht exestiert oder nicht ausführtbar ist', [$bin]);
        return false;
    }
    $command = $bin . " " . $publicUrl . " " . $targetFile;
    $result = shell_exec($command);
    logData('INFO', 'Ergebnis aus der Generierung ' . $result, ['Command' => $command]);

    deleteSecurityKey($securityKey);

    if (is_file($targetFile)) {
        return true;
    }
    logData('ERROR', 'Erzeugte PDF konnte nicht gefunden werden');
    return false;
}

function redirectIfNotLogged(string $sourceTarget)
{
    if (isLoggedIn()) {
        return;
    }
    $_SESSION['redirectTarget'] = BASE_URL . 'index.php' . $sourceTarget;
    header("Location: " . BASE_URL . "index.php/account/login");
    exit();
}

function getRandomHash(int $length): string
{
    $randomInt = random_int(0, time());
    $hash = md5($randomInt);
    $start = random_int(0, strlen($hash) - $length);
    $hashShort = substr($hash, $start, $length);
    return $hashShort;
}

function flashMessage(?string $message = null)
{
    if (!isset($_SESSION['messages'])) {
        $_SESSION['messages'] = [];
    }
    if (!$message) {
        $messages = $_SESSION['messages'];
        $_SESSION['messages'] = [];
        return $messages;
    }
    $_SESSION['messages'][] = $message;
}

function convertToMoney(int $cent): string
{
    $money = $cent / 100;
    return number_format($money, 2, ",", " ");
}

function sendMail(Swift_Message $message): bool
{
    $transport = new Swift_SmtpTransport(SMTP_HOST, SMPT_PORT, SMTP_SSL);
    $transport->setUsername(SMTP_USERNAME);
    $transport->setPassword(SMTP_PASSWORD);

    $mailer = new Swift_Mailer($transport);
    return $mailer->send($message);
}

function logData(string $level, string $message, ?array $data = null)
{
    $today = date('Y-m-d');
    $now = date('Y-m-d H:i:s');
    if (!is_dir(LOG_DIR)) {
        mkdir(LOG_DIR, 0777, true);
    }
    $logFile = LOG_DIR . '/log-' . $today . '.log';

    $logData = '[' . $now . '-' . $level . '] ' . $message . "\n";

    if ($data) {
        $dataString = print_r($data, true) . "\n";
        $logData .= $dataString;
    }
   
    file_put_contents($logFile, $logData, FILE_APPEND);
}

function logEnd($string = '*')
{
    logData('INFO',str_repeat($string,100));
}

function normalizeFiles(array $files): array
{
    $result = [];
  
    foreach ($files as $keyName => $values) {
        foreach ($values as $index => $value) {
            $result[$index][$keyName] = $value;
        }
    }
   
    $typeToExtensionMap = [
        'image/jpeg' => 'jpg',
        'image/png' => 'png'
    ];
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    foreach ($result as $index => $file) {
        $tempPath = $file['tmp_name'];
        if(!$tempPath){
            unset($result[$index]);
            continue;
        }
        $type = finfo_file($finfo, $tempPath);
        $result[$index]['type'] = $type;
        $result[$index]['size'] = filesize($tempPath);
        if (isset($typeToExtensionMap[$type])) {
            $result[$index]['extension'] = $typeToExtensionMap[$type];
        }
    }

    return $result;
}

function router($path = null, $action = null, $methods = 'POST|GET',bool $directRequestDisabled = false) {
    static $routes = [];
    
    if(!$path){
        return $routes;
    }
    if(strpos($path, '..') !== false){
        return;
    }
    
    if ($action) {
        return $routes['(' . $methods . ')_' . $path] = [$action,$directRequestDisabled];
    }
    $originalPath = str_replace('?'.$_SERVER['QUERY_STRING'], '', $path);
    $path = $_SERVER['REQUEST_METHOD'].'_'.$originalPath;
    foreach ($routes as $route => $data) {
        list($action,$currentDirectRequestIsDisabled) = $data;
        $regEx = "~^$route/?$~i";
       
        $matches = [];
        if (!preg_match($regEx, $path, $matches)) {
            continue;
        }
        if (!is_callable($action)) {
       
            logData('WARNING','Route not found',['route'=>$path]);
            return false;
            
        }
        if($currentDirectRequestIsDisabled && $_SERVER['REQUEST_URI'] && $_SERVER['REQUEST_URI'] === $originalPath){
           
            logData('WARNING','Route not found',['route'=>$path]);
            return false;
        }
        array_shift($matches);
        array_shift($matches);
        $response = $action(...$matches);
        return $response;
    }
  
    logData('WARNING','Route not found',['route'=>$path]);
    return false;
}