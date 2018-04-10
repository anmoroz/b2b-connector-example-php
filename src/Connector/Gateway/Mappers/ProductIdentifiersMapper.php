<?php
/**
 * @copyright Copyright (c) 2011 ООО «ТриДаВинчи»
 * @author Andrey Morozov
 */

namespace Connector\Gateway\Mappers;

use Connector\Gateway\Entity\ProductIdentifiers;

/**
 * Class ProductIdentifiersMapper
 * @package Connector\Gateway\Mappers
 */
class ProductIdentifiersMapper extends GatewayMapperAbstract
{
    /**
     * @var string
     */
    private $tableName = 'product_identifiers';

    /**
     * @param ProductIdentifiers $productIdentifiers
     * @return bool
     * @throws \Doctrine\DBAL\ConnectionException
     */
    public function save(ProductIdentifiers &$productIdentifiers)
    {
        $sql = 'INSERT INTO '.$this->tableName.' (product_id, name, `value`)'
            .' VALUES(:product_id, :name, :value)'
            .' ON DUPLICATE KEY UPDATE value=:value';

        $stmt = $this->connection->prepare($sql);
        $stmt->bindValue('product_id', $productIdentifiers->getProduct()->getId());
        $stmt->bindValue('name', $productIdentifiers->getName());
        $stmt->bindValue('value', $productIdentifiers->getValue());

        $stmt->execute();
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