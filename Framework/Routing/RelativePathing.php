<?php
/**
 * Created by PhpStorm.
 * User: justin
 * Date: 2/8/16
 * Time: 5:16 PM
 */
/*
 * Relativity Router - This tells the app how many relative directories up it has to go to get to the root.
 */
$parts = explode("/", trim($_SERVER['REQUEST_URI'],"/"));
$skipTheRest = false;
$relativePrefix = "";

for($x=0; $x<count($parts); $x++)
{
    if($parts[$x] == ROOT_URI)
    {
        $skipTheRest = true;
    }
    else {
        if(!$skipTheRest)
        {
            if(!$skipTheRest)
            {
                $relativePrefix .= "../";
            }
        }
    }
}
define("ASSET_PATH",str_ireplace("//","/",trim($relativePrefix.ASSET_DIR,"/")));