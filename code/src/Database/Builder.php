<?php

namespace App\Database;

use App\Container;
use Exception;

trait Builder
{
    protected $_select;

    protected $_query;

    protected $_stmt;

    protected $_table;

    protected $_columns;

    protected $_binds = [];

    protected $_where = [];

    public function __construct() 
    {
        $this->init();
    }

    protected function init()
    {
        $this->_query = "SELECT {$this->columns()} FROM {$this->table()} ";
    }

    public function columns(array $columns = [])
    {
        if (!$this->_columns) {
            $this->_columns = !empty($columns) ? $columns : '*';
        }
        return $this->_columns;
    }

    public function table()
    {
        return $this->_table ?? '*';
    }

    public function where(string $attribute, string $op = '=', $value)
    {
        $where = "%s %s :%s";
        $this->_where['and'][] = [
            'clause' => sprintf($where, $attribute, $op, $attribute),
            'bind' => [":$attribute" => $value]
        ];
        return $this;
    }

    public function andWhere(string $attribute, string $op = '=', $value)
    {
        $this->where($attribute, $op, $value);
        return $this;
    }

    public function get()
    {
        if ($this->_where) {
            $where = $this->prepareWhere();
            $this->_query .= $where;
        }

        $this->fetch();
    }

    public function fetch()
    {
        try {
            $pdo = Container::getInstance()->get('db');
            
            $stmt = $pdo->prepare($this->_query);
            $stmt->execute($this->_binds);

            $result = $stmt->fetch(\PDO::FETCH_ASSOC);

            if ($result) {
                $this->addData($result);
            }
        } catch (Exception $e) {
            var_dump($e->getMessage());
        }
    }

    protected function addData($result)
    {
        foreach ($result as $attribute => $value) {
            $this->$attribute = $value;
        }
    }

    protected function collectionModels($result)
    {

    }

    protected function prepareWhere()
    {
        $where = '';
        $binds = [];
            
        $where .= $this->prepareWhereClause('and');
        $binds = array_merge($binds, $this->prepareWhereBind('and'));

        $where .= $this->prepareWhereClause('or');
        $binds = array_merge($binds, $this->prepareWhereBind('or'));

        $this->_binds = array_merge($this->_binds, $binds);

        return "WHERE $where";
    }

    protected function prepareWhereClause(string $type = 'and')
    {
        return implode(" $type ", array_map(function ($_where) {
            return $_where['clause'];
        }, $this->_where[$type] ?? []));
    } 

    protected function prepareWhereBind(string $type = 'and')
    {
        $binds = [];
        foreach ($this->_where[$type] ?? [] as $_where) {
            $bind = $_where['bind'];
            $column = key($bind);
            $binds[$column] = $bind[$column];
        }
        return $binds;
    }
}