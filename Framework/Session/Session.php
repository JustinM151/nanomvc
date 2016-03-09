<?php
/**
 * Created by PhpStorm.
 * User: justin
 * Date: 2/10/16
 * Time: 10:59 AM
 */

namespace Framework\Session;
use Framework\Errors\Exceptions\SessionException;

class Session
{
    /**
     * Session constructor.
     * @param null $autostart - pass true to automatically start your session
     */
    function __construct($autostart = null)
    {
        //One day this may not auto-stasrt... but for now it does.
        $this->startIfNotReady();
    }

    /**
     * start
     * @return bool - Alias for startIfNotReady()
     * Starts the session
     */
    public function start()
    {
        return $this->startIfNotReady();
    }

    /**
     * stop
     * @return bool
     * Destroys the session
     */
    public function stop()
    {
        $result = false; //assume the worst
        if (session_status() === PHP_SESSION_ACTIVE) {
            $result = session_destroy();
        }
        return $result;
    }

    /**
     * set
     * Sets a session variable
     * @param $key - session Variable's name
     * @param $val - Session variable's value
     * @return bool
     */
    public function set($key,$val)
    {
        if($this->startIfNotReady())
        {
            $this->{$key} = $val;
            $_SESSION[$key] = $val;
            return true;
        }
        else
        {
            return false;
        }
    }

    /**
     * safeSet
     * Sets a session var only if its empty or !isset.
     * @param $key
     * @param $val
     * @param $checkBy - "empty" or "isset"
     * @return bool
     */
    public function safeSet($key,$val, $checkBy="empty")
    {
        if($this->startIfNotReady())
        {
            if($checkBy=="empty")
            {
                if(empty($_SESSION[$key]))
                {
                    $this->{$key} = $val;
                    $_SESSION[$key] = $val;
                    return true;
                }
                else
                {
                    return false;
                }
            }
            elseif($checkBy=="isset")
            {
                if(!isset($_SESSION[$key]))
                {
                    $this->{$key} = $val;
                    $_SESSION[$key] = $val;
                    return true;
                }
                else
                {
                    return false;
                }
            }
            else
            {
                //TODO: Throw Invalid Argument Error
            }

        }
        else
        {
            return false;
        }
    }


    /**
     * get
     * Gets a session variable's value OR returns false
     * @param $name
     * @return bool
     */
    public function get($name)
    {
        if(isset($this->{$name}))
        {
            return $this->{$name};
        }
        else
        {
            return false;
        }
    }

    /**
     * drop
     * Drops a value from the session
     * @param $key
     * @return bool
     */
    public function drop($key)
    {
        if(isset($this->{$key})) {
            unset($this->{$key});
            unset($_SESSION[$key]);
            return true;
        }
        return false;
    }

    /**
     * startIfNotReady
     * Checks if the session is ready, if it isn't it tries to start it.
     * @return bool
     */
    private function startIfNotReady()
    {
        if (session_status() !== PHP_SESSION_ACTIVE)
        {
            try
            {
                $result = false; //assume the worst
                if (session_status() !== PHP_SESSION_ACTIVE)
                {
                    $result = session_start();
                }
                $this->collectSessionData();
                return $result;
            }
            catch(SessionException $ex)
            {
                return false; //Session not ready
            }
        }
        else
        {
            $this->collectSessionData();
            return true; //Session should be ready.
        }
    }

    /**
     * collectSessionData
     * When the session is started this assigns session variables to the session object's properties
     */
    private function collectSessionData()
    {
        foreach($_SESSION as $key=>$val)
        {
            $this->{$key} = $val;
        }
    }
}