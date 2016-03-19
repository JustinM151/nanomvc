<?php
/**
 * Created by PhpStorm.
 * User: justin
 * Date: 1/13/16
 * Time: 9:54 AM
 */

namespace NanoMVC\Framework\Database;


class QueryBuilder
{
    protected $where = array();
    protected $limit = 0;
    protected $start = 0;

    /**
     * @param $column
     * @param null $operator
     * @param null $value
     * @param string $chain
     * @return $this|bool
     */
    public function where($column, $operator=null, $value=null, $chain="AND")
    {
        $numArgs = func_num_args();
        if($numArgs==2) {
            $value = $operator;
            $operator = "=";
            if(empty($this->where))
            {
                $chain = "";
            }

            $this->where[] = array("chain"=>$chain, "column"=>$column, "operator"=>$operator, "value"=>$value);

            return $this;
        }

        if($numArgs>2) {
            //custom operator or orWhere
            if(is_null($value))
            {
                $value = $operator;
                $operator = "=";
            }

            if(empty($this->where))
            {
                $chain = "";
            }

            $this->where[] = array("chain"=>$chain, "column"=>$column, "operator"=>$operator, "value"=>$value);

            return $this;
        }

        //TODO: Throw an Exception here later.
        return false;
    }

    /**
     * @param $column
     * @param null $operator
     * @param null $value
     * @return $this|bool|QueryBuilder
     */
    public function orWhere($column, $operator = null, $value = null)
    {
        return $this->where($column, $operator, $value, 'OR');
    }

    /**
     * @param int $x
     * @return $this
     */
    public function limitTo($x)
    {
        if(is_int($x))
        {
            $this->limit = $x;
            return $this;
        }

        //TODO: Throw new exception
        return false;
    }


    /**
     * @param $x
     * @return $this|bool
     */
    public function startAt($x)
    {
        if(is_int($x))
        {
            $this->start = $x;
            return $this;
        }

        //TODO: Throw new exception
        return false;
    }


    /**
     * get
     */
    public function get($as="obj")
    {
        $limit = "";
        $where = "";
        $table = $this->table; //Exists in child class.
        if($this->where)
        {
            $where = " WHERE".$this->compileWhere();
        }

        if($this->limit>0 || $this->start>0)
        {
            if($this->start > 0 && $this->limit==0)
            {
                $limit = "LIMIT ".$this->start.',18446744073709551615'; //Crazy large limit number to pull all rows from starting point per MySQL docs http://dev.mysql.com/doc/refman/5.7/en/select.html
            } else
            {
                $limit = "LIMIT ".$this->start.','.$this->limit;
            }

        }

        $sql = "SELECT * FROM ".$table.$where.$limit;

        $db = new DB;
        $result = $db->query($sql);
        if($result)
        {
            $objArr = array();
            while($row = $result->fetch_assoc())
            {
                $class = get_called_class();
                $objArr[] = new $class($row);

            }
            return $objArr;
        } else {
            //TODO: Add a custom exception here
            return false;
        }

    }


    /**
     * @return string
     */
    private function compileWhere()
    {
        $wQry = "";
        if(!empty($this->where))
        {
            $db = new DB;
            foreach($this->where as $condition)
            {
                $wQry .= $condition['chain'].' '.'`'.$db->real_escape_string($condition['column']).'` '.$condition['operator'].' \''.$db->real_escape_string($condition['value']).'\''.' ';
            }
            $db->close();
        }
        return $wQry;
    }


}