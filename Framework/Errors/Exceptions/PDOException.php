<?php
/**
 * Created by PhpStorm.
 * User: justin
 * Date: 1/23/16
 * Time: 10:43 PM
 */

namespace NanoMVC\Framework\Errors\Exceptions;


class PDOException extends ExceptionHandler
{

    public $exceptionType = "PDOException";

    public function getExceptionType()
    {
        return $this->exceptionType;
    }


}