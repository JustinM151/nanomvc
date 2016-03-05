<?php
/**
 * Created by PhpStorm.
 * User: justin
 * Date: 1/23/16
 * Time: 10:43 PM
 */

namespace Framework\Errors\Exceptions;


class SessionException extends ExceptionHandler
{

    public $exceptionType = "SessionException";

    public function getExceptionType()
    {
        return $this->exceptionType;
    }


}