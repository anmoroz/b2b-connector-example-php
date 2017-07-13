<?php
/**
 * @copyright Copyright (c) 2011 ООО «ТриДаВинчи»
 * @author Andrey Morozov
 */

namespace Connector\Gateway\Entity;

/**
 * Class PaymentCompany
 * @package Connector\Gateway\Entity
 */
class PaymentCompany extends B2bGatewayEntity
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var Company
     */
    private $company;

    /**
     * @var string
     */
    private $docName;

    /**
     * @var float
     */
    private $sumDoc;

    /**
     * @var float
     */
    private $sumDebt;

    /**
     * @var int
     */
    private $expiredDays;

    /**
     * @var Document
     */
    private $document;

    /**
     * @var \DateTime
     */
    private $updatedAt;


    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set id
     *
     * @param int $id
     * @return PaymentCompany
     */
    public function setId($id)
    {
        $this->id = (int) $id;

        return $this;
    }

    /**
     * Set company
     *
     * @param Company $company
     * @return PaymentCompany
     */
    public function setCompany(Company $company = null)
    {
        $this->company = $company;

        return $this;
    }

    /**
     * Get company
     *
     * @return Company
     */
    public function getCompany()
    {
        return $this->company;
    }

    /**
     * Set number of document
     *
     * @param string $docName
     * @return PaymentCompany
     */
    public function setDocName($docName)
    {
        $this->docName = $this->removeSpaces($docName);

        return $this;
    }

    /**
     * Get number of document
     *
     * @return string
     */
    public function getDocName()
    {

        return $this->docName;
    }

    /**
     * Set sum of document
     *
     * @param float|string $sumDoc
     * @return PaymentCompany
     */
    public function setSumDoc($sumDoc)
    {
        $this->sumDoc = (float) $sumDoc;
        if ($this->sumDoc < 0) {
            $this->sumDoc = 0;
        }

        return $this;
    }

    /**
     * Get sum of document
     *
     * @return float
     */
    public function getSumDoc()
    {
        return $this->sumDoc;
    }

    /**
     * Set sum of debt
     *
     * @param float|string $sumDebt
     * @return PaymentCompany
     */
    public function setSumDebt($sumDebt)
    {
        $this->sumDebt = (float) $sumDebt;
        if ($this->sumDebt < 0) {
            $this->sumDebt = 0;
        }

        return $this;
    }

    /**
     * Get sum of debt
     *
     * @return float
     */
    public function getSumDebt()
    {
        return $this->sumDebt;
    }

    /**
     * Set expired days
     *
     * @param int|string $expiredDays
     * @return PaymentCompany
     */
    public function setExpiredDays($expiredDays)
    {
        $this->expiredDays = (int) $expiredDays;

        return $this;
    }

    /**
     * Get expired days
     *
     * @return int
     */
    public function getExpiredDays()
    {
        return $this->expiredDays;
    }

    /**
     * Set company
     *
     * @param Document $document
     * @return PaymentCompany
     */
    public function setDocument(Document $document = null)
    {
        $this->document = $document;

        return $this;
    }

    /**
     * Get document
     *
     * @return Document
     */
    public function getDocument()
    {
        return $this->document;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     * @return PaymentCompany
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }
}
