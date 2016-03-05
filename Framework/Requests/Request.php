<?php

/**
 * Created by PhpStorm.
 * User: justin
 * Date: 1/14/16
 * Time: 1:56 PM
 */
namespace Framework\Requests;

class Request
{
    private $get;
    private $post;
    private $cookie;

    public function __construct()
    {
        if(!empty($_GET))
        {
            $this->get = $_GET;
        }

        if(!empty($_POST))
        {
            $this->post = $_POST;
        }

        if(!empty($_COOKIE))
        {
            $this->cookie = $_COOKIE;
        }
    }

    public function get()
    {
        if($this->get)
        {
            return $this->get;
        } else {
            return false;
        }
    }

    public function post()
    {
        if($this->post)
        {
            return $this->post;
        } else {
            return false;
        }
    }

    public function cookie()
    {
        if($this->cookie)
        {
            return $this->cookie;
        } else {
            return false;
        }
    }
}