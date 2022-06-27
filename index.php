<?php
session_start();
require 'config/paths.php';
require 'config/database.php';


spl_autoload_register(function ($class_name) {
    $file = "libs/$class_name.php";
    if (file_exists($file)) {
        require "libs/" . $class_name . ".php";
    }
});


// function __autoload($class) {
//     $file = "libs/$class.php";
//     if (file_exists($file)) {
//         require "libs/" . $class . ".php";
//     }
// }

$navigation = new Navigation;

$app = new Bootstrap();
