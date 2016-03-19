<?php
/**
 * Created by PhpStorm.
 * User: justin
 * Date: 1/23/16
 * Time: 10:43 PM
 */

namespace NanoMVC\Framework\Errors\Exceptions;


class MiddlewareException extends ExceptionHandler
{

    public $exceptionType = "MiddlewareException";

    public function getExceptionType()
    {
        return $this->exceptionType;
    }


}