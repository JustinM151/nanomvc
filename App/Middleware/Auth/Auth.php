<?php
/**
 * Created by PhpStorm.
 * User: justin
 * Date: 2/9/16
 * Time: 10:35 AM
 */

namespace NanoMVC\App\Middleware\Auth;
use NanoMVC\App\Middleware\Middleware;
use NanoMVC\Framework\Routing\Redirect;
use NanoMVC\Framework\Authenticate\Authenticate;

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
            Redirect::route("/auth/login")->with('The page you requested requires you to be logged in.');
        }
        else {
            return true;
        }
    }
}