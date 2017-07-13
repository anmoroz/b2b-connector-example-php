<?php
/**
 * @copyright Copyright (c) 2011 ООО «ТриДаВинчи»
 * @author Andrey Morozov
 */

namespace Connector\Gateway\Mappers;

use Connector\Gateway\Entity\Product;

/**
 * Class ProductMapper
 * @package Connector\Gateway\Mappers
 */
class ProductMapper extends GatewayMapperAbstract
{
    /**
     * @var string
     */
    private $tableName = 'product';

    /**
     * @var array
     */
    private $saveSettings = [
        'productFields' => true,
        'productIdentifiers' => true,
        'productAdditionalFields' => true,
    ];

    /**
     * @param array $settings
     */
    public function setSaveSettings(array $settings)
    {
        array_merge($this->saveSettings, $settings);
    }

    /**
     * Delete product
     *
     * @param Product $product
     * @return bool
     * @throws \Doctrine\DBAL\Exception\InvalidArgumentException
     */
    public function delete(Product $product)
    {
        return (boolean) $this->connection->delete($this->tableName, ['id' => $product->getId()]);
    }

    /**
     * @param array $ids
     * @return int Affected rows
     * @throws \Doctrine\DBAL\DBALException
     */
    public function deleteByIds(array $ids)
    {
        $sql = 'DELETE FROM '.$this->tableName.' WHERE id IN ('.implode(',', $ids).')';

        return $this->connection->executeUpdate($sql);
    }

    /**
     * @param Product $product
     */
    public function updateMoifiedDate(Product &$product)
    {
        $this->connection->update(
            $this->tableName,
            ['updated_at' => new \DateTime('now')],
            ['id' => $product->getId()],
            ['datetime', \PDO::PARAM_INT]
        );
    }

    /**
     * Save product into DB
     *
     * @param Product $product
     * @return bool
     * @throws \Doctrine\DBAL\ConnectionException
     */
    public function save(Product &$product)
    {
        if ($this->saveSettings['productFields']) {
            $mayBeNull = ['manufacturer_code', 'alt_manufacturer_code', 'manufacturer', 'name_of_manufacturer',
                'alt_name_of_manufacturer', 'unit_name', 'image_url', 'country_code_a3', 'stock_status'];

            $sql = 'INSERT INTO '.$this->tableName.' (id, external_id, article, name, multiplicity, brand_id, '.implode(', ', $mayBeNull).')'
                .' VALUES(:id, :external_id, :article, :name, :multiplicity, :brand_id, :'.implode(', :', $mayBeNull).')'
                .' ON DUPLICATE KEY UPDATE article=:article, multiplicity=:multiplicity, name=:name, stock_status=:stock_status, brand_id=:brand_id, updated_at=NOW()';

            foreach ($mayBeNull as $fieldName) {
                $sql .= ', '.$fieldName.'=:'.$fieldName;
            }

            /** @var \Doctrine\DBAL\Driver\Statement $stmt */
            $stmt = $this->connection->prepare($sql);
            $stmt->bindValue('id', $product->getId());
            $stmt->bindValue('external_id', $product->getExternalId());
            $stmt->bindValue('article', $product->getArticle());
            $stmt->bindValue('name', $product->getName());
            $stmt->bindValue('multiplicity', $product->getMultiplicity());

            $brand = $product->getBrand();
            $stmt->bindValue('brand_id', $brand ? $brand->getId() : null);

            foreach ($mayBeNull as $fieldName) {
                $value = null;
                $getter = 'get' . $this->id2camel($fieldName);
                if (method_exists($product, $getter)) {
                    $value = $product->$getter();
                }
                $stmt->bindValue($fieldName, $value);
            }
        }


        try {
            $saveResult = $this->saveSettings['productFields'] ? $stmt->execute() : true;
            if (!$product->getId()) {
                $product->setId($this->connection->lastInsertId());
            } else if ($product->getExternalId()) {
                $product->setId($this->getIdByExternalId($product->getExternalId()));
            }

            $this->updateRelatedTables($product);

            return $saveResult;
        } catch (\Exception $e) {
            // @TODO обернуть в ConnectorException
            echo sprintf(
                'Throw exception: "%s" on %s'.PHP_EOL,
                $e->getMessage(),
                date("Y.m.d H:i:s")
            );
        }

        return false;
    }

    private function getIdByExternalId($externalId)
    {
        return (int) $this->connection
            ->fetchColumn('SELECT id FROM '.$this->tableName.' WHERE external_id = ?', [$externalId]);
    }

    /**
     * @param Product $product
     * @return bool
     * @throws \Doctrine\DBAL\DBALException
     */
    private function updateRelatedTables(Product $product)
    {
        if (! $product->getId()) {

            return;
        }

        if ($this->saveSettings['productFields']) {
            // Delete all related section for product
            $this->connection->delete(
                'product_catalog_section_relation',
                ['product_id' => $product->getId()]
            );

            /** @var \Connector\Gateway\Entity\CatalogSection $catalogSection */
            foreach ($product->getCatalogSection() as $catalogSection) {

                $sql = 'INSERT INTO product_catalog_section_relation (product_id, catalog_section_id)'
                    .' VALUES (:product_id, :catalog_section_id)'
                    .' ON DUPLICATE KEY UPDATE product_id=product_id'
                ;

                $stmt = $this->connection->prepare($sql);
                $stmt->bindValue('product_id', $product->getId());
                $stmt->bindValue('catalog_section_id', $catalogSection->getId());

                $stmt->execute();
            }
        }

        if ($this->saveSettings['productIdentifiers'] && $identifiers = $product->getProductIdentifiers()) {
            $productIdentifiersMapper = new ProductIdentifiersMapper($this->connection);

            /** @var \Connector\Gateway\Entity\ProductIdentifiers $productIdentifier */
            foreach ($identifiers as $productIdentifier) {
                $productIdentifier->setProduct($product);
                $productIdentifiersMapper->save($productIdentifier);
            }
        }

        if ($this->saveSettings['productAdditionalFields'] && $additionalFields = $product->getProductAdditionalFields()) {
            $productAdditionalFieldMapper = new ProductAdditionalFieldMapper($this->connection);

            /** @var \Connector\Gateway\Entity\ProductAdditionalField $productAdditionalField */
            foreach ($additionalFields as $productAdditionalField) {
                $productAdditionalField->setProduct($product);
                $productAdditionalFieldMapper->save($productAdditionalField);
            }
        }
    }
}