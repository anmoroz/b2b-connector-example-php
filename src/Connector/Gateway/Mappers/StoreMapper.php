<?php
/**
 * @copyright Copyright (c) 2011 ООО «ТриДаВинчи»
 * @author Andrey Morozov
 */

namespace Connector\Gateway\Mappers;

use Connector\Gateway\Entity\Store;

/**
 * Class StoreMapper
 * @package Connector\Gateway\Mappers
 */
class StoreMapper extends GatewayMapperAbstract
{
    /**
     * @var string
     */
    private $tableName = 'store';

    /**
     * @param Store $store
     * @return bool
     * @throws \Doctrine\DBAL\DBALException
     */
    public function save(Store &$store)
    {
        $sql = 'INSERT INTO '.$this->tableName.' (`id`, `external_id`, `name`, `address`, `description`, `phone`, `schedule`, `sort`, `lat`, `lng`)'
            .' VALUES(:id, :external_id, :name, :address, :description, :phone, :schedule, :sort, :lat, :lng)'
            .' ON DUPLICATE KEY UPDATE name=:name, address=:address, description=:description, phone=:phone, schedule=:schedule, sort=:sort, lat=:lat, lng=:lng';

        $stmt = $this->connection->prepare($sql);
        $stmt->bindValue('id', $store->getId());
        $stmt->bindValue('external_id', $store->getExternalId());
        $stmt->bindValue('name', $store->getName());
        $stmt->bindValue('address', $store->getAddress());
        $stmt->bindValue('description', $store->getDescription());
        $stmt->bindValue('phone', $store->getPhone());
        $stmt->bindValue('schedule', $store->getSchedule());
        $stmt->bindValue('sort', $store->getSort());
        $stmt->bindValue('lat', $store->getLat());
        $stmt->bindValue('lng', $store->getLng());

        return $stmt->execute();
    }
}