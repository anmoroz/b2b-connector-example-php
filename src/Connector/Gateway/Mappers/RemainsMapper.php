<?php
/**
 * @copyright Copyright (c) 2011 ООО «ТриДаВинчи»
 * @author Andrey Morozov
 */

namespace Connector\Gateway\Mappers;

use Connector\Gateway\Entity\Remains;

/**
 * Class RemainsMapper
 * @package Connector\Gateway\Mappers
 */
class RemainsMapper extends GatewayMapperAbstract
{
    /**
     * @var string
     */
    private $tableName = 'remains';

    /**
     * @param Remains $remains
     *
     * @return bool
     * @throws \Doctrine\DBAL\DBALException
     */
    public function save(Remains &$remains)
    {
        $sql = 'INSERT INTO '.$this->tableName.' (`product_id`, `store_id`, `total_item_count`)'
            .' VALUES(:product_id, :store_id, :total_item_count)'
            .' ON DUPLICATE KEY UPDATE total_item_count=:total_item_count';

        $stmt = $this->connection->prepare($sql);
        $stmt->bindValue('product_id', $remains->getProduct()->getId());
        $stmt->bindValue('store_id', $remains->getStore()->getId());
        $stmt->bindValue('total_item_count', $remains->getTotalItemCount());

        return $stmt->execute();
    }
}