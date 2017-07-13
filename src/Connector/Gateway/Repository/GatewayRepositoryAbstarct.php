<?php
/**
 * @copyright Copyright (c) 2011 ООО «ТриДаВинчи»
 * @author Andrey Morozov
 */

namespace Connector\Gateway\Repository;

/**
 * Class GatewayRepositoryAbstarct
 * @package Connector\Gateway\Repository
 */
abstract class GatewayRepositoryAbstarct
{
    /**
     * @var \Doctrine\DBAL\Connection
     */
    protected $connection;

    /**
     * GatewayRepositoryAbstarct constructor.
     * @param \Doctrine\DBAL\Connection $conn
     */
    public function __construct(\Doctrine\DBAL\Connection $conn)
    {
        $this->connection = $conn;
    }
}