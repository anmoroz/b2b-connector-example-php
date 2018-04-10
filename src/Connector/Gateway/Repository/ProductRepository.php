<?php
/**
 * @copyright Copyright (c) 2011 ООО «ТриДаВинчи»
 * @author Andrey Morozov
 */

namespace Connector\Gateway\Repository;

use Connector\Gateway\Entity\Product as GatewayProduct;
use Connector\Gateway\Entity\Brand as GatewayBrand;
use Doctrine\DBAL\Query\QueryBuilder;

/**
 * Class GatewayProductRepository
 * @package Connector\Gateway\Repository
 */
class ProductRepository extends GatewayRepositoryAbstarct implements ObjectRepositoryInteface
{
    const NUMBER_OF_PRODUCTS_IN_LOOP = 200;

    /**
     * @var string
     */
    protected $tableName = 'product';

    /**
     * @param string $article
     * @return GatewayProduct|null
     * @throws \Doctrine\DBAL\DBALException
     */
    public function findByArticle($article)
    {
        $sql = 'SELECT p.*, b.name as brand_name FROM '.$this->tableName.' AS p'
            .' LEFT JOIN brand AS b ON (p.brand_id = b.id)'
            .' WHERE p.article = :article';
        $product = $this->connection->executeQuery($sql, [':article' => $article])->fetch();

        return $product ? $this->createGatewayObject($product) : null;
    }

    /**
     * @param string $externalId
     * @return GatewayProduct|null
     * @throws \Doctrine\DBAL\DBALException
     */
    public function findByExternalId($externalId)
    {
        $sql = 'SELECT p.*, b.name as brand_name FROM '.$this->tableName.' AS p'
            .' LEFT JOIN brand AS b ON (p.brand_id = b.id)'
            .' WHERE p.external_id = :external_id';
        $product = $this->connection->executeQuery($sql, [':external_id' => $externalId])->fetch();

        return $product ? $this->createGatewayObject($product) : null;
    }

    /**
     * @param int $id
     * @return GatewayProduct|null
     * @throws \Doctrine\DBAL\DBALException
     */
    public function findById($id)
    {
        $sql = 'SELECT p.*, b.name as brand_name FROM '.$this->tableName.' AS p'
            .' LEFT JOIN brand AS b ON (p.brand_id = b.id)'
            .' WHERE p.id = '. (int) $id;
        $product = $this->connection->executeQuery($sql)->fetch();

        return $product ? $this->createGatewayObject($product) : null;
    }

    /**
     * Select all products without remains
     * @return \Generator
     */
    public function iterateWithoutRemains()
    {
        $smtp = $this->connection->createQueryBuilder()
            ->select('p.*')
            ->from($this->tableName, 'p')
            ->where('NOT EXISTS (select id from remains where product_id = p.id)')
            ->execute()
        ;

        while ($row = $smtp->fetch()) {
            yield $this->createGatewayObject($row);
        }
    }

    /**
     * Select all products without price
     * @return \Generator
     */
    public function iterateWithoutPrice()
    {
        $smtp = $this->connection->createQueryBuilder()
            ->select('p.*')
            ->from($this->tableName, 'p')
            ->where('NOT EXISTS (select id from price where product_id = p.id)')
            ->execute()
        ;

        while ($row = $smtp->fetch()) {
            yield $this->createGatewayObject($row);
        }
    }

    /**
     * Select all products without brand
     * @return \Generator
     */
    public function iterateWithoutBrand()
    {
        $smtp = $this->connection->createQueryBuilder()
            ->select('*')
            ->from($this->tableName)
            ->where('brand_id is null')
            ->execute()
        ;

        while ($row = $smtp->fetch()) {
            yield $this->createGatewayObject($row);
        }
    }

    /**
     * @return \Generator
     */
    public function iterate()
    {
        $countProducts = $this->getCountProducts();

        $loops = ceil($countProducts / self::NUMBER_OF_PRODUCTS_IN_LOOP);

        for ($i = 0; $i < $loops; $i++) {
            $offset = $i * self::NUMBER_OF_PRODUCTS_IN_LOOP;

            $products = $this->connection->createQueryBuilder()
                ->select('COUNT(*)')
                ->from($this->tableName)
                ->setFirstResult($offset)
                ->setMaxResults(self::NUMBER_OF_PRODUCTS_IN_LOOP)
                ->execute()
                ->fetchAll()
            ;

            foreach ($products as $row) {
                yield $this->createGatewayObject($row);
            }
        }
    }

    /**
     * @return string
     */
    public function getClassName()
    {
        return GatewayProduct::class;
    }

    /**
     * @param array $data
     * @return GatewayProduct
     */
    protected function createGatewayObject(array $data)
    {
        $product = new GatewayProduct();
        $product->setAttributes([
            'id' => $data['id'],
            'externalId' => $data['external_id'],
            'article' => $data['article'],
            'manufacturerCode' => $data['manufacturer_code'],
            'name' => $data['name'],
            'unitName' => $data['unit_name'],
            'setCountryCodeA3' => $data['country_code_a3'],
        ]);

        if (isset($data['brand_id']) && $data['brand_id'] && isset($data['brand_name'])) {
            $brand = new GatewayBrand();
            $brand->setId($data['brand_id']);
            $brand->setName($data['brand_name']);
            $product->setBrand($brand);
        }

        return $product;
    }

    /**
     * @return int
     */
    private function getCountProducts()
    {
        /** @var QueryBuilder $queryBuilder */
        $queryBuilder = $this->connection->createQueryBuilder();

        return (int) $queryBuilder
            ->select('COUNT(*)')
            ->from($this->tableName)
            ->execute()
            ->fetchColumn();
    }
}