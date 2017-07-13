<?php
/**
 * @copyright Copyright (c) 2011 ООО «ТриДаВинчи»
 * @author Andrey Morozov
 */

namespace Connector\Gateway\Mappers;

use Connector\Gateway\Entity\Product;
use Connector\Gateway\Entity\RemainsManufacturer;

/**
 * Class RemainsManufacturerMapper
 * @package Connector\Gateway\Mappers
 */
class RemainsManufacturerMapper extends GatewayMapperAbstract
{
    /**
     * @var string
     */
    private $tableName = 'remains_manufacturer';

    /**
     * @param RemainsManufacturer $remainsManufacturer
     *
     * @return bool
     * @throws \Doctrine\DBAL\DBALException
     */
    public function save(RemainsManufacturer &$remainsManufacturer)
    {
        $sql = 'INSERT INTO ' . $this->tableName . ' (`product_id`, `storage_name`, `quantity`, `relevance_date`)'
            . ' VALUES(:product_id, :storage_name, :quantity, :relevance_date)';

        $stmt = $this->connection->prepare($sql);
        $stmt->bindValue('product_id', $remainsManufacturer->getProduct()->getId());
        $stmt->bindValue('storage_name', $remainsManufacturer->getStorageName());
        $stmt->bindValue('quantity', $remainsManufacturer->getQuantity());
        $stmt->bindValue('relevance_date', $remainsManufacturer->getRelevanceDate());

        return $stmt->execute();
    }

    /**
     * @throws \Doctrine\DBAL\Exception\InvalidArgumentException
     */
    public function deleteAll()
    {
        $this->connection->delete($this->tableName, ['1' => 1]);
    }

    /**
     * @param Product $product
     * @throws \Doctrine\DBAL\Exception\InvalidArgumentException
     */
    public function deleteAllByProduct(Product $product)
    {
        $this->connection->delete($this->tableName, ['product_id' => $product->getId()]);
    }
}