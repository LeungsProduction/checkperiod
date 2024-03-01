<?php
date_default_timezone_set('Asia/Hong_Kong');

if (strpos($_SERVER['SERVER_NAME'], '127.0.0.1.xip.io') !== false) {
    // Development
    define('DATABASE_HOST', 'localhost');
    define('DATABASE_NAME', 'checkperiod');
    define('DATABASE_USERNAME', 'root');
    define('DATABASE_PASSWORD', '');

    define('SITE_URL' , 'http://127.0.0.1.xip.io/checkperiod/');
} else {
    // Live
    define('DATABASE_HOST', 'localhost');
    define('DATABASE_NAME', 'checkperiod_www');
    define('DATABASE_USERNAME', 'checkperiodwww');
    define('DATABASE_PASSWORD', 'O;3p-HiFI4 ~+D|$`[-*L`l');

    define('SITE_URL' , 'https://www.checkperiod.hk');
}
