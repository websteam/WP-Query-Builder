<?php

namespace WPQueryBuilder;

class WhereInClause implements WhereClause
{
    private $column;
    private $value1;
    private $value2;

    public function __construct($column, $values)
    {
        $this->column = $column;
        $this->bindings = $values;
    }

    public function buildSql()
    {
        if (strtolower(substr($this->bindings[0], 0, 6)) == 'select') {
            $subquery = $this->bindings[0];

            return implode(' ', [$this->column, 'IN', "($subquery)"]);
        }

        $inList = '('.implode(', ', array_fill(0, count($this->bindings), '%s')).')';

        return implode(' ', [$this->column, 'IN', $inList]);
    }

    public function getBindings()
    {
        return $this->bindings;
    }
}
