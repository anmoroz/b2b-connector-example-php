<?php
/**
 * @copyright Copyright (c) 2011 ООО «ТриДаВинчи»
 * @author Andrey Morozov
 */

namespace Connector\Gateway\Mappers;

use Connector\Gateway\Entity\PaymentCompany;
use Connector\Gateway\Entity\Company;

/**
 * Class PaymentCompanyMapper
 * @package Connector\Gateway\Mappers
 */
class PaymentCompanyMapper extends GatewayMapperAbstract
{
    /**
     * @var string
     */
    private $tableName = 'payment_company';


    /**
     * @param PaymentCompany $paymentCompany
     * @return bool
     * @throws \Doctrine\DBAL\DBALException
     */
    public function save(PaymentCompany &$paymentCompany)
    {
        $document = $paymentCompany->getDocument();

        $sql = 'INSERT INTO '.$this->tableName.' (id, company_id, doc_name, sum_doc, sum_debt, expired_days, document_id)'
            .' VALUES(:id, :company_id, :doc_name,  :sum_doc, :sum_debt, :expired_days, :document_id)'
            .' ON DUPLICATE KEY UPDATE doc_name=:doc_name, sum_doc=:sum_doc, sum_debt=:sum_debt, expired_days=:expired_days, document_id=:document_id';

        $stmt = $this->connection->prepare($sql);
        $stmt->bindValue('id', $paymentCompany->getId());
        $stmt->bindValue('company_id', $paymentCompany->getCompany()->getId());
        $stmt->bindValue('doc_name', $paymentCompany->getDocName());
        $stmt->bindValue('sum_doc', $paymentCompany->getSumDoc());
        $stmt->bindValue('sum_debt', $paymentCompany->getSumDebt());
        $stmt->bindValue('expired_days', $paymentCompany->getExpiredDays());
        $stmt->bindValue('document_id', ($document && $document->getId()) ? $document->getId() : null);

        return $stmt->execute();
    }

    /**
     * @throws \Doctrine\DBAL\Exception\InvalidArgumentException
     */
    public function deleteAll()
    {
        $this->connection->delete($this->tableName, ['1' => 1]);
    }

    /**
     * @param Company $company
     * @throws \Doctrine\DBAL\Exception\InvalidArgumentException
     */
    public function deleteAllByCompany(Company $company)
    {
        $this->connection->delete($this->tableName, ['company_id' => $company->getId()]);
    }
}