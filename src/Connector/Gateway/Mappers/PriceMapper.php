<?php
/**
 * @copyright Copyright (c) 2011 ООО «ТриДаВинчи»
 * @author Andrey Morozov
 */

namespace Connector\Gateway\Mappers;

use Connector\Gateway\Entity\Price;

/**
 * Class PriceMapper
 * @package Connector\Gateway\Mappers
 */
class PriceMapper extends GatewayMapperAbstract
{
    /**
     * @var string
     */
    private $tableName = 'price';

    /**
     * @param Price $price
     *
     * @return bool
     * @throws \Doctrine\DBAL\DBALException
     */
    public function save(Price &$price)
    {
        $sql = 'INSERT INTO '.$this->tableName.' (`product_id`, `type_id`, `price`)'
            .' VALUES(:product_id, :type_id, :price)'
            .' ON DUPLICATE KEY UPDATE price=:price';

        $stmt = $this->connection->prepare($sql);
        $stmt->bindValue('product_id', $price->getProduct()->getId());
        $stmt->bindValue('type_id', $price->getType()->getId());
        $stmt->bindValue('price', $price->getPrice());

        return $stmt->execute();
    }
}
