<?php
/**
 * Created by PhpStorm.
 * User: justin
 * Date: 1/4/16
 * Time: 11:21 AM
 */

/*
 * Initial Config
 */
require_once 'config.php';

if(DEBUG)
{
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(-1);
}

/*
 * Error and Exception Handling
 */
require_once(FRAMEWORK.'/Errors/handlers.php');

/*
 * Helper Functions
 */
require_once FRAMEWORK.'/helpers.php';


require_once FRAMEWORK.'/Routing/RelativePathing.php';
//dd(ASSET_PATH);
//dd(str_ireplace("//","/",$relativePrefix.ASSET_PATH));

/*
 * Composer Autoloader
 */
require_once BASE_DIR . '/Vendor/autoload.php';

require_once FRAMEWORK . '/ClassLoader.php';

require_once(APP_DIR . '/routes.php');