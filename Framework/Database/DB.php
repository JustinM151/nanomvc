<?php
/**
 * Created by PhpStorm.
 * User: justin
 * Date: 1/11/16
 * Time: 9:52 AM
 */

namespace Framework\Database;

class DB extends \mysqli
{
    /**
     * DB constructor
     * @param string $name - DB Name / Name comes first so you can use default connector settings while specifying a different database.
     * @param string $host - DB Host
     * @param string $user - DB Username
     * @param string $pass - Username's Password
     */
    public function __construct($name=DB_NAME, $host=DB_HOST, $user=DB_USER, $pass=DB_PASS)
    {
        parent::__construct($host, $user, $pass, $name);
    }
}