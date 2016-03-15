<?php
/**
 * Created by PhpStorm.
 * User: justin
 * Date: 3/9/16
 * Time: 8:09 PM
 */

namespace Framework\View;

use Framework\Errors\Exceptions\ViewException;

class View
{
    /**
     * make
     * This is actually a factory method for our driver.
     * @param $view
     */
    public static function make($view)
    {
        try {
            if(VIEW_DRIVER) {
                $class = '\\Framework\\View\\Drivers\\'.VIEW_DRIVER.'\\'.VIEW_DRIVER;
                if(class_exists($class)) {
                    $v = new $class;
                    return $v->make($view);
                } else {
                    dd('No Class: '.$class);
                }
            } else {
                throw new ViewException("No View Driver Set");
            }
        } catch (ViewException $e) {
            //TODO: Put proper exception handling here
        }
    }
}