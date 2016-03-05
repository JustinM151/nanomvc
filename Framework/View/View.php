<?php
/**
 * Created by PhpStorm.
 * User: justin
 * Date: 1/8/16
 * Time: 10:58 AM
 */
namespace Framework\View;

use Framework\Session\Session;

class View
{
    private $view;
    private $data=array("ASSET_PATH"=>ASSET_PATH); //always give view access to assets by default

    /**
     * View constructor.
     */
    public function __construct()
    {
        $s = new Session();
        if(isset($s->redirect_baggage))
        {
            foreach($s->redirect_baggage as $k=>$v)
            {
                $this->with($k,$v);
            }
            unset($s->redirect_baggage);
        }
        return $this;
    }

    /**
     * make
     * Makes a view from a provided twig file
     * @param $view
     * @return $this
     */
    public function make($view)
    {
        $file = str_ireplace(".twig","",$view).".twig";
        $this->view = $file;
        return $this;
    }

    /**
     * with
     * Passes data to the view
     * @param $key
     * @param $val
     * @return $this
     */
    public function with($key,$val)
    {
        $this->data[$key] = $val;
        return $this;
    }


    /**
     * withArr
     * Expanded an array to key->value pairs and passes them to the view
     * @param $arr
     * @return $this
     */
    public function withArr($arr)
    {
        foreach($arr as $key=>$val)
        {
            $this->data[$key] = $val;
        }

        return $this;
    }


    /**
     * render
     * renders the view.
     */
    public function render()
    {

        /*
         * Configure Twig Environment
         */
        $loader = new \Twig_Loader_Filesystem(VIEWS);
        $twig = new \Twig_Environment($loader);

        echo $twig->render($this->view, $this->data);
        exit;
    }

}