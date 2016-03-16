<?php
/**
 * Created by PhpStorm.
 * User: justin
 * Date: 3/9/16
 * Time: 7:47 PM
 */

namespace Framework\View;


interface ViewInterface
{
    public function make($view);

    public function render();
}