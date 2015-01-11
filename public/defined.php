<?php
/**
 * Created by PhpStorm.
 * user: Jason Nguyen
 * Date: 2/20/14
 * Time: 2:15 PM
 */

define('DS', DIRECTORY_SEPARATOR);
define('DEBUG_MODE', true);
define('CRLF', chr(13).chr(10));

define("ROOT_PATH", dirname(dirname(dirname(__FILE__))));
define("CORE_PATH", ROOT_PATH . DS . "core");
define("APP_PATH", ROOT_PATH . DS . "backend");
define("ASSETS_PATH", APP_PATH . DS . "public");
define("LIB_PATH", APP_PATH . DS . "library");

//define('BACK_SITE_URL', 'http://admincp.tamtay.local/');
define('BACK_SITE_URL', 'http://prj.dt/');
define('COOKIE_DOMAIN', '.tamtay.local');

define('KEY_PREFIX', DEBUG_MODE ? 'mpp-test:' : 'mpp:');
define('SCHEMA_CACHE_ENABLE', false);
define('SCHEMA_CACHE_DURATION', 86400000);
define("DEFAULT_LOCALE_CODE", "en_US");


//
define("USER_PER_PAGE", 10);

