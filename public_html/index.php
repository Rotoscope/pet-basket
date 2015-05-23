<?php

session_start();
require_once __DIR__ . '/user.php';
define('CORE_PATH', __DIR__ . '/../framework/core');
define('APP_PATH', __DIR__ . '/../framework/app');
define('VIEWS_PATH', __DIR__ . '/../framework/app/views');
define('MEDIA_PATH', __DIR__ . '/../media');
define('UPLOAD_PATH', '/home/media');
define('GROUP_UPLOAD_PATH', __DIR__ . '/../../s15g03/media');
define('LOG_PATH', APP_PATH . '/logs');
define('DOC_PATH', __DIR__);

// Properly belong in app config, will move after vertical prototype
define('SITE_TITLE', 'PetBasket');

require_once CORE_PATH . '/bootstrap.php';

