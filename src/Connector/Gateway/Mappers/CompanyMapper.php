<?php
/**
 * @copyright Copyright (c) 2011 ООО «ТриДаВинчи»
 * @author Andrey Morozov
 */

namespace Connector\Gateway\Mappers;

use Connector\Gateway\Entity\Company;

/**
 * Class CompanyMapper
 * @package Connector\Gateway\Mappers
 */
class CompanyMapper extends GatewayMapperAbstract
{
    /**
     * @var string
     */
    private $tableName = 'company';

    /**
     * @param Company $company
     *
     * @return bool
     * @throws \Doctrine\DBAL\DBALException
     */
    public function save(Company &$company)
    {
        $sql = 'INSERT INTO ' . $this->tableName . ' (`id`, `external_id`, `is_individual`, `name`, `alt_name`, `description`, `price_type_id`, `credit_sum`, `receivables`, `overdue_receivables`, `overdue_duration`, `note`)'
            . ' VALUES(:id, :external_id, :is_individual, :name, :alt_name, :description, :price_type_id, :credit_sum, :receivables, :overdue_receivables, :overdue_duration, :note)'
            . ' ON DUPLICATE KEY UPDATE is_individual=:is_individual, name=:name, alt_name=:alt_name, description=:description, credit_sum=:credit_sum, receivables=:receivables, overdue_receivables=:overdue_receivables, overdue_duration=:overdue_duration, note=:note, updated_at=NOW()';

        $stmt = $this->connection->prepare($sql);
        $stmt->bindValue('id', $company->getId());
        $stmt->bindValue('external_id', $company->getExternalId());
        $stmt->bindValue('is_individual', $company->getIsIndividual() ? 1 : 0);
        $stmt->bindValue('name', $company->getName());
        $stmt->bindValue('alt_name', $company->getAltName());
        $stmt->bindValue('description', $company->getDescription());
        $stmt->bindValue('price_type_id', $company->getPriceType()->getId());
        $stmt->bindValue('credit_sum', $company->getCreditSum());
        $stmt->bindValue('receivables', $company->getReceivables());
        $stmt->bindValue('overdue_receivables', $company->getOverdueReceivables());
        $stmt->bindValue('overdue_duration', $company->getOverdueDuration());
        $stmt->bindValue('note', $company->getNote());

        $saveResult = $stmt->execute();

        // @TODO можно добавить очистку адресов и юр.лиц

        if (false === $company->getIsIndividual()) {
            $this->updateRelatedTables($company);
        }

        return $saveResult;
    }

    /**
     * @param Company $company
     * @throws \Doctrine\DBAL\DBALException
     */
    private function updateRelatedTables(Company $company)
    {
        if (!$company->getId()) {

            return;
        }

        /** @var \Connector\Gateway\Entity\Address $address */
        foreach ($company->getAddresses() as $address) {
            $sql = 'INSERT INTO address (company_id, address, address_hash)'
                .' VALUES(:company_id, :address, :address_hash)'
                .' ON DUPLICATE KEY UPDATE address=:address';

            $stmt = $this->connection->prepare($sql);
            $stmt->bindValue('company_id', $company->getId());
            $stmt->bindValue('address', $address->getAddress());
            $stmt->bindValue('address_hash', $address->getAddressHash());

            $stmt->execute();
        }

        /** @var \Connector\Gateway\Entity\LegalEntity $legalEntity */
        foreach ($company->getLegalEntities() as $legalEntity) {
            $sql = 'INSERT INTO legal_entity (company_id, name, short_name, inn, kpp)'
                .' VALUES(:company_id, :name, :short_name, :inn, :kpp)'
                .' ON DUPLICATE KEY UPDATE name=:name, short_name=:short_name, kpp=:kpp';

            $stmt = $this->connection->prepare($sql);
            $stmt->bindValue('company_id', $company->getId());
            $stmt->bindValue('name', $legalEntity->getName());
            $stmt->bindValue('short_name', $legalEntity->getShortName());
            $stmt->bindValue('inn', $legalEntity->getInn());
            $stmt->bindValue('kpp', $legalEntity->getKpp());

            $stmt->execute();
        }
    }
}
