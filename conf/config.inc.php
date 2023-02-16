<?php

/**
MySQL Settings - you can get this information from your web hosting company.
 */
define('DB_HOST', 'ultiorganizer-db-php7');
define('DB_USER', 'root');
define('DB_PASSWORD', 'abc123');
define('DB_DATABASE', 'ultiorganizer');

/**
Server Defaults.
 */
define('BASEURL', 'http://192.168.1.67:8080');
define('UPLOAD_DIR', 'images/uploads/');
define('CUSTOMIZATIONS', 'slkl');
define('DATE_FORMAT', _("%d.%m.%Y %H:%M"));
define('WORD_DELIMITER', '/([\;\,\-_\s\/\.])/');
define('ENABLE_ADMIN_DB_ACCESS', 'enabled');

date_default_timezone_set('Europe/Helsinki');