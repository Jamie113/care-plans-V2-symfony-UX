<?php

// Serve static files directly; route everything else through Symfony
$path = $_SERVER['DOCUMENT_ROOT'] . $_SERVER['REQUEST_URI'];

if (is_file($path)) {
    return false;
}

require __DIR__ . '/index.php';
