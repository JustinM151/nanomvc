<?php
/**
 * Created by PhpStorm.
 * User: justin
 * Date: 1/22/16
 * Time: 9:12 PM
 *
 * Nabbed this bit of code from php.net
 */

namespace NanoMVC\Framework\Errors\Exceptions;

interface IException
{
    /* Protected methods inherited from Exception class */
    public function getMessage();                 // Exception message
    public function getCode();                    // User-defined Exception code
    public function getFile();                    // Source filename
    public function getLine();                    // Source line
    public function getTrace();                   // An array of the backtrace()
    public function getTraceAsString();           // Formated string of trace

    /* Overrideable methods inherited from Exception class */
    public function __toString();                 // formated string for display
    public function __construct($message = null, $code = 0);
}
