<?php
/**
 * @copyright Copyright (c) 2011 ООО «ТриДаВинчи»
 * @author Andrey Morozov
 */

namespace Connector\Gateway\Mappers;

use Connector\Gateway\Entity\Document;
use Connector\Gateway\Entity\DocumentItem;

/**
 * Class DocumentMapper
 * @package Connector\Gateway\Mappers
 */
class DocumentMapper extends GatewayMapperAbstract
{
    /**
     * @var string
     */
    private $tableName = 'document';

    /**
     * @param Document $document
     *
     * @return bool
     * @throws \Doctrine\DBAL\DBALException
     */
    public function save(Document &$document)
    {
        $sql = 'INSERT INTO '.$this->tableName.' (external_id, type_id, order_id, parent_document_id, number, total_amount, doc_date, incoming, updated_at)'
            .' VALUES(:external_id, :type_id, :order_id, :parent_document_id, :number, :total_amount, :doc_date, :incoming, NOW())';

        $stmt = $this->connection->prepare($sql);

        $order = $document->getOrder();
        $parentDocument = $document->getParentDocument();
        $type = $document->getType();

        $stmt->bindValue('external_id', $document->getExternalId());
        $stmt->bindValue('type_id', $type->getId());
        $stmt->bindValue('order_id', $order ? $order->getId() : null);
        $stmt->bindValue('parent_document_id', $parentDocument ? $parentDocument->getId() : null);
        $stmt->bindValue('number', $document->getNumber());
        $stmt->bindValue('total_amount', $document->getTotalAmount());
        $stmt->bindValue('doc_date', $document->getDocDate()->format('Y-m-d'));
        $stmt->bindValue('incoming', $document->getIncoming());

        $saveResult = $stmt->execute();

        $document->setId($this->connection->lastInsertId());

        $this->saveProductInDocument($document);

        if ($saveResult) {
            // @TODO обновление данных на стороне продваца
        }

        return $saveResult;
    }

    /**
     * @param Document $document
     * @throws \Exception
     * @throws \Doctrine\DBAL\ConnectionException
     * @throws \Doctrine\DBAL\DBALException
     */
    private function saveProductInDocument(Document $document)
    {
        $sqlProductInDocument = 'INSERT INTO document_item (document_id, product_id, price, price_type_id, quantity, amount, unit_name)'
            .' VALUES(:document_id, :product_id, :price, :price_type_id, :quantity, :amount, :unit_name)';

        $this->connection->beginTransaction();
        try {
            /** @var DocumentItem $item */
            foreach ($document->getItems() as $item) {
                $stmt = $this->connection->prepare($sqlProductInDocument);

                $stmt->bindValue('document_id', $document->getId());
                $stmt->bindValue('product_id', $item->getProductId());
                $stmt->bindValue('price', $item->getPrice());
                $stmt->bindValue('quantity', $item->getQuantity());
                $stmt->bindValue('amount', $item->getAmount());
                $stmt->bindValue('unit_name', $item->getUnitName());

                if ($priceType = $item->getPriceType()) {
                    $stmt->bindValue('price_type_id', $priceType->getId());
                } else {
                    $stmt->bindValue('price_type_id', null);
                }
                $stmt->execute();
            }

            $this->connection->commit();

        } catch(\Exception $e) {
            $this->connection->rollBack();

            throw $e;
        }
    }
}