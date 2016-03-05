<?php
/**
 * Created by PhpStorm.
 * User: justin
 * Date: 2/9/16
 * Time: 10:35 AM
 */

namespace App\Middleware\Auth;
use App\Middleware\Middleware;
use Framework\Routing\Route;
use Framework\Authenticate\Authenticate;

class Auth implements Middleware
{
    public static function run($params = NULL)
    {
        $auth = false; //guilty until proven innocent

        if($params)
        {
            //special operations with params sent
        }
        else
        {
            //special operations if no params sent
        }


        //Check Authentication
        if(Authenticate::check())
        {
            $auth=true;
        }


        if(!$auth)
        {
            Route::redirect("/auth/login");
        }
        else {
            return true;
        }
    }
}