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
    protected $parent = array();
    protected $child = array();


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


    protected function belongsTo($modelName,$localCol = '_nanoXYZ_',$parentCol= "id")
    {
        if($localCol=='_nanoXYZ_') {
            $localCol = strtolower($modelName)."_id";
        }

        $model = "\\App\\Models\\".$modelName;
        if(class_exists($model)) {
            $this->parent[$modelName] = ['parentColumn'=>$parentCol, 'localColumn'=>$localCol, 'class'=>$model];
            return true;
        } else {
            return false;
        }
    }

    protected function owns($modelName, $childCol = '_nanoXYZ_', $localCol = "id")
    {
        if($childCol=='_nanoXYZ_') {
            $reflection = new \ReflectionClass($this);
            $childCol = strtolower($reflection->getShortName())."_id";
        }

        $model = "\\App\\Models\\".$modelName;
        if(class_exists($model)) {
            $this->child[$modelName] = ['childColumn'=>$childCol, 'localColumn'=>$localCol, 'class'=>$model];
            return true;
        } else {
            return false;
        }
    }

    public function parents($modelName)
    {
        if(is_array($this->parent[$modelName]))
        {
            $parentData = $this->parent[$modelName];
            $parentObject = new $parentData['class'];
            /** @var Model $parentObject */
            //dd($parentObject);
            $parents = $parentObject->where($parentData['parentColumn'],$this->{$parentData['localColumn']});
            return $parents;
        } else {
            return false;
        }
    }

    public function children($modelName)
    {
        if(is_array($this->child[$modelName]))
        {
            $childData = $this->child[$modelName];
            $childObject = new $childData['class'];
            /** @var Model $childObject */
            //dd($parentObject);
            $children = $childObject->where($childData['childColumn'],$this->{$childData['localColumn']});
            //dd($children);
            return $children;
        } else {
            return false;
        }
    }


}