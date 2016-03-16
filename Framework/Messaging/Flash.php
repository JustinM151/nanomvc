<?php
/**
 * Created by PhpStorm.
 * User: justin
 * Date: 3/8/16
 * Time: 10:43 PM
 */

namespace Framework\Messaging;

use Framework\Session\Session;

class Flash
{
    /**
     * Message
     * Stores a message or array of message to the flash message storage object
     * which will be wiped upon rendering the next view.
     * @param $msg
     * @return bool
     */
    public static function message($msg)
    {
        $s = new Session();
        $buffer = $s->get('nanomvc_flash_msgs');

        if(is_array($msg)) {
            foreach ($msg as $m) {
                $buffer[] = $m;
            }
        } else {
            $buffer[] = $msg;
        }

        $s->set('nanomvc_flash_msgs',$buffer);
        return true;
    }

    public static function getMessages()
    {
        $s = new Session();
        $buffer = $s->get('nanomvc_flash_msgs');
        $s->drop('nanomvc_flash_msgs');
        return $buffer;
    }
}