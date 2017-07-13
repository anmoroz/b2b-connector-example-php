<?php
/**
 * @copyright Copyright (c) 2011 ООО «ТриДаВинчи»
 * @author Andrey Morozov
 */

namespace Connector\Gateway\Mappers;

use Connector\Gateway\Entity\OrderStatus;

/**
 * Class OrderStatusMapper
 * @package Connector\Gateway\Mappers
 */
class OrderStatusMapper extends GatewayMapperAbstract
{
    /**
     * @var string
     */
    private $tableName = 'order_status';

    /**
     * @param OrderStatus $orderStatus
     * @return bool
     * @throws \Doctrine\DBAL\DBALException
     */
    public function save(OrderStatus &$orderStatus)
    {
        $sql = 'INSERT INTO '.$this->tableName.' (`id`, `external_id`, `name`)'
            .' VALUES(:id, :external_id, :name)'
            .' ON DUPLICATE KEY UPDATE name=:name';

        $stmt = $this->connection->prepare($sql);
        $stmt->bindValue('id', $orderStatus->getId());
        $stmt->bindValue('external_id', $orderStatus->getExternalId());
        $stmt->bindValue('name', $orderStatus->getName());

        return $stmt->execute();
    }
}