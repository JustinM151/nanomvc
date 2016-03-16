<?php
/**
 * Created by PhpStorm.
 * User: justin
 * Date: 1/24/16
 * Time: 9:17 AM
 */

namespace Framework\Errors;

/*
 * Framework Error Handler
 */
//set_error_handler('error_handler');

/*
 * Framework Exception Handler
 */
set_exception_handler(
    function($e)
    {
        Errors::exception($e);
    }
);
