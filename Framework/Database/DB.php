<?php
/**
 * Created by PhpStorm.
 * User: justin
 * Date: 1/11/16
 * Time: 9:52 AM
 */

namespace NanoMVC\Framework\Database;

use \PDO;

class DB extends \PDO
{
    /**
     * DB constructor
     * @param string $name - DB Name / Name comes first so you can use default connector settings while specifying a different database.
     * @param string $host - DB Host
     * @param string $user - DB Username
     * @param string $pass - Username's Password
     */
    public function __construct($name=DB_NAME, $host=DB_HOST, $user=DB_USER, $pass=DB_PASS, $driver=DB_DRIVER)
    {
        $dsn = "";
        switch($driver)
        {
            case "mysql":
                $dsn ="$driver:host=$host;dbname=$name";
                break;
            case "sqlite":
                $dsn = "$driver:$name";
                $user = null;
                $pass = null;
                break;
        }

        try {
            parent::__construct($dsn, $user, $pass);
            $this->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        catch(\PDOException $e) {
            echo 'Connection failed: ' . $e->getMessage();
        }
    }
}