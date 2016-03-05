<?php
/**
 * Created by PhpStorm.
 * User: justin
 * Date: 1/8/16
 * Time: 10:53 AM
 */
namespace App\Controllers;

use Framework\View\View;
use Framework\Session\Session;
use Framework\Routing\Redirect;

class PageController
{

    public function test()
    {
        $s = new Session();
        $s->start();
        $s->set("Name","John Doe");
        $s->set("Age",89);
        $s->safeSet("Age",23);

        echo $s->Name;
        echo "<br />";
        echo $s->Age;
        echo "<br />";
        dd($s);
    }

    public function index()
    {
        $v = new View();
        $v->make('index')->render();
    }

    public function redirects()
    {
        Redirect::route('/')->with('baggage','This is my baggage!')->go();
    }
}