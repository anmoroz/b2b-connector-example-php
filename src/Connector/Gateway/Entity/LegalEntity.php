<?php
/**
 * @copyright Copyright (c) 2011 ООО «ТриДаВинчи»
 * @author Andrey Morozov
 */

namespace Connector\Gateway\Entity;

/**
 * Class LegalEntity
 * @package Connector\Gateway\Entity
 */
class LegalEntity extends B2bGatewayEntity
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $shortName = '';

    /**
     * @var string
     */
    private $inn;

    /**
     * @var string
     */
    private $kpp = '';

    /**
     * @var \DateTime
     */
    private $updatedAt;

    /**
     * @var \Connector\Gateway\Entity\Company
     */
    private $company;


    /**
     * Set name
     *
     * @param string $name
     * @return LegalEntity
     */
    public function setName($name)
    {
        $this->name = $this->removeSpaces($name);

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set short name
     *
     * @param string $shortName
     * @return LegalEntity
     */
    public function setShortName($shortName)
    {
        $this->shortName = $this->removeSpaces($shortName);

        return $this;
    }

    /**
     * Get short name
     *
     * @return string
     */
    public function getShortName()
    {
        return $this->shortName;
    }


    /**
     * Set inn
     *
     * @param string $inn
     * @return LegalEntity
     */
    public function setInn($inn)
    {
        if (preg_match('/^\d{10}|\d{12}$/', $inn)) {
            $this->inn = $inn;
        }

        return $this;
    }

    /**
     * Get inn
     *
     * @return string
     */
    public function getInn()
    {
        return $this->inn;
    }


    /**
     * Set kpp
     *
     * @param string $kpp
     * @return LegalEntity
     */
    public function setKpp($kpp)
    {
        if (preg_match('/^\d{9}$/', $kpp)) {
            $this->kpp = $kpp;
        }

        return $this;
    }

    /**
     * Get kpp
     *
     * @return string
     */
    public function getKpp()
    {
        return $this->kpp;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     * @return LegalEntity
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

    /**
     * Set company
     *
     * @param Company $company
     * @return LegalEntity
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
}
