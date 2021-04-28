<?php
function redirectMissingConfig(string $configFile)
{
    http_response_code(404);
    require_once TEMPLATES_DIR.'/errorPages/missingConfig.php';
    exit();
}