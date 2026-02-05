<?php

declare(strict_types=1);

require_once __DIR__ . '/../includes/functions.php';
$config = require __DIR__ . '/../config/config.php';
$siteName = $config['site']['name'];
$mainPages = pages();
