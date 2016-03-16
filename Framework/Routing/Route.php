<?php
/**
 * Created by PhpStorm.
 * User: justin
 * Date: 1/22/16
 * Time: 7:43 PM
 */

namespace Framework\Routing;


class Route
{

    private $requestType;       //Request Type (GET,POST,PUT,PATCH,DELETE)
    private $path;              //The Route's URI (/path/to/endpoint)
    private $handlerType;       //The type of handler the route uses to execute (Closure or Controller)
    private $handler;           //The handler that executes the route.
    private $middleware;        //Middleware object that gets called before the handler can execute
    private $middlewareParams;  //Parameters to send to the middleware object.


    /**
     * setRequest - Sets the request type for the route
     * @param $type
     */
    public function setRequest($type)
    {
        $this->requestType = $type;
        return $this;
    }

    public function getRequest()
    {
        return $this->requestType;
    }


    /**
     * setPath - Sets the path of the route
     * @param $path
     */
    public function setPath($path)
    {
        $this->path = $path;
        return $this;
    }


    /**
     * setHandlerType - Sets the type of handler that executes the route
     * @param $type
     */
    public function setHandlerType($type)
    {
        $this->handlerType = $type;
        return $this;
    }

    public function getHandlerType()
    {
        return $this->handlerType;
    }


    /**
     * setHandler - Sets the callable handler for the route
     * @param $handler
     */
    public function setHandler($handler)
    {
        $this->handler = $handler;
        return $this;
    }

    public function getHandler()
    {
        return $this->handler;
    }

    /**
     * setMiddleware - Sets the middleware object that gets called before the handler.
     * @param $middleware
     */
    public function setMiddleware($middleware)
    {
        $buffer = explode("|",$middleware,2);
        $middleware = $buffer[0];
        $params = (!empty($buffer[1]) ? explode("|",$buffer[1]) : false);

        $this->middleware = $middleware;
        $this->middlewareParams = $params;
        return $this;
    }


    /**
     * setMiddlewareParam - Sets the parameters for the middleware
     * @param $params
     */
    public function setMiddlewareParams($params)
    {
        $this->middlewareParams = $params;
        return $this;
    }

    public function getMiddleware()
    {
        return $this->middleware;
    }

    public function getMiddlewareParams()
    {
        return $this->middlewareParams;
    }

    public function setOptions($options)
    {

        if(!is_array($options))
        {
            //Single Option
            if(is_callable($options))
            {
                $this->setHandlerType("closure");
                $this->setHandler($options);
            } else
            {
                $this->setHandlerType("controller");
                $this->setHandler($options);
            }
        } else
        {
            foreach($options as $k=>$v)
            {
                switch($k)
                {
                    case "uses":
                        //specifies a route uses a controller or closure
                        $this->setOptions($v); //recurse into method to assign the option
                        break;

                    case "middleware":
                        //indicates route requires middleware
                        $this->setMiddleware($v); //set up the middleware
                        break;
                }
            }
        }
        return $this;
    }



    public function compileRoute()
    {
        $uri = $_SERVER['REQUEST_URI'];
        if(strpos($uri,"?"))
        {
            $uri = substr($uri,0,strpos($uri,"?"));
        }
        $uri = trim($uri,"/");

        $route = trim($this->path,"/");

        $routeParts = explode("/",$route);
        $uriParts = explode("/",$uri);

        $pattern = '/{(?P<var>\w+)}/';
        $rArr = array();

        $rVars = array();

        foreach($routeParts as $p)
        {
            preg_match($pattern,$p,$out);
            if(!empty($out))
            {
                $rArr[] = array('node'=>$p, 'match'=>'%var%', 'value'=>$out['var']);
                unset($out);
            } else {
                $rArr[] = array('node'=>$p, 'match'=>'exact', 'value'=>$p);
            }
        }

        if(count($rArr) == count($uriParts))
        {
            for($x=0; $x<count($rArr); $x++)
            {
                if($rArr[$x]['match']=='exact' && ($rArr[$x]['value'] != $uriParts[$x]))
                {
                    return false;
                }
                if($rArr[$x]['match']=='%var%')
                {
                    $rVars[$rArr[$x]['value']] = $uriParts[$x];
                }
            }
            if(!empty($rVars))
            {
                return $rVars;
            } else
            {
                return true;
            }

        } else
        {
            return false;
        }
    }

}



