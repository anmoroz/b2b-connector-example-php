<?php
/**
 * @copyright Copyright (c) 2011 ООО «ТриДаВинчи»
 * @author Andrey Morozov
 */

namespace Connector\Gateway\Mappers;

use Connector\Gateway\Entity\ResiduePacking;

/**
 * Class ResiduePackingMapper
 * @package Connector\Gateway\Mappers
 */
class ResiduePackingMapper extends GatewayMapperAbstract
{
    /**
     * @var string
     */
    private $tableName = 'residue_packing';

    /**
     * @param ResiduePacking $residuePacking
     *
     * @return bool
     * @throws \Doctrine\DBAL\DBALException
     */
    public function save(ResiduePacking &$residuePacking)
    {
        if ($residuePacking->getResidue() === 0.00 && $id = $residuePacking->getId()) {

            return $this->connection->delete($this->tableName, ['id' => $id]);
        }

        $sql = 'INSERT INTO '.$this->tableName.' (`id`, `product_id`, `store_id`, `consignment`, `residue`, `reserve`)'
            .' VALUES(:id, :product_id, :store_id, :consignment, :residue, :reserve)'
            .' ON DUPLICATE KEY UPDATE consignment=:consignment, residue=:residue, reserve=:reserve';

        $stmt = $this->connection->prepare($sql);
        $stmt->bindValue('id', $residuePacking->getId());
        $stmt->bindValue('product_id', $residuePacking->getProduct()->getId());
        $stmt->bindValue('store_id', $residuePacking->getStore()->getId());
        $stmt->bindValue('consignment', $residuePacking->getConsignment());
        $stmt->bindValue('residue', $residuePacking->getResidue());
        $stmt->bindValue('reserve', $residuePacking->getReserve());

        return $stmt->execute();
    }
}