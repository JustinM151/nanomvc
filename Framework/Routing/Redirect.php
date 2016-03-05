<?php
/**
 * Created by PhpStorm.
 * User: justin
 * Date: 3/4/16
 * Time: 8:36 PM
 */

namespace Framework\Routing;

use Framework\Session\Session;

class Redirect
{
    /**
     * Redirect constructor.
     * @param $type
     * @param $location
     */
    public function __construct($type,$location)
    {
        if($type == "route")
        {
            $this->location = ROOT_URI.$location;
        }
        else
        {
            $this->location = $location;
        }
        return $this;
    }


    /**
     * route
     * Factory Method for redirecting to a route
     * @param $uri
     * @return mixed
     */
    public static function route($uri)
    {
        $route = new self('route',$uri);
        return $route;
    }

    /**
     * url
     * Factory method for redirecting to a URL
     * @param $url
     * @return mixed
     */
    public static function url($url)
    {
        $route = new self('url',$url);
        return $route;
    }

    /**
     * with
     * Send some baggage to the next route
     * @param $key
     * @param $val
     */
    public function with($key,$val)
    {
        $s = new Session();
        $baggage = $s->get('redirect_baggage');
        $baggage[$key] = $val;
        $s->set('redirect_baggage',$baggage);
        return $this;
    }

    /**
     * go
     * This method executes the redirect
     */
    public function go()
    {
        header('location: '.$this->location);
        exit;
    }

}