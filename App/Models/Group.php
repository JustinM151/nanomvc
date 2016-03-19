<?php
/**
 * Created by PhpStorm.
 * User: justin
 * Date: 1/12/16
 * Time: 2:53 PM
 */

namespace NanoMVC\App\Models;
use NanoMVC\Framework\Model\Model;

class Group extends Model
{
    protected $table = "groups";
    protected $fields = ['id','name'];

    public function __construct($fields='n/a')
    {
        parent::__construct($fields);
        $this->owns('User');
    }

}