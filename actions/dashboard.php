<?php
if(!isAdmin()){
    echo 'Kein Zugriff';
    exit();
}


require_once TEMPLATES_DIR.'/dashboard.php';