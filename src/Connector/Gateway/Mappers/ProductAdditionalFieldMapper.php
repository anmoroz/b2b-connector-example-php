<?php
/**
 * @copyright Copyright (c) 2011 ООО «ТриДаВинчи»
 * @author Andrey Morozov
 */

namespace Connector\Gateway\Mappers;

use Connector\Gateway\Entity\ProductAdditionalField;

/**
 * Class ProductAdditionalFieldMapper
 * @package Connector\Gateway\Mappers
 */
class ProductAdditionalFieldMapper extends GatewayMapperAbstract
{
    /**
     * @var string
     */
    private $tableName = 'product_additional_field';

    /**
     * @param ProductAdditionalField $productAdditionalField
     * @return bool
     * @throws \Doctrine\DBAL\ConnectionException
     */
    public function save(ProductAdditionalField &$productAdditionalField)
    {
        $sql = 'INSERT INTO '.$this->tableName.' (product_id, name, `value`)'
            .' VALUES(:product_id, :name, :value)'
            .' ON DUPLICATE KEY UPDATE value=:value';

        $stmt = $this->connection->prepare($sql);
        $stmt->bindValue('product_id', $productAdditionalField->getProduct()->getId());
        $stmt->bindValue('name', $productAdditionalField->getName());
        $stmt->bindValue('value', $productAdditionalField->getValue());

        return $stmt->execute();
    }
}
