<?php
/**
 * Created by PhpStorm.
 * User: justin
 * Date: 1/12/16
 * Time: 3:04 PM
 */

namespace Framework\Model;
use Framework\Database\DB;
use Framework\Database\QueryBuilder;

class Model extends QueryBuilder
{
    protected $table = "";
    protected $primaryKey = "id";
    protected $returnedID = false;

    protected $fillable = array(); //fields that can be filled by a user submitted form
    protected $restricted = array(); //fields that can't be sent to fill a form (password etc)
    protected $fields = array(); //all table columns

    public function __construct($arr="n/a")
    {
        if(is_array($arr))
        {
            foreach($arr as $k=>$v)
            {
                $this->{$k} = $v;
            }
        }
        return $this;
    }

    public function toArray()
    {
        $objProps = get_object_vars($this);
        $out = array();
        foreach($objProps as $k=>$v) {
            if(in_array($k,$this->fields))
            {
                $out[$k] = $v;
            }
        }
        return $out;
    }

    public function save()
    {
        //We will eventually need the database class
        $db = new DB;

        $objProps = get_object_vars($this);
        $set = "";
        foreach($objProps as $k=>$v)
        {
            if(in_array($k,$this->fields))
            {
                $set .= "`$k`='$v',";
            }
        }
        if(!empty($set))
        {
            $set = trim($set,",");
        } else {
            return false;
        }

        if($this->returnedID == false)
        {
            //This is a new/unsaved object - Do Insert!
            $sql = "INSERT INTO $this->table SET $set";
            $db->query($sql);
            $this->returnedID = $db->insert_id;
            $this->{$this->primaryKey} = $this->returnedID;
            return $this;
        } else
        {
            //We have an ID, do update!
            $sql = "UPDATE $this->table SET $set WHERE `$this->primaryKey` = '{$this->returnedID}'";
            $db->query($sql);
            $this->returnedID = $this->{$this->primaryKey};
            return $this;
        }
    }
}