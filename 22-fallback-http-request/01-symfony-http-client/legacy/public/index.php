<?php

$pageName = $url = strtok($_SERVER["REQUEST_URI"], '?');

$pageFilename = __DIR__ . '/pages/' . $pageName . '.php';

if (!file_exists($pageFilename)) {
    http_response_code(404);
    echo 'Not found';
    exit();
}

require $pageFilename;