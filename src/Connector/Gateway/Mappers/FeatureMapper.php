<?php
/**
 * @copyright Copyright (c) 2011 ООО «ТриДаВинчи»
 * @author Andrey Morozov
 */

namespace Connector\Gateway\Mappers;

use Connector\Gateway\Entity\Feature;
use Connector\Gateway\Entity\Product;

/**
 * Class FeatureMapper
 * @package Connector\Gateway\Mappers
 */
class FeatureMapper extends GatewayMapperAbstract
{
    /**
     * @var string
     */
    private $tableName = 'feature';

    /**
     * @param Feature $feature
     * @return bool
     * @throws \Doctrine\DBAL\ConnectionException
     */
    public function save(Feature &$feature)
    {
        $sql = 'INSERT INTO '.$this->tableName.' (product_id, name, value, unit, sort)'
            .' VALUES(:product_id, :name, :value, :unit, :sort)'
            .' ON DUPLICATE KEY UPDATE value=:value, unit=:unit, sort=:sort';

        /** @var \Doctrine\DBAL\Driver\Statement $stmt */
        $stmt = $this->connection->prepare($sql);
        $stmt->bindValue('product_id', $feature->getProduct()->getId());
        $stmt->bindValue('name', $feature->getName());
        $stmt->bindValue('value', $feature->getValue());
        $stmt->bindValue('unit', $feature->getUnit());
        $stmt->bindValue('sort', $feature->getSort());

        return $stmt->execute();
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
