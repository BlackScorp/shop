<?php

if(false === isAdmin()){
    echo "Ungültiger Zugriff";
    exit();
}

require_once TEMPLATES_DIR.'/newProduct.php';