<?php
/**
 * Created by PhpStorm.
 * User: justin
 * Date: 2/9/16
 * Time: 11:49 AM
 */

namespace App\Middleware;


interface Middleware
{
    public static function run($params=NULL);
}