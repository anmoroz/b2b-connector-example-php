<?php
/**
 * @copyright Copyright (c) 2011 ООО «ТриДаВинчи»
 * @author Andrey Morozov
 */

namespace Connector\Gateway\Mappers;

use Connector\Gateway\Entity\ContractPrice;

/**
 * Class ContractPriceMapper
 * @package Connector\Gateway\Mappers
 */
class ContractPriceMapper extends GatewayMapperAbstract
{
    /**
     * @var string
     */
    private $tableName = 'contract_price';

    /**
     * @param ContractPrice $contractPrice
     *
     * @return bool
     * @throws \Doctrine\DBAL\DBALException
     */
    public function save(ContractPrice &$contractPrice)
    {
        $sql = 'INSERT INTO '.$this->tableName.' (id, company_id, price_type_id, discount, brand_id, category_ids)'
            .' VALUES(:id, :company_id, :price_type_id, :discount, :brand_id, :category_ids)'
            .' ON DUPLICATE KEY UPDATE company_id=:company_id, price_type_id=:price_type_id, discount=:discount, brand_id=:brand_id, category_ids=:category_ids';

        $stmt = $this->connection->prepare($sql);

        $stmt->bindValue('id', $contractPrice->getId());
        $stmt->bindValue('company_id', $contractPrice->getCompany()->getId());
        $stmt->bindValue('price_type_id', $contractPrice->getPriceType()->getId());
        $stmt->bindValue('discount', $contractPrice->getDiscount());
        $brand = $contractPrice->getBrand();
        $stmt->bindValue('brand_id', $brand ? $brand->getId() : null);

        $categoryIds = $contractPrice->getCategoryIds();
        $stmt->bindValue('category_ids', $categoryIds ? $categoryIds : null);

        return $stmt->execute();
    }
}