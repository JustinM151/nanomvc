<?php
/**
 * Created by PhpStorm.
 * User: justin
 * Date: 1/8/16
 * Time: 10:07 AM
 */
function class_autoloader($class) {
    $class = str_ireplace("\\","/",$class);
    include BASE_DIR .'/'. $class . '.php';
}

spl_autoload_register('class_autoloader');