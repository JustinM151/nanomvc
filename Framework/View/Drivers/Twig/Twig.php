<?php
/**
 * Created by PhpStorm.
 * User: justin
 * Date: 1/8/16
 * Time: 10:58 AM
 */
namespace Framework\View\Drivers\Twig;

use Framework\Session\Session;
use Framework\View\ViewTraits;
use Framework\View\ViewInterface;

class Twig implements ViewInterface
{
    use ViewTraits;
    /**
     * Twig constructor.
     * Get Baggage from redirects
     */
    public function __construct()
    {
        $this->getRedirectBaggage();
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
     * render
     * renders the view. (Returns HTML, or whatever the view generates)
     */
    public function render()
    {

        /*
         * Configure Twig Environment
         */
        $loader = new \Twig_Loader_Filesystem(VIEWS);
        $twig = new \Twig_Environment($loader);

        return $twig->render($this->view, $this->data);
    }

}