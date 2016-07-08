<?php

namespace Core\Base\Database;

use Core\Base\Database\OrmBuilder;

class Processor
{
    /**
     * Process the results of a "select" query.
     *
     * @param  OrmBuilder  $query
     * @param  array  $results
     * @return array
     */
    public function processSelect(OrmBuilder $query, $results)
    {
        return $results;
    }

    /**
     * Process an  "insert get ID" query.
     *
     * @param  OrmBuilder  $query
     * @param  string  $sql
     * @param  array   $values
     * @param  string  $sequence
     * @return int
     */
    public function processInsertGetId(OrmBuilder $query, $sql, $values, $sequence = null)
    {
        $query->getConnection()->statement($sql, $values);

        $id = $query->getConnection()->getPdo($sql)->lastInsertId($sequence);

        return is_numeric($id) ? (int) $id : $id;
    }

    /**
     * Process the results of a column listing query.
     *
     * @param  array  $results
     * @return array
     */
    public function processColumnListing($results)
    {
        $mapping = function ($r) {
            $r = (object) $r;

            return $r->column_name;
        };

        return array_map($mapping, $results);
    }
}
