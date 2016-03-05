<?php
/**
 * Created by PhpStorm.
 * User: justin
 * Date: 1/23/16
 * Time: 10:43 PM
 */

namespace Framework\Errors\Exceptions;


class RouteException extends ExceptionHandler
{

    public $exceptionType = "RouterException";

    public function getExceptionType()
    {
        return $this->exceptionType;
    }


}