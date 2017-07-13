<?php
/**
 * @copyright Copyright (c) 2011 ООО «ТриДаВинчи»
 * @author Andrey Morozov
 */

namespace Connector\Gateway\Mappers;

use Connector\Gateway\Entity\Gallery;
use Connector\Gateway\Entity\Product;

/**
 * Class GalleryMapper
 * @package Connector\Gateway\Mappers
 */
class GalleryMapper extends GatewayMapperAbstract
{
    /**
     * @var string
     */
    private $tableName = 'gallery';

    /**
     * @param Gallery $gallery
     * @return bool
     * @throws \Doctrine\DBAL\DBALException
     */
    public function save(Gallery &$gallery)
    {
        $sql = 'INSERT INTO '.$this->tableName.' (product_id, image_url)'
            .' VALUES(:product_id, :image_url)';

        /** @var \Doctrine\DBAL\Driver\Statement $stmt */
        $stmt = $this->connection->prepare($sql);
        $stmt->bindValue('product_id', $gallery->getProduct()->getId());
        $stmt->bindValue('image_url', $gallery->getImageUrl());

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