<?php
/**
 * @copyright Copyright (c) 2011 ООО «ТриДаВинчи»
 * @author Andrey Morozov
 */

namespace Connector\Gateway\Repository;

use Connector\Gateway\Entity\Company;
use Connector\Gateway\Entity\Order as GatewayOrder;
use Connector\Gateway\Entity\OrderItem;
use Connector\Gateway\Entity\PriceType;

/**
 * Class GatewayOrderRepository
 * @package Connector\Gateway\Repository
 */
class OrderRepository extends GatewayRepositoryAbstarct implements ObjectRepositoryInteface
{
    /**
     * @var string
     */
    protected $tableName = 'order';

    /**
     * @var boolean
     */
    private $onlyNew = false;

    /**
     * @return \Generator|int
     */
    public function iterate()
    {
        /** @var \Doctrine\DBAL\Query\QueryBuilder $queryBuilder */
        $queryBuilder = $this->connection->createQueryBuilder()
            ->select('*')
            ->from('`'.$this->tableName.'`')
        ;

        if ($this->onlyNew) {
            $queryBuilder->where('external_id IS NULL');
        }

        $smtp = $queryBuilder->execute();

        while ($row = $smtp->fetch()) {
            yield $this->createGatewayObject($row);
        }
    }

    /**
     * @param array $data
     * @return GatewayOrder
     */
    protected function createGatewayObject(array $data)
    {
        $order = new GatewayOrder();
        $order->setAttributes([
            'id' => $data['id'],
            'externalId' => $data['external_id'],
            'status' => $data['status'],
            'comment' => $data['comment'],
        ]);

        if ($data['company_id']) {
            $company = new Company();
            $company->setId($data['company_id']);
            $order->setCompany($company);
        }

        // Products in order
        $orderItemRows = $this->connection->createQueryBuilder()
            ->select('oi.*, t.id as price_type_id, t.external_id as price_type_external_id, t.name as price_type_name')
            ->from('order_item', 'oi')
            ->leftJoin('oi', 'price_type', 't', 'oi.price_type_id = t.id')
            ->where('oi.order_id = '.$data['id'])
            ->execute()
            ->fetchAll()
        ;
        foreach ($orderItemRows as $orderItemRow) {
            $order->addItem($this->createOrderItemGatewayObject($orderItemRow));
        }

        return $order;
    }

    /**
     * @param array $data
     * @return OrderItem
     */
    protected function createOrderItemGatewayObject(array $data)
    {
        $orderItem = new OrderItem();
        $orderItem->setAttributes([
            'id' => $data['id'],
            'article' => $data['article'],
            'price' => $data['price'],
            'quantity' => $data['quantity'],
        ]);

        $priceType = new PriceType();
        $priceType->setId($data['price_type_id']);
        $priceType->setExternalId($data['price_type_external_id']);
        $priceType->setName($data['price_type_name']);

        $orderItem->setPriceType($priceType);

        return $orderItem;
    }

    /**
     * @return OrderRepository
     */
    public function onlyNew()
    {
        $this->onlyNew = true;

        return $this;
    }

    /**
     * @return string
     */
    public function getClassName()
    {
        return GatewayOrder::class;
    }
}