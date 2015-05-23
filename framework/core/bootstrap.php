<?php

require_once CORE_PATH . '/classes/uri.php';
require_once CORE_PATH . '/classes/input.php';
require_once CORE_PATH . '/classes/route.php';
require_once CORE_PATH . '/classes/db.php';
require_once CORE_PATH . '/classes/controller.php';
require_once APP_PATH . '/classes/model/image.php';
require_once APP_PATH . '/classes/model/pet.php';
require_once APP_PATH . '/classes/model/user.php';
require_once APP_PATH . '/classes/model/basket.php';
require_once APP_PATH . '/classes/model/message.php';
require_once APP_PATH . '/classes/user.php';
require_once APP_PATH . '/classes/basket.php';
require_once APP_PATH . '/classes/pet.php';
require_once APP_PATH . '/classes/image.php';
require_once APP_PATH . '/classes/message.php';
require_once APP_PATH . '/classes/threadedMessage.php';

try {
    Core\Db::connect();
} catch (Exception $ex) {
    echo $ex->getMessage();
}

echo Core\Route::execute();
