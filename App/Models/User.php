<?php
/**
 * Created by PhpStorm.
 * User: justin
 * Date: 1/12/16
 * Time: 2:53 PM
 */

namespace NanoMVC\App\Models;
use NanoMVC\Framework\Model\Model;

class User extends Model
{
    protected $table = "users";
    protected $fields = ['id','username','password','first_name','last_name','group_id'];

    public function __construct($fields='n/a')
    {
        parent::__construct($fields);
        $this->belongsTo('Group');
    }

}