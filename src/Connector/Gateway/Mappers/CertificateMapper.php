<?php
/**
 * @copyright Copyright (c) 2011 ООО «ТриДаВинчи»
 * @author Andrey Morozov
 */

namespace Connector\Gateway\Mappers;

use Connector\Gateway\Entity\Product;
use Connector\Gateway\Entity\Certificate;

/**
 * Class CertificateMapper
 * @package Connector\Gateway\Mappers
 */
class CertificateMapper extends GatewayMapperAbstract
{
    /**
     * @var string
     */
    private $tableName = 'certificate';

    /**
     * @param Certificate $certificate
     *
     * @return bool
     * @throws \Doctrine\DBAL\DBALException
     */
    public function save(Certificate &$certificate)
    {
        $sql = 'INSERT INTO ' . $this->tableName . ' (`product_id`, `name`, `url`, `validity_from`, `validity_to`)'
            . ' VALUES(:product_id, :name, :url, :validity_from, :validity_to)';

        $stmt = $this->connection->prepare($sql);
        $stmt->bindValue('product_id', $certificate->getProduct()->getId());
        $name = $certificate->getName();
        $stmt->bindValue('name', $name ? $name : 'Сертификат');
        $stmt->bindValue('url', $certificate->getUrl());
        $stmt->bindValue('validity_from', $certificate->getValidityFrom());
        $stmt->bindValue('validity_to', $certificate->getValidityTo());

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