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

use SS_Query;
use SS_Database;

class DatabaseProxy
{
    /** @var SS_Database */
    protected $realConn;

    /** @var array */
    protected $queries;


    /**
     * @param SS_Database $realConn
     */
    public function __construct($realConn) {
        $this->realConn = $realConn;
        $this->queries = array();
    }


    /**
     * Execute the given SQL query.
     * This function must be defined by subclasses as part of the actual implementation.
     * It should return a subclass of SS_Query as the result.
     * @param string $sql     The SQL query to execute
     * @param int $errorLevel The level of error reporting to enable for the query
     * @return SS_Query
     */
    public function query($sql, $errorLevel = E_USER_ERROR) {
        $starttime = microtime(true);
        $handle = $this->realConn->query($sql, $errorLevel);
        $endtime = microtime(true);
        $this->queries[] = array('query' => $sql, 'duration' => round(($endtime - $starttime) * 1000.0, 2));
        return $handle;
    }


    /**
     * @return array
     */
    public function getQueries() {
        return $this->queries;
    }


    /**
     * @param string $name
     * @param array $arguments
     * @return mixed
     */
    public function __call($name, $arguments) {
        return call_user_func_array(array($this->realConn, $name), $arguments);
    }

}
