<?php
/**
 * Created by PhpStorm.
 * User: justin
 * Date: 3/9/16
 * Time: 7:41 PM
 */

namespace NanoMVC\Framework\View;

use NanoMVC\Framework\Session\Session;

trait ViewTraits
{
    protected $view;
    protected $data=array("ASSET_PATH"=>ASSET_PATH); //always give view access to Assets by default


    /**
     * getRedirectBaggage
     * This method retrieves data sent to the view from a redirect.
     */
    protected function getRedirectBaggage()
    {
        $s = new Session();
        if(isset($s->nanomvc_redirect_baggage))
        {
            foreach($s->nanomvc_redirect_baggage as $k=>$v)
            {
                $this->with($k,$v);
            }
            $s->drop('nanomvc_redirect_baggage');
        }
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
}