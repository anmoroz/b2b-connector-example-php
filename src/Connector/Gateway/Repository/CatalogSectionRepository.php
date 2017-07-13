<?php
/**
 * @copyright Copyright (c) 2011 ООО «ТриДаВинчи»
 * @author Andrey Morozov
 */

namespace Connector\Gateway\Repository;

use Connector\Gateway\Entity\CatalogSection as GatewayCatalogSection;

/**
 * Class GatewayCatalogSectionRepository
 * @package Connector\Gateway\Repository
 */
class CatalogSectionRepository extends GatewayRepositoryAbstarct implements ObjectRepositoryInteface
{
    /**
     * @var string
     */
    protected $tableName = 'catalog_section';

    /**
     * @param string $id
     *
     * @return bool|GatewayCatalogSection
     * @throws \Doctrine\DBAL\DBALException
     */
    public function findById($id)
    {
        $sql = 'SELECT * FROM ' . $this->tableName . ' WHERE id = :id';
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
            ->execute();

        while ($row = $smtp->fetch()) {
            yield $this->createGatewayObject($row);
        }
    }

    /**
     * @param array $data
     *
     * @return GatewayCatalogSection
     */
    protected function createGatewayObject(array $data)
    {
        $catalogSection = new GatewayCatalogSection();
        $catalogSection->setAttributes([
            'id' => $data['id'],
            'name' => $data['name'],
        ]);

        return $catalogSection;
    }

    /**
     * @return string
     */
    public function getClassName()
    {
        return GatewayCatalogSection::class;
    }
}
