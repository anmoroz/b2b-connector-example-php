<?php
/**
 * @copyright Copyright (c) 2011 ООО «ТриДаВинчи»
 * @author Andrey Morozov
 */

namespace Connector\Gateway\Repository;

use Connector\Gateway\Entity\Brand as GatewayBrand;

/**
 * Class GatewayBrandRepository
 * @package Connector\Gateway\Repository
 */
class BrandRepository extends GatewayRepositoryAbstarct implements ObjectRepositoryInteface
{
    /**
     * @var string
     */
    protected $tableName = 'brand';

    /**
     * @param string $id
     *
     * @return bool|GatewayBrand
     * @throws \Doctrine\DBAL\DBALException
     */
    public function findById($id)
    {
        $sql = 'SELECT * FROM '.$this->tableName.' WHERE id = :id';
        $row = $this->connection
            ->executeQuery($sql, [':id' => $id])
            ->fetch();

        return $row ? $this->createGatewayObject($row) : false;
    }

    /**
     * @return \Generator|int
     */
    public function iterate()
    {
        $smtp = $this->connection->createQueryBuilder()
            ->select('*')
            ->from($this->tableName)
            ->execute()
        ;

        while ($row = $smtp->fetch()) {
            yield $this->createGatewayObject($row);
        }
    }

    /**
     * @param array $data
     *
     * @return GatewayBrand
     */
    protected function createGatewayObject(array $data)
    {
        $brand = new GatewayBrand();
        $brand->setAttributes([
            'id' => $data['id'],
            'name' => $data['name'],
        ]);

        return $brand;
    }

    /**
     * @return string
     */
    public function getClassName()
    {
        return GatewayBrand::class;
    }
}