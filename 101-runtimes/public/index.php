<?php

use App\ReactPHPApplication;

require_once dirname(__DIR__).'/vendor/autoload_runtime.php';

return function (array $context, string $codely) {
    return new ReactPHPApplication($codely);
};
