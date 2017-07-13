<?php
/**
 * @copyright Copyright (c) 2011 ООО «ТриДаВинчи»
 * @author Andrey Morozov
 */

namespace Connector\Helper;

/**
 * This class can be used when we need to handle simulataneous requests
 * by getting lock from database
 *
 * Class Lock
 * @package Connector\Helper
 */
class Lock
{
    const GLOBAL_LOCK_NAME = 'b2b_connector_lock';

    /**
     * @var \Doctrine\DBAL\Connection
     */
    protected $connection;

    /**
     * Lock name
     * @var string
     */
    protected $name;

    /**
     * Lock constructor.
     * @param \Doctrine\DBAL\Connection $conn
     * @param string $lockName
     */
    public function __construct(\Doctrine\DBAL\Connection $conn, $lockName = self::GLOBAL_LOCK_NAME)
    {
        $this->name = str_replace('\\', '_', $lockName);
        $this->connection = $conn;
    }

    /**
     * Lock parser process
     *
     * @return boolean Returns true if the lock was obtained successfully, false if the attempt timed out or if an error occurred
     */
    public function setLock() {

        $query = "SELECT GET_LOCK(?, 10) as getLock";

        return (boolean) $this->connection
            ->fetchColumn($query, [$this->name]);
    }

    /**
     * Check parser is free
     *
     * @return boolean Returns true if the lock is free, false if the lock is in use or if an error occurs
     */
    public function isFreeLock() {

        $query = "SELECT IS_FREE_LOCK(?) as getLock";

        return (boolean) $this->connection
            ->fetchColumn($query, [$this->name]);
    }

    /**
     * Check parser is locked
     *
     * @return mixed Returns the connection identifier of the client that holds the lock. Otherwise, it returns NULL.
     */
    public function isUsedLock() {

        $query = "SELECT IS_USED_LOCK(?) as getLock";

        return $this->connection
            ->fetchColumn($query, [$this->name]);
    }

    /**
     * Unlock parser process
     *
     * @return boolean Returns true if the lock was released, false if the lock was not released.
     */
    public function unLock() {

        $query = "SELECT RELEASE_LOCK(?) as getLock";

        return (boolean) $this->connection
            ->fetchColumn($query, [$this->name]);
    }
}