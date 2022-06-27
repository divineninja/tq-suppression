<?php
// cuctom database dialer
define('DB_TYPE', 'mysql');
define('DB_HOST', 'localhost');
define('DB_NAME', 'suppression');
define('DB_USER', 'root');
define('DB_PASS', 'Admin123**!');
require('database.php');
//phpinfo();
$db = new database();
$query = new query();

if (isset($_GET['data'])) {
    if (method_exists($query, $_GET['data'])) {
        if (isset($_GET['data']) && isset($_GET['number'])) {
            $data = $query->{$_GET['data']}($_GET['number']);

            if (method_exists($query, $_GET['data'])) {
                echo 'callback_function('.json_encode(
                    array(
                        'leads' => $data,
                        'status' => 'ok',
                        'code' => 200
                    )
                ).')';
            } else {
                echo 'callback_function('.json_encode(array(
                    'status' => 'error',
                    'code' => '404',
                    'message' => 'page not found'
                )).')';
            }
        } else {
            echo 'callback_function('.json_encode(array(
                'status' => 'error',
                'code' => '404',
                'message' => 'page not found'
            )).')';
        }
    } else {
        echo 'callback_function('.json_encode(array(
            'status' => 'error',
            'code' => '404',
            'message' => 'page not found'
            )).')';
    }
}
