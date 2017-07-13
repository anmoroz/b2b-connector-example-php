<?php
/**
 * @copyright Copyright (c) 2011 ООО «ТриДаВинчи»
 * @author Andrey Morozov
 */

namespace Connector\Gateway\Repository;

use Connector\Gateway\Entity\OrderStatus as GatewayOrderStatus;

/**
 * Class GatewayOrderStatusRepository
 * @package Connector\Gateway\Repository
 */
class OrderStatusRepository extends GatewayRepositoryAbstarct implements ObjectRepositoryInteface
{
    /**
     * @var string
     */
    protected $tableName = 'order_status';

    /**
     * @param int $id
     *
     * @return bool|GatewayOrderStatus
     * @throws \Doctrine\DBAL\DBALException
     */
    public function findByExternalId($id)
    {
        $sql = 'SELECT * FROM ' . $this->tableName . ' WHERE external_id = ' . (int)$id;
        $orderStatus = $this->connection->executeQuery($sql)->fetch();

        return $orderStatus ? $this->createGatewayObject($orderStatus) : false;
    }

    /**
     * @return \Generator|int
     */
    public function iterate()
    {
        $stores = $this->connection->createQueryBuilder()
            ->select('*')
            ->from($this->tableName)
            ->execute()
            ->fetchAll()
        ;

        foreach ($stores as $row) {
            yield $this->createGatewayObject($row);
        }
    }

    /**
     * @param array $data
     *
     * @return GatewayOrderStatus
     */
    protected function createGatewayObject(array $data)
    {
        $orderStatus = new GatewayOrderStatus();
        $orderStatus->setAttributes([
            'id' => $data['id'],
            'externalId' => $data['external_id'],
            'name' => $data['name'],
        ]);

        return $orderStatus;
    }

    /**
     * @return string
     */
    public function getClassName()
    {
        return GatewayOrderStatus::class;
    }
}