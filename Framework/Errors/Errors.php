<?php
/**
 * Created by PhpStorm.
 * User: justin
 * Date: 1/12/16
 * Time: 10:30 AM
 */
namespace NanoMVC\Framework\Errors;
use NanoMVC\Framework\View\View;
class Errors
{
    public static function show($err)
    {
        return View::make('Errors/'.$err)->render();
    }

    public static function exception($e)
    {
        return View::make('Errors/exception')
            ->with('code',$e->getCode())
            ->with('message',$e->getMessage())
            ->with('line',$e->getLine())
            ->with('file',$e->getFile())
            ->render();
    }
}