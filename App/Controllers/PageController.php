<?php
/**
 * Created by PhpStorm.
 * User: justin
 * Date: 1/8/16
 * Time: 10:53 AM
 */
namespace NanoMVC\App\Controllers;

use NanoMVC\App\Models\Group;
use NanoMVC\Framework\View\View;
use NanoMVC\Framework\Session\Session;
use NanoMVC\Framework\Routing\Redirect;

use NanoMVC\App\Models\User;

class PageController
{

    public function test()
    {
//        $usr = new User();
//        $users = $usr->where('id',1)->get();
//        //dd($users);
//        foreach($users as $u)
//        {
//            /** @var User $u */
//            $parents[$u->id] = $u->parents('Group')->get();
//        }
//        dd($parents);

        $grp = new Group();
        $groups = $grp->where('id',1)->get();
        foreach($groups as $g)
        {
            $children[$g->name] = $g->children('User')->get();
        }
        dd($children);
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