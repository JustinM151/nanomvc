<?php
/**
 * Created by PhpStorm.
 * User: justin
 * Date: 1/14/16
 * Time: 11:43 AM
 */
namespace Framework\Authenticate;

use Framework\Database\DB;
use Framework\Session\Session;

class Authenticate
{

    public static function check()
    {
        $s = new Session();
        $return = (!empty($s->user) ? true:false);
        return $return;
    }


    public static function make($int)
    {
        $s = new Session();
        $s->set('user',$int);
    }

    public static function user()
    {
        $s = new Session();
        $return = (isset($s->user) ? $s->user:false);
        return $return;
    }

    public static function login($email,$pass)
    {
        //TODO: Login Logic Goes Here
    }

    public static function logout()
    {
        $s = new Session();
        $s->stop();
        return true;
    }
}