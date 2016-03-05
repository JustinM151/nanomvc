<?php
/**
 * Created by PhpStorm.
 * User: justin
 * Date: 1/12/16
 * Time: 10:30 AM
 */
namespace Framework\Errors;
use Framework\View\View;
class Errors
{
    public static function show($err)
    {
        $v = new View();
        $v->make('Errors/'.$err)->render();
    }

    public static function exception($e)
    {
        $v = new View();
        $v->make('Errors/exception')
            ->with('type',$e->exceptionType)
            ->with('code',$e->getCode())
            ->with('message',$e->getMessage())
            ->with('line',$e->getLine())
            ->with('file',$e->getFile())
            ->with('trace',$e->getTraceDump())
            ->render();
    }
}