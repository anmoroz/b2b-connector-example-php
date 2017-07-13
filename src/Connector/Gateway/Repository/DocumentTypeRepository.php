<?php
/**
 * @copyright Copyright (c) 2011 ООО «ТриДаВинчи»
 * @author Andrey Morozov
 */

namespace Connector\Gateway\Repository;

use Connector\Gateway\Entity\DocumentType as GatewayDocumentType;

/**
 * Class GatewayDocumentTypeRepository
 * @package Connector\Gateway\Repository
 */
class DocumentTypeRepository extends GatewayRepositoryAbstarct implements ObjectRepositoryInteface
{
    /**
     * @var string
     */
    protected $tableName = 'document_type';

    /**
     * @param int $id
     *
     * @return bool|GatewayDocumentType
     * @throws \Doctrine\DBAL\DBALException
     */
    public function findById($id)
    {
        $sql = 'SELECT * FROM '.$this->tableName.' WHERE id = '. (int) $id;
        $documentType = $this->connection->executeQuery($sql)->fetch();

        return $documentType ? $this->createGatewayObject($documentType) : false;
    }

    /**
     * @return \Generator|int
     */
    public function iterate()
    {
        $documentTypes = $this->connection->createQueryBuilder()
            ->select('*')
            ->from($this->tableName)
            ->execute()
            ->fetchAll()
        ;

        foreach ($documentTypes as $row) {
            yield $this->createGatewayObject($row);
        }
    }

    /**
     * @param array $data
     *
     * @return GatewayDocumentType
     */
    protected function createGatewayObject(array $data)
    {
        $type = new GatewayDocumentType();
        $type->setAttributes([
            'id' => $data['id'],
            'name' => $data['name'],
            'nameShort' => $data['name_short'],
        ]);

        return $type;
    }

    /**
     * @return string
     */
    public function getClassName()
    {
        return GatewayDocumentType::class;
    }
}