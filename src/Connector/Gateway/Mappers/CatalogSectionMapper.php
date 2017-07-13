<?php
/**
 * @copyright Copyright (c) 2011 ООО «ТриДаВинчи»
 * @author Andrey Morozov
 */

namespace Connector\Gateway\Mappers;

use Connector\Gateway\Entity\CatalogSection;

/**
 * Class CatalogSectionMapper
 * @package Connector\Gateway\Mappers
 */
class CatalogSectionMapper extends GatewayMapperAbstract
{
    /**
     * @var string
     */
    private $tableName = 'catalog_section';

    /**
     * @param CatalogSection $section
     * @return bool
     * @throws \Doctrine\DBAL\DBALException
     */
    public function save(CatalogSection &$section)
    {
        $sql = 'INSERT INTO '.$this->tableName.' (id, name, parent_id)'
            .' VALUES(:id, :name, :parent_id)'
            .' ON DUPLICATE KEY UPDATE name=:name, parent_id=:parent_id';

        $stmt = $this->connection->prepare($sql);
        $stmt->bindValue('id', $section->getId());
        $stmt->bindValue('name', $section->getName());
        $parentId = $section->getParentId();
        $stmt->bindValue('parent_id', $parentId ? $parentId : null);

        return $stmt->execute();
    }
}