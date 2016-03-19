<?php
/**
 * Created by PhpStorm.
 * User: justin
 * Date: 1/14/16
 * Time: 12:28 PM
 */

namespace NanoMVC\App\Controllers;
use NanoMVC\Framework\Requests\Request;
use NanoMVC\Framework\View;
use NanoMVC\Framework\Authenticate\Authenticate;
use NanoMVC\Framework\Routing\Redirect;

class AuthController
{
    public function index()
    {
        $v = new View();
        $v->make('login')->render();
    }

    public function login()
    {
        $request = new Request();
        $creds = $request->post();
        if(!empty($creds['pass']) && !empty($creds['email']))
        {
            //TODO: Your login stuff bruh
        } else {
            $v = new View();
            $v->make('login')->with('errors',['Invalid Email and/or Password'])->render();
        }
    }

    public function logout()
    {
        Authenticate::logout();
        Redirect::route('/auth/login')->go();
    }

    public function forgotPass()
    {
       //TODO: Some sort of forgot password stuff
    }
}