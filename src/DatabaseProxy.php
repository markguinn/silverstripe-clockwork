<?php
/**
 * Wraps the real database adapter, passing on most function calls
 * and logging queries for sending along to Clockwork
 *
 * @author Mark Guinn <mark@adaircreative.com>
 * @date 11.07.2014
 * @package clockwork
 */

namespace Clockwork\Support\Silverstripe;

use SS_Database;
use DBConnector;
use DBSchemaManager;
use DBQueryBuilder;

class DatabaseProxy extends SS_Database
{
    /** @var SS_Database */
    protected $realConn;

    /** @var array */
    protected $queries;


    /**
     * @param SS_Database $realConn
     */
    public function __construct($realConn)
    {
        $this->realConn = $realConn;
        $this->connector = $this->connector ?: $realConn->getConnector();
        $this->schemaManager = $this->connector ?: $realConn->getSchemaManager();
        $this->queryBuilder = $this->connector ?: $realConn->getQueryBuilder();
        $this->queries = [];
    }

    /**
     * Get the current connector
     *
     * @return DBConnector
     */
    public function getConnector()
    {
        return $this->realConn->getConnector();
    }

    /**
     * Injector injection point for connector dependency
     *
     * @param DBConnector $connector
     */
    public function setConnector(DBConnector $connector)
    {
        parent::setConnector($connector);
        return $this->realConn->setConnector($connector);
    }

    /**
     * Returns the current schema manager
     *
     * @return DBSchemaManager
     */
    public function getSchemaManager()
    {
        return $this->realConn->getSchemaManager();
    }

    /**
     * Injector injection point for schema manager
     *
     * @param DBSchemaManager $schemaManager
     */
    public function setSchemaManager(DBSchemaManager $schemaManager)
    {
        parent::setSchemaManager($schemaManager);
        return $this->realConn->setSchemaManager($schemaManager);
    }

    /**
     * Returns the current query builder
     *
     * @return DBQueryBuilder
     */
    public function getQueryBuilder()
    {
        return $this->realConn->getQueryBuilder();
    }

    /**
     * Injector injection point for schema manager
     *
     * @param DBQueryBuilder $queryBuilder
     */
    public function setQueryBuilder(DBQueryBuilder $queryBuilder)
    {
        parent::setQueryBuilder($queryBuilder);
        return $this->realConn->setQueryBuilder($queryBuilder);
    }

    /**
     * Allows the display and benchmarking of queries as they are being run
     *
     * @param string $sql Query to run, and single parameter to callback
     * @param callable $callback Callback to execute code
     * @return mixed Result of query
     */
    protected function benchmarkQuery($sql, $callback)
    {
        $starttime = microtime(true);
        $handle = parent::benchmarkQuery($sql, $callback);
        $endtime = microtime(true);
        $this->queries[] = ['query' => $sql, 'duration' => round(($endtime - $starttime) * 1000.0, 2)];
        return $handle;
    }


    /**
     * @return array
     */
    public function getQueries()
    {
        return $this->queries;
    }


    /**
     * @param string $name
     * @param array $arguments
     * @return mixed
     */
    public function __call($name, $arguments)
    {
        return call_user_func_array([$this->realConn, $name], $arguments);
    }

    public function comparisonClause(
        $field,
        $value,
        $exact = false,
        $negate = false,
        $caseSensitive = null,
        $parameterised = false
    ) {
        return call_user_func_array([$this->realConn, __FUNCTION__], func_get_args());
    }

    public function formattedDatetimeClause($date, $format)
    {
        return call_user_func_array([$this->realConn, __FUNCTION__], func_get_args());
    }

    public function datetimeIntervalClause($date, $interval)
    {
        return call_user_func_array([$this->realConn, __FUNCTION__], func_get_args());
    }

    public function datetimeDifferenceClause($date1, $date2)
    {
        return call_user_func_array([$this->realConn, __FUNCTION__], func_get_args());
    }

    public function supportsCollations()
    {
        return call_user_func_array([$this->realConn, __FUNCTION__], func_get_args());
    }

    public function supportsTimezoneOverride()
    {
        return call_user_func_array([$this->realConn, __FUNCTION__], func_get_args());
    }

    public function getDatabaseServer()
    {
        return call_user_func_array([$this->realConn, __FUNCTION__], func_get_args());
    }

    public function searchEngine(
        $classesToSearch,
        $keywords,
        $start,
        $pageLength,
        $sortBy = "Relevance DESC",
        $extraFilter = "",
        $booleanSearch = false,
        $alternativeFileFilter = "",
        $invertedMatch = false
    ) {
        return call_user_func_array([$this->realConn, __FUNCTION__], func_get_args());
    }

    public function supportsTransactions()
    {
        return call_user_func_array([$this->realConn, __FUNCTION__], func_get_args());
    }

    public function transactionStart($transactionMode = false, $sessionCharacteristics = false)
    {
        return call_user_func_array([$this->realConn, __FUNCTION__], func_get_args());
    }

    public function transactionSavepoint($savepoint)
    {
        return call_user_func_array([$this->realConn, __FUNCTION__], func_get_args());
    }

    public function transactionRollback($savepoint = false)
    {
        return call_user_func_array([$this->realConn, __FUNCTION__], func_get_args());
    }

    public function transactionEnd($chain = false)
    {
        return call_user_func_array([$this->realConn, __FUNCTION__], func_get_args());
    }

    public function now()
    {
        return call_user_func_array([$this->realConn, __FUNCTION__], func_get_args());
    }

    public function random()
    {
        return call_user_func_array([$this->realConn, __FUNCTION__], func_get_args());
    }
}
