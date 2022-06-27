<?php
define('URL', "http://{$_SERVER['HTTP_HOST']}/");

$url_list = array(
    '103.17.21.146:8880',
);

define('CRM', "http://103.17.21.146:8880/");
define('IMPORT_ITEM_COUNT', 1);


foreach ($url_list as $key => $item) {
    if (ip2long($item)) {
        define('CRM', "http://$item/");
    }
}

define('VERSION', "2.1.1");
define('PATCH', "031620142207");
