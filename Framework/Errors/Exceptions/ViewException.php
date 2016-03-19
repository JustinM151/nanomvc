<?php
/**
 * Created by PhpStorm.
 * User: justin
 * Date: 1/23/16
 * Time: 10:43 PM
 */

namespace NanoMVC\Framework\Errors\Exceptions;


class ViewException extends ExceptionHandler
{

    public $exceptionType = "ViewException";

    public function getExceptionType()
    {
        return $this->exceptionType;
    }


}