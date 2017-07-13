<?php
/**
 * @copyright Copyright (c) 2011 ООО «ТриДаВинчи»
 * @author Andrey Morozov
 */

namespace Connector\Gateway\Entity;

/**
 * Class Company
 * @package Connector\Gateway\Entity
 */
class Company extends B2bGatewayEntity
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $externalId;

    /**
     * @var boolean
     */
    private $isIndividual;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $altName;

    /**
     * @var string
     */
    private $description;

    /**
     * @var float
     */
    private $creditSum = 0;

    /**
     * @var float
     */
    private $receivables = 0;

    /**
     * @var float
     */
    private $overdueReceivables = 0;

    /**
     * @var integer
     */
    private $overdueDuration = 0;

    /**
     * @var string
     */
    private $note;

    /**
     * @var \Connector\Gateway\Entity\PriceType
     */
    private $priceType;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $addresses;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $legalEntities;

    /**
     * @var \DateTime
     */
    private $updatedAt;


    /**
     * Constructor
     */
    public function __construct()
    {
        $this->addresses = new \Doctrine\Common\Collections\ArrayCollection();
        $this->legalEntities = new \Doctrine\Common\Collections\ArrayCollection();
    }

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
     * @return Company
     */
    public function setId($id)
    {
        $this->id = (int) $id;

        return $this;
    }

    /**
     * Set externalId
     *
     * @param string $externalId
     * @return Company
     */
    public function setExternalId($externalId)
    {
        $this->externalId = $externalId;

        return $this;
    }

    /**
     * Get externalId
     *
     * @return string
     */
    public function getExternalId()
    {
        return $this->externalId;
    }

    /**
     * Set is individual label
     *
     * @param mixed $value
     * @return Company
     */
    public function setIsIndividual($value)
    {
        $this->isIndividual = (boolean) $value;

        return $this;
    }

    /**
     * Get is individual label
     *
     * @return string
     */
    public function getIsIndividual()
    {
        return $this->isIndividual;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Company
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
     * Set alt name
     *
     * @param string $altName
     * @return Company
     */
    public function setAltName($altName)
    {
        $this->altName = $this->removeSpaces($altName);

        return $this;
    }

    /**
     * Get alt name
     *
     * @return string
     */
    public function getAltName()
    {
        return $this->altName;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Company
     */
    public function setDescription($description)
    {
        $this->description = $this->removeSpaces($description);

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set credit sum
     *
     * @param float $creditSum
     * @return Company
     */
    public function setCreditSum($creditSum)
    {
        $this->creditSum = (float) $creditSum;
        if ($this->creditSum < 0) {
            $this->creditSum = 0;
        }

        return $this;
    }

    /**
     * Get credit sum
     *
     * @return float
     */
    public function getCreditSum()
    {
        return $this->creditSum;
    }

    /**
     * Set receivables
     *
     * @param int $receivables
     * @return Company
     */
    public function setReceivables($receivables)
    {
        $this->receivables = (float) $receivables;
        if ($this->receivables < 0) {
            $this->receivables = 0;
        }

        return $this;
    }

    /**
     * Get receivables
     *
     * @return int
     */
    public function getReceivables()
    {
        return $this->receivables;
    }

    /**
     * Set overdue receivables
     *
     * @param int $overdueReceivables
     * @return Company
     */
    public function setOverdueReceivables($overdueReceivables)
    {
        $this->overdueReceivables = (float) $overdueReceivables;
        if ($this->overdueReceivables < 0) {
            $this->overdueReceivables = 0;
        }

        return $this;
    }

    /**
     * Get overdue receivables
     *
     * @return int
     */
    public function getOverdueReceivables()
    {
        return $this->overdueReceivables;
    }

    /**
     * Set overdue duration
     *
     * @param int $overdueDuration
     * @return Company
     */
    public function setOverdueDuration($overdueDuration)
    {
        $this->overdueDuration = (int) $overdueDuration;
        if ($this->overdueDuration < 0) {
            $this->overdueDuration = 0;
        }

        return $this;
    }

    /**
     * Get overdue duration
     *
     * @return int
     */
    public function getOverdueDuration()
    {
        return $this->overdueDuration;
    }

    /**
     * Set note
     *
     * @param string $note
     * @return Company
     */
    public function setNote($note)
    {
        $this->note = $this->removeSpaces($note);

        return $this;
    }

    /**
     * Get note
     *
     * @return string
     */
    public function getNote()
    {
        return $this->note;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     * @return Company
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
     * Set type
     *
     * @param \Connector\Gateway\Entity\PriceType $priceType
     * @return Company
     */
    public function setPriceType(\Connector\Gateway\Entity\PriceType $priceType = null)
    {
        $this->priceType = $priceType;

        return $this;
    }

    /**
     * Get type
     *
     * @return \Connector\Gateway\Entity\PriceType
     */
    public function getPriceType()
    {
        return $this->priceType;
    }

    /**
     * Add addresses
     *
     * @param \Connector\Gateway\Entity\Address $address
     * @return Company
     */
    public function addAddress(\Connector\Gateway\Entity\Address $address)
    {
        $this->addresses[] = $address;

        return $this;
    }

    /**
     * Remove address
     *
     * @param \Connector\Gateway\Entity\Address $address
     */
    public function removeAddress(\Connector\Gateway\Entity\Address $address)
    {
        $this->addresses->removeElement($address);
    }

    /**
     * Get addresses
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getAddresses()
    {
        return $this->addresses;
    }

    /**
     * Add legal entity
     *
     * @param \Connector\Gateway\Entity\LegalEntity $legalEntity
     * @return Company
     */
    public function addLegalEntity(\Connector\Gateway\Entity\LegalEntity $legalEntity)
    {
        $this->legalEntities[] = $legalEntity;

        return $this;
    }

    /**
     * Remove legal entity
     *
     * @param \Connector\Gateway\Entity\LegalEntity $legalEntity
     */
    public function removeLegalEntity(\Connector\Gateway\Entity\LegalEntity $legalEntity)
    {
        $this->legalEntities->removeElement($legalEntity);
    }

    /**
     * Get legalEntities
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getLegalEntities()
    {
        return $this->legalEntities;
    }
}
