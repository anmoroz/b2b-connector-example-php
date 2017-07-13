<?php
/**
 * @copyright Copyright (c) 2011 ООО «ТриДаВинчи»
 * @author Andrey Morozov
 */

namespace Connector\Gateway\Repository;

use Connector\Gateway\Entity\Company as GatewayCompany;

/**
 * Class GatewayCompanyRepository
 * @package Connector\Gateway\Repository
 */
class CompanyRepository extends GatewayRepositoryAbstarct implements ObjectRepositoryInteface
{
    /**
     * @var string
     */
    protected $tableName = 'company';


    /**
     * @param string $id
     *
     * @return bool|GatewayCompany
     * @throws \Doctrine\DBAL\DBALException
     */
    public function findById($id)
    {
        $sql = 'SELECT * FROM '.$this->tableName.' WHERE id = :id';
        $row = $this->connection
            ->executeQuery($sql, [':id' => $id])
            ->fetch();

        return $row ? $this->createGatewayObject($row) : false;
    }

    /**
     * @param string $externalId
     *
     * @return bool|GatewayCompany
     * @throws \Doctrine\DBAL\DBALException
     */
    public function findByExternalId($externalId)
    {
        $sql = 'SELECT * FROM '.$this->tableName.' WHERE external_id = :external_id';
        $row = $this->connection
            ->executeQuery($sql, [':external_id' => $externalId])
            ->fetch();

        return $row ? $this->createGatewayObject($row) : false;
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
     * @return GatewayCompany
     */
    protected function createGatewayObject(array $data)
    {
        $company = new GatewayCompany();
        $company->setAttributes([
            'id' => $data['id'],
            'externalId' => $data['external_id'],
            'name' => $data['name'],
        ]);

        return $company;
    }

    /**
     * @return string
     */
    public function getClassName()
    {
        return GatewayCompany::class;
    }
}