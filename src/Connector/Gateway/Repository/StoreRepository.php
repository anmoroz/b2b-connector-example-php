<?php
/**
 * Author: Andrey Morozov
 * Date: 27.07.2016
 */

namespace Connector\Gateway\Repository;

use Connector\Gateway\Entity\Store as GatewayStore;

class StoreRepository extends GatewayRepositoryAbstarct implements ObjectRepositoryInteface
{
    /**
     * @var string
     */
    protected $tableName = 'store';

    /**
     * @param int $id
     * @return bool|GatewayProduct
     * @throws \Doctrine\DBAL\DBALException
     */
    public function findById($id)
    {
        $sql = 'SELECT * FROM '.$this->tableName.' WHERE id = '. (int) $id;
        $store = $this->connection->executeQuery($sql)->fetch();

        return $store ? $this->createGatewayObject($store) : false;
    }

    /**
     * @param int $id
     * @return bool|GatewayProduct
     * @throws \Doctrine\DBAL\DBALException
     */
    public function findByExternalId($id)
    {
        $sql = 'SELECT * FROM '.$this->tableName.' WHERE external_id = '. (int) $id;
        $store = $this->connection->executeQuery($sql)->fetch();

        return $store ? $this->createGatewayObject($store) : false;
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
     * @return GatewayProduct
     */
    protected function createGatewayObject(array $data)
    {
        $store = new GatewayStore();
        $store->setAttributes([
            'id' => $data['id'],
            'externalId' => $data['external_id'],
            'name' => $data['name'],
            'address' => $data['address'],
            'description' => $data['description'],
            'phone' => $data['phone'],
            'schedule' => $data['schedule'],
            'sort' => $data['sort'],
            'lat' => $data['sort'],
            'lng' => $data['sort'],
        ]);

        return $store;
    }

    /**
     * @return string
     */
    public function getClassName()
    {
        return GatewayStore::class;
    }
}