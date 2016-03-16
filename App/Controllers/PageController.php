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

use App\Models\User;

class PageController
{

    public function test()
    {
        $usr = new User();
        $users = $usr->where('id',1)->get();
        //dd($users);
        foreach($users as $u)
        {
            /** @var User $u */
            $parents[$u->id] = $u->Parent('Group')->get();
        }
        dd($parents);
    }

    public function index()
    {
        //NEW VIEW STYLE
        return View::make('index');
        //return $view->render();

        //OLD VIEW STYLE
        //$v = new View();
        //$v->make('index')->render();
    }

    public function redirects()
    {
        return Redirect::route('/')->with('baggage','This is my baggage!');
    }
}