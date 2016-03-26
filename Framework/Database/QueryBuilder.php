<?php
/**
 * Created by PhpStorm.
 * User: justin
 * Date: 1/13/16
 * Time: 9:54 AM
 */

namespace NanoMVC\Framework\Database;


use NanoMVC\Framework\Errors\Errors;

class QueryBuilder
{
    protected $where = array();
    protected $order = array();
    protected $preparedWhere = array();
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


    public function count()
    {
        $limit = "";
        $where = "";
        $table = $this->table; //Exists in child class.
        if($this->where)
        {
            $where = " WHERE".$this->compileWhere();
        }

        $sql = "SELECT COUNT(*) as num FROM ".$table.$where.$limit;

        $db = new DB;
        return $db->query($sql)->fetch_object()->num;
    }


    public function orderBy($column,$direction="DESC")
    {
        $this->order[$column] = (strtoupper($direction)=="DESC" ? "DESC":"ASC");
        return $this;
    }

    public function compileOrder()
    {
        $orderStr = "";
        foreach($this->order as $k=>$v)
        {
            $orderStr .= '`'.$k.'` '.$v.',';
        }
        $orderStr = 'ORDER BY '.trim($orderStr,',');

        return $orderStr;
    }


    /**
     * Alias for get(), but only returns the first result.
     * @return \NanoMVC\Framework\Model\Model OR null
     */
    public function first()
    {
        $object = $this->get('first');
        if(isset($object)) {
            return $object;
        } else {
            return null;
        }
    }


    /**
     * Alias for get(), but only returns the last result.
     * @return \NanoMVC\Framework\Model\Model OR null
     */
    public function last()
    {
        $object = $this->get('last');
        if(isset($object)) {
            return $object;
        } else {
            return null;
        }
    }

    /**
     * Alias for get(), but only returns the first result.
     * @return \NanoMVC\Framework\Model\Model OR null
     */
    public function single($rowNum)
    {
        $object = $this->get($rowNum);
        if(isset($object)) {
            return $object;
        } else {
            return null;
        }
    }



    /**
     * get
     */
    public function get($get="all")
    {
        try {
            $limit = "";
            $where = "";
            $order = "";
            $table = $this->table; //Exists in child class.
            if($this->where) {
                $where = " WHERE".$this->compileWhere();
            }

            if($this->order) {
                $order = $this->compileOrder();
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

            $sql = "SELECT * FROM ".$table.$where.$order." ".$limit;

            $db = new DB;

            $result = null;
            $statement = $db->prepare($sql,array(\PDO::ATTR_CURSOR, \PDO::CURSOR_SCROLL));



            //dd($this->preparedWhere);
            //dd($statement);
            if($statement->execute($this->preparedWhere))
            {
                switch($get)
                {
                    case "all":
                        $result = $statement->fetchAll(\PDO::FETCH_ASSOC);
                        break;
                    case "first":
                        $result = $statement->fetchAll(\PDO::FETCH_ASSOC);
                        $result = (!empty($result[0]) ? $result[0] : null);
                        break;
                    case "last":
                        $result = $statement->fetchAll(\PDO::FETCH_ASSOC);
                        $result = (!empty(end($result)) ? end($result) : null);
                        break;
                    case is_int($get):
                        $result = $statement->fetchAll(\PDO::FETCH_ASSOC);
                        $result = (!empty($result[$get]) ? $result[$get] : null);
                        break;
                }

                $objArr = array();



                    if(is_array($result)) {
                        if($get!="all") {
                            $class = get_called_class();
                            $objArr = new $class($result);
                        } else {
                            foreach($result as $row)
                            {
                                $class = get_called_class();
                                $objArr[] = new $class($row);
                            }
                        }
                    }

                $db = null; //release connection

                dd($objArr);


                return $objArr;

            } else {
                //TODO: Add a custom exception here
                return false;
            }
        } catch (\Exception $e) {
            die(Errors::exception($e));
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
            foreach($this->where as $condition)
            {
                $wQry .= $condition['chain'].' '.'`'.$condition['column'].'` '.$condition['operator'].' :'.$condition['column'].' ';
                $this->preparedWhere[':'.$condition['column']] = $condition['value'];
            }
        }
        return $wQry;
    }


}