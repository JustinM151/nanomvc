<?php
/**
 * Created by PhpStorm.
 * User: justin
 * Date: 1/4/16
 * Time: 11:59 AM
 */
/*
 * Set us up for AZ time baby!
 */
date_default_timezone_set('America/Phoenix');

/*
 * Set our current environment, local or production
 */
$env = "production";

/*
 * Are we in debug mode?
 */
define("DEBUG", true);

/*
 * Main Database Credentials
 */
switch($env)
{
    case "local":
        //DB Connection
        define("DB_HOST","localhost");
        define("DB_USER","root");
        define("DB_PASS","localpass");
        define("DB_NAME","reps");
        break;
    case "production":
        define("DB_HOST","db.host.com");
        define("DB_USER","dbuser");
        define("DB_PASS","dbpassword");
        define("DB_NAME","database_name");
        break;
    default:
        die("No environment set");
}

/*
 * ROOT URI (Only change if you are installing longhorn in a subdirectory e.g. example.com/myapp)
 */
define("ROOT_URI","/");


/*
 * Define Base Directory
 */
define("BASE_DIR",__DIR__);

/*
 * Define App Dir
 */
define("APP_DIR",BASE_DIR.'/App');

/*
 * Define Framework Path
 */
define("FRAMEWORK",BASE_DIR.'/Framework');

/*
 * Define Views Path
 */
define("VIEWS",BASE_DIR.'/Resources/Views');

/*
 * Public Asset Directory
 */
define("ASSET_DIR",ROOT_URI.'/Resources/Public/Assets');