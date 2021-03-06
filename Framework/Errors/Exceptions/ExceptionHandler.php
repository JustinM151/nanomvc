<?php
/**
 * Created by PhpStorm.
 * User: justin
 * Date: 1/22/16
 * Time: 9:03 PM
 */

namespace NanoMVC\Framework\Errors\Exceptions;



abstract class ExceptionHandler extends \Exception implements IException
{
    protected $message = 'Unknown exception';     // Exception message
    private   $string;                            // Unknown
    protected $code    = 0;                       // User-defined exception code
    protected $file;                              // Source filename of exception
    protected $line;                              // Source line of exception
    private   $trace;                             // Unknown

    public function __construct($message = null, $code = 0)
    {
        if (!$message) {
            throw new $this('Unknown '. get_class($this));
        }
        parent::__construct($message, $code);
    }

    public function __toString()
    {
        return get_class($this) . " '{$this->message}' in {$this->file}({$this->line})\n"
        . "{$this->getTraceAsString()}";
    }

    public function getTraceDump()
    {
        $arr = array();
        foreach($this->getTrace() as $trace)
        {
            $arr[] = print_r($trace,1);
        }
        return $arr;
    }

}