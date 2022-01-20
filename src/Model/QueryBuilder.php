<?php

namespace App\Model;

use App\Exception\QueryBuilderException;

/**
 * This is a simple query builder.
 * One table only; select, from, join, where, order by, group by statements allowed.
 * Not particularly user-friendly.
 */
class QueryBuilder
{
    private $statement;
    private $statementParams;
    private $params;

    public function __construct()
    {
        $this->statement = '';
        $this->params = array();
        $this->statementParams = array();
    }

    /**
     * ♪♫ It just works ♫♪
     * Does not check SQL logic.
     * @return $this
     * @throws QueryBuilderException
     */
    public function prepareStatement()
    {
        if (!isset($this->statementParams['select']) or !isset($this->statementParams['from'])) {
            throw new QueryBuilderException('Not enough parameters');
        }
        $this->statement .= 'SELECT ' . implode(', ', $this->statementParams['select']) . ' ';
        $this->statement .= 'FROM ' . $this->statementParams['from'] . ' ';
        if (isset($this->statementParams['join'])) {
            foreach ($this->statementParams['join'] as $join) {
                $this->statement .= 'JOIN ' . $join['table'] . ' ON ' . $join['condition'] . ' ';
            }
        }
        if (isset($this->statementParams['where'])) {
            $this->statement .= 'WHERE ';
            $conditions = [];
            $val_counter = 0;
            $val_name = ':v';
            foreach ($this->statementParams['where'] as $condition) {
                $str = $condition['column'] . ' ';
                if (isset($condition['operator'])) {
                    $str .= $condition['operator'] . ' ';
                    $this->params[$val_name . strval($val_counter)] = $condition['value'];
                    $str .= $val_name . $val_counter++;
                } else {
                    $str .= 'IN (' . $val_name;
                    $str .= implode(', ' . $val_name, range($val_counter, $val_counter + count($condition['values']) - 1));
                    $this->params = array_merge($this->params,
                        array_combine(substr_replace(range($val_counter, $val_counter + count($condition['values']) - 1), $val_name, 0, 0),
                            array_values($condition['values'])));
                    $val_counter += count($condition['values']);
                    $str .= ')';
                }
                $conditions[] = $str;
            }
            $this->statement .= implode(' AND ', $conditions) . ' ';
        }
        if (isset($this->statementParams['groupBy'])) {
            $this->statement .= 'GROUP BY ';
            $this->statement .= implode(', ', $this->statementParams['groupBy']) . ' ';
        }
        if (isset($this->statementParams['orderBy'])) {
            $this->statement .= 'ORDER BY ';
            $orders = array_map(function ($a1, $a2) {
                return $a1 . ' ' . $a2;
            },
                $this->statementParams['orderBy']['columns'], $this->statementParams['orderBy']['orders']);
            $this->statement .= implode(', ', $orders) . ' ';
        }
        $this->statement .= ';';
        return $this;
    }

    /**
     * @return void
     */
    public function reset()
    {
        $this->statement = '';
        $this->params = array();
        $this->statementParams = array();
    }

    /**
     * Aggregation functions are to be typed as columns are typed.
     * e.g. select('COUNT(*)', 'email')
     * @param ...$columns
     * @return $this
     */
    public function select(...$columns)
    {
        if (!isset($this->statementParams['select'])) {
            $this->statementParams['select'] = array();
        }
        foreach ($columns as $column) {
            $this->statementParams['select'][] = $column;
        }
        return $this;
    }

    /**
     * @param $table
     * @return $this
     */
    public function from($table)
    {
        $this->statementParams['from'] = $table;
        return $this;
    }

    /**
     * e.g. join('Task t', 'u.id = t.userId');
     * @param $table
     * @param $condition
     * @return $this
     */
    public function join($table, $condition)
    {
        if (!isset($this->statementParams['join'])) {
            $this->statementParams['join'] = array();
        }
        $this->statementParams['join'][] = array('table' => $table, 'condition' => $condition);
        return $this;
    }

    /**
     * If operator is =, default is "WHERE ... IN ..." mode as opposed to "WHERE ... = ..." mode.
     * Statements will be joined by "AND". No parenthesis allowed.
     * One column at the time.
     * @param $column
     * @param $values
     * @param null $operator
     * @return $this
     */
    public function where($column, $operator = '=', ...$values)
    {
        if (!isset($this->statementParams['where'])) {
            $this->statementParams['where'] = array();
        }
        if ($operator == '=') {
            $this->statementParams['where'][] = array(
                'column' => $column,
                'values' => $values
            );
        } else {
            $this->statementParams['where'][] = array(
                'column' => $column,
                'operator' => $operator,
                'value' => $values[0]
            );
        }
        return $this;
    }

    /**
     * One column at the time allowed.
     * @param $order
     * @param $column
     * @return $this
     */
    public function orderBy($column, $order)
    {
        if (!isset($this->statementParams['orderBy'])) {
            $this->statementParams['orderBy'] = array();
        }
        $this->statementParams['orderBy']['columns'][] = $column;
        $this->statementParams['orderBy']['orders'][] = $order;
        return $this;
    }

    /**
     * @param ...$columns
     * @return $this
     */
    public function groupBy(...$columns)
    {
        if (!isset($this->statementParams['groupBy'])) {
            $this->statementParams['groupBy'] = array();
        }
        foreach ($columns as $column) {
            $this->statementParams['groupBy'][] = $column;
        }
        return $this;
    }

    /**
     * @return string
     */
    public function getStatement()
    {
        return $this->statement;
    }

    /**
     * @return array
     */
    public function getParams()
    {
        return $this->params;
    }

    /**
     * @return array
     */
    public function getStatementParams()
    {
        return $this->statementParams;
    }

}