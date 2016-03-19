<?php
/**
 * Created by PhpStorm.
 * User: justin
 * Date: 1/4/16
 * Time: 2:32 PM
 */

namespace App;

use NanoMVC\Framework\Routing\Router;
$router = new Router;

$router->get('/','PageController@index');

$router->get('/test','PageController@test');

$router->get('/redirect','PageController@redirects');

$router->get('/closure/{var1}/{var2}',function($x,$y){
    echo $x." AND ".$y;
});

//Uses closure
$router->get('/phpinfo',['uses'=>function() {
    phpinfo();
}]);

$router->get('/uses',['uses'=>'PageController@index', 'middleware'=>'Authenticate']);

$router->get('/custom/{val1}/{val2}','PageController@index');

$router->post('/poster',function() {
   dd("In /poster!");
});

//End of the line, nothing will get past the examine method.
$router->examine();