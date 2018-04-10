<?php
/**
 * @copyright Copyright (c) 2011 ООО «ТриДаВинчи»
 * @author Andrey Morozov
 */

namespace Connector\Gateway\Mappers;

use Connector\Gateway\Entity\Brand;

/**
 * Class BrandMapper
 * @package Connector\Gateway\Mappers
 */
class BrandMapper extends GatewayMapperAbstract
{
    /**
     * @var string
     */
    private $tableName = 'brand';

    /**
     * @param Brand $brand
     * @return bool
     * @throws \Doctrine\DBAL\DBALException
     */
    public function save(Brand &$brand)
    {
        $sql = 'INSERT INTO '.$this->tableName.' (id, external_id, name, synonyms)'
            .' VALUES(:id, :external_id, :name, :synonyms)'
            .' ON DUPLICATE KEY UPDATE name = :name, synonyms = :synonyms';

        $stmt = $this->connection->prepare($sql);
        $stmt->bindValue('id', $brand->getId());
        $stmt->bindValue('external_id', $brand->getId());
        $stmt->bindValue('name', $brand->getName());
        $stmt->bindValue('synonyms', $brand->getSynonyms());

        return $stmt->execute();
    }

    /**
     * @param string $name
     * @param string $synonyms
     * @return int
     */
    public function updateSynonymsByName($name, $synonyms)
    {
        return $this->connection->update(
            $this->tableName,
            ['synonyms' => mb_strtolower($synonyms), 'updated_at' => new \DateTime('now')],
            ['name' => $name],
            [\PDO::PARAM_STR, 'datetime', \PDO::PARAM_STR]
        );
    }
}