<?php
/**
 * @copyright Copyright (c) 2011 ООО «ТриДаВинчи»
 * @author Andrey Morozov
 */

namespace Connector\Gateway\Repository;

use Connector\Gateway\Entity\Document as GatewayDocument;

/**
 * Class GatewayDocumentRepository
 * @package Connector\Gateway\Repository
 */
class DocumentRepository extends GatewayRepositoryAbstarct implements ObjectRepositoryInteface
{
    /**
     * @var string
     */
    protected $tableName = 'document';

    /**
     * @param string $externalId
     *
     * @return bool|GatewayDocument
     * @throws \Doctrine\DBAL\DBALException
     */
    public function findByExternalId($externalId)
    {
        $sql = 'SELECT * FROM '.$this->tableName.' WHERE external_id = :external_id';
        $document = $this->connection
            ->executeQuery($sql, [':external_id' => $externalId])
            ->fetch();

        return $document ? $this->createGatewayObject($document) : false;
    }

    /**
     * @return \Generator|int
     */
    public function iterate()
    {
        $smtp = $this->connection->createQueryBuilder()
            ->select('*')
            ->from($this->tableName)
            ->execute()
        ;

        while ($row = $smtp->fetch()) {
            yield $this->createGatewayObject($row);
        }
    }

    /**
     * @param array $data
     *
     * @return GatewayDocument
     */
    protected function createGatewayObject(array $data)
    {
        $document = new GatewayDocument();

        if ($type = (new DocumentTypeRepository($this->connection))->findById($data['type_id'])) {
            $document->setType($type);
        }

        $document->setAttributes([
            'id' => $data['id'],
            'externalId'  => $data['external_id'],
            'number'      => $data['number'],
            'totalAmount' => $data['total_amount'],
            'docDate' => \DateTime::createFromFormat('Y-m-d', $data['doc_date']),
        ]);

        return $document;
    }

    /**
     * @return string
     */
    public function getClassName()
    {
        return GatewayDocument::class;
    }
}