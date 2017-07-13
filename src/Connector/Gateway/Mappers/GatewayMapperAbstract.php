<?php
/**
 * @copyright Copyright (c) 2011 ООО «ТриДаВинчи»
 * @author Andrey Morozov
 */

namespace Connector\Gateway\Mappers;

/**
 * Class GatewayMapperAbstract
 * @package Connector\Gateway\Mappers
 */
abstract class GatewayMapperAbstract
{
    /**
     * @var \Doctrine\DBAL\Connection
     */
    protected $connection;

    public function __construct(\Doctrine\DBAL\Connection $connection)
    {
        $this->connection = $connection;
    }

    /**
     * @return \Doctrine\DBAL\Connection
     */
    public function getConnection()
    {
        return $this->connection;
    }

    protected function id2camel($id, $separator = '_')
    {
        return str_replace(' ', '', ucwords(str_replace($separator, ' ', $id)));
    }
}