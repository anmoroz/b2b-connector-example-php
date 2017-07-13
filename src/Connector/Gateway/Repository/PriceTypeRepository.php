<?php
/**
 * @copyright Copyright (c) 2011 ООО «ТриДаВинчи»
 * @author Andrey Morozov
 */

namespace Connector\Gateway\Repository;

use Connector\Gateway\Entity\PriceType as GatewayPriceType;

/**
 * Class GatewayPriceTypeRepository
 * @package Connector\Gateway\Repository
 */
class PriceTypeRepository extends GatewayRepositoryAbstarct implements ObjectRepositoryInteface
{
    /**
     * @var string
     */
    protected $tableName = 'price_type';

    /**
     * @param int $id
     *
     * @return bool|GatewayProduct
     * @throws \Doctrine\DBAL\DBALException
     */
    public function findById($id)
    {
        $sql = 'SELECT * FROM '.$this->tableName.' WHERE id = '. (int) $id;
        $priceType = $this->connection->executeQuery($sql)->fetch();

        return $priceType ? $this->createGatewayObject($priceType) : false;
    }

    /**
     * @param int $id
     *
     * @return bool|GatewayPriceType
     * @throws \Doctrine\DBAL\DBALException
     */
    public function findByExternalId($id)
    {
        $sql = 'SELECT * FROM '.$this->tableName.' WHERE external_id = '. (int) $id;
        $priceType = $this->connection->executeQuery($sql)->fetch();

        return $priceType ? $this->createGatewayObject($priceType) : false;
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
     * @return GatewayPriceType
     */
    protected function createGatewayObject(array $data)
    {
        $store = new GatewayPriceType();
        $store->setAttributes([
            'id' => $data['id'],
            'externalId' => $data['external_id'],
            'name' => $data['name'],
        ]);

        return $store;
    }

    /**
     * @return string
     */
    public function getClassName()
    {
        return GatewayPriceType::class;
    }
}