<?php
/**
 * Created by PhpStorm.
 * User: justin
 * Date: 1/21/16
 * Time: 9:12 PM
 */

namespace Framework\Routing;

use Framework\Errors\Errors;
use Framework\Errors\Exceptions\MiddlewareException;
use Framework\Errors\Exceptions\RouteException;
use App\Middleware;
class Router
{
    /**
     * @var array
     * Stores defined route objects for given request types
     */
    private $routes = array();
    private $uriPrefix = ROOT_URI;


    /**
     * get - define a route available to GET requests
     * @param $path
     * @param $options
     * @return $this
     */
    public function get($path,$options)
    {
        $route = new Route;
        $this->routes[] = $route->setRequest("GET")->setPath($this->uriPrefix.$path)->setOptions($options);
        return $this;
    }


    /**
     * post - define a route available to POST requests
     * @param $path
     * @param $options
     * @return $this
     */
    public function post($path,$options)
    {
        $route = new Route;
        $this->routes[] = $route->setRequest("POST")->setPath($this->uriPrefix.$path)->setOptions($options);
        return $this;
    }



    /**
     * examine
     * After all of the routes have been defined the examine method will examine the current request and compare it to
     * the routes array. If it finds a match it will call the execute method for that route.
     */
    public function examine()
    {
        //dd($this->routes);
        //get the request type and make sure its uppercase, because yelling is fun.
        $requestType = strtoupper($_SERVER['REQUEST_METHOD']);

        foreach ($this->routes as $route) {
            /* @var $route Route */
            //first and foremost we have to make sure we are examining a route for this request type.
            if($route->getRequest() == $requestType)
            {
                //ok cool, we got our foot in the door, now lets see if there's an open seat at the bar.
                $result = $route->compileRoute();
                //Does the route match the URI?
                if($result)
                {
                    //We have a match, were there custom values?
                    if(is_array($result))
                    {
                        //there were, lets be sure they get sent to the method.
                        $this->execute($route,$result);

                    } else {
                        //no route variables, proceed as normal.
                        $this->execute($route);
                    }
                }
            }
        }
        //If we make it here there were no matching routes... toss out a 404 error
        Errors::show(404);
    }


    /**
     * @param $route
     * @param null $vars
     */
    private function execute(Route $route,$vars=NULL)
    {
        //Middleware needs to come first.
        if($mw = $route->getMiddleWare())
        {
            $class = "App\\Middleware\\$mw\\$mw";
            if(class_exists($class))
            {
                $params = $route->getMiddlewareParams();
                if(is_array($params))
                {
                    $class::run($params);
                }
                else
                {
                    $middlewareObject = new $class();
                }
            }
            else
            {
                //Go home middleware, you're drunk
                throw new MiddlewareException("Middleware Class Not Found");
            }
        }

        //Lets see what this route uses as its handler...
        switch($route->getHandlerType())
        {
            case "controller":
                //lets go down the controller path
                $buffer = explode("@",$route->getHandler(),2); //separate our class from our method
                $class = "App\\Controllers\\".$buffer[0]; //Set our controller class
                //does the class exist?
                if(class_exists($class))
                {
                    try{
                        $method = $buffer[1]; //Set our method
                        $controller = new $class(); //Instantiate our object
                        if(method_exists($controller,$method)){
                            if(is_array($vars))
                            {
                                //call the controllers method passing in the route variables as arguments
                                call_user_func_array(array($controller, $method), $vars);
                            } else {
                                $controller->$method();
                            }
                            exit; //Hard stop, just in case the method doesn't exit.
                        } else {
                            throw new RouteException("Missing Controller Method", 102);
                            //dd("Controller or Method Error!!!");
                        }
                        //dd($controller);
                        //$controller->$buffer[0]();
                    } catch(RouteException $e) {
                        Errors::exception($e);
                    }
                } else {
                    throw new RouteException("Missing Controller Class", 101);
                }
                break;
            case "closure":
                //Lets return the closure.
                $func = $route->getHandler();
                //dd($vars);
                if($vars)
                {
                    //call the closure function passing in the route variables as arguments
                    call_user_func_array($func,$vars);
                    exit;
                } else {
                    $func();
                    exit;
                }
                //We exit after calling the closure because we don't want to hit a 404 if the closure doesn't exit when its done.
                break;
        }
        
        //dd($arr);
    }

}