<?php
/**
 * @copyright Copyright (c) 2011 ООО «ТриДаВинчи»
 * @author Andrey Morozov
 */

namespace Connector\Gateway\Entity;

/**
 * Class Product
 * @package Connector\Gateway\Entity
 */
class Product extends B2bGatewayEntity
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
     * @var string
     */
    private $article;

    /**
     * @var string
     */
    private $manufacturerCode;

    /**
     * @var string
     */
    private $altManufacturerCode;

    /**
     * @var string
     */
    private $manufacturer;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $nameOfManufacturer;

    /**
     * @var string
     */
    private $altNameOfManufacturer;

    /**
     * @var string
     */
    private $unitName;

    /**
     * @var integer
     */
    private $unitId;

    /**
     * @var integer
     */
    private $multiplicity = 1;

    /**
     * @var string
     */
    private $imageUrl;

    /**
     * @var string
     */
    private $countryCodeA3;

    /**
     * @var string
     */
    private $stockStatus;

    /**
     * @var \DateTime
     */
    private $updatedAt;

    /**
     * @var Brand
     */
    private $brand;

    /**
     * @var \Connector\Gateway\Entity\CatalogSection
     */
    private $catalogSection;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $productIdentifiers;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $productAdditionalFields;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->productIdentifiers = new \Doctrine\Common\Collections\ArrayCollection();
        $this->productAdditionalFields = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return Product
     */
    public function setId($id)
    {
        $this->id = (int) $id;

        return $this;
    }

    /**
     * Set external id
     *
     * @param string $externalId
     * @return Product
     */
    public function setExternalId($externalId)
    {
        $this->externalId = $this->removeSpaces($externalId);

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
     * Set article
     *
     * @param string $article
     * @return Product
     */
    public function setArticle($article)
    {
        $this->article = $this->removeSpaces($article);

        return $this;
    }

    /**
     * Get article
     *
     * @return string 
     */
    public function getArticle()
    {
        return $this->article;
    }

    /**
     * Set manufacturer code
     *
     * @param string $manufacturerCode
     * @return Product
     */
    public function setManufacturerCode($manufacturerCode)
    {
        if ($manufacturerCode !== 'нет данных') {
            $this->manufacturerCode = $manufacturerCode;
        }

        return $this;
    }

    /**
     * Get manufacturerCode
     *
     * @return string 
     */
    public function getManufacturerCode()
    {
        return $this->manufacturerCode;
    }

    /**
     * Set altManufacturerCode
     *
     * @param string $altManufacturerCode
     * @return Product
     */
    public function setAltManufacturerCode($altManufacturerCode)
    {
        $this->altManufacturerCode = $altManufacturerCode;

        return $this;
    }

    /**
     * Get altManufacturerCode
     *
     * @return string 
     */
    public function getAltManufacturerCode()
    {
        return $this->altManufacturerCode;
    }

    /**
     * Set manufacturer name
     *
     * @param string $manufacturer
     * @return Product
     */
    public function setManufacturer($manufacturer)
    {
        $this->manufacturer = $this->removeSpaces($manufacturer);

        return $this;
    }

    /**
     * Get manufacturer
     *
     * @return string 
     */
    public function getManufacturer()
    {
        return $this->manufacturer;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Product
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
     * Set nameOfManufacturer
     *
     * @param string $nameOfManufacturer
     * @return Product
     */
    public function setNameOfManufacturer($nameOfManufacturer)
    {
        $this->nameOfManufacturer = $this->removeSpaces($nameOfManufacturer);

        return $this;
    }

    /**
     * Get nameOfManufacturer
     *
     * @return string 
     */
    public function getNameOfManufacturer()
    {
        return $this->nameOfManufacturer;
    }

    /**
     * Set altNameOfManufacturer
     *
     * @param string $altNameOfManufacturer
     * @return Product
     */
    public function setAltNameOfManufacturer($altNameOfManufacturer)
    {
        $this->altNameOfManufacturer = $this->removeSpaces($altNameOfManufacturer);

        return $this;
    }

    /**
     * Get altNameOfManufacturer
     *
     * @return string 
     */
    public function getAltNameOfManufacturer()
    {
        return $this->altNameOfManufacturer;
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getUnitId()
    {
        return $this->unitId;
    }

    /**
     * Set unit id
     *
     * @param int $unitId
     * @return Product
     */
    public function setUnitId($unitId)
    {
        $this->unitId = (int) $unitId;

        return $this;
    }

    /**
     * Set unit name
     *
     * @param string $unitName
     * @return Product
     */
    public function setUnitName($unitName)
    {
        $this->unitName = trim($unitName);

        return $this;
    }

    /**
     * Get unitName
     *
     * @return string 
     */
    public function getUnitName()
    {
        return $this->unitName;
    }

    /**
     * Set multiplicity
     *
     * @param integer|string $multiplicity
     * @return Product
     */
    public function setMultiplicity($multiplicity)
    {
        $this->multiplicity = (int) $multiplicity;
        if ($this->multiplicity <= 0) {
            $this->multiplicity = 1;
        }

        return $this;
    }

    /**
     * Get multiplicity
     *
     * @return integer 
     */
    public function getMultiplicity()
    {
        return $this->multiplicity;
    }

    /**
     * Set imageUrl
     *
     * @param string $imageUrl
     * @return Product
     */
    public function setImageUrl($imageUrl)
    {
        $this->imageUrl = $imageUrl;

        return $this;
    }

    /**
     * Get imageUrl
     *
     * @return string 
     */
    public function getImageUrl()
    {
        return $this->imageUrl;
    }

    /**
     * Set country code in format A3
     *
     * @param string $countryCodeA3
     * @return Product
     */
    public function setCountryCodeA3($countryCodeA3)
    {
        if (preg_match('/^[A-Z]{3}$/', $countryCodeA3)) {
            $this->countryCodeA3 = $countryCodeA3;
        }

        return $this;
    }

    /**
     * Get country code in format A3
     *
     * @return string 
     */
    public function getCountryCodeA3()
    {
        return $this->countryCodeA3;
    }

    /**
     * Set stock status
     *
     * @param string $status
     * @return Product
     */
    public function setStockStatus($status)
    {
        $this->stockStatus = $status;

        return $this;
    }

    /**
     * Get stock status
     *
     * @return string
     */
    public function getStockStatus()
    {
        return $this->stockStatus;
    }

    /**
     * Set updated at
     *
     * @param \DateTime $updatedAt
     * @return Product
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updated at
     *
     * @return \DateTime 
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Set brand
     *
     * @param Brand $brand
     * @return Product
     */
    public function setBrand(Brand $brand = null)
    {
        $this->brand = $brand;

        return $this;
    }

    /**
     * Get brand
     *
     * @return Brand
     */
    public function getBrand()
    {
        return $this->brand;
    }

    /**
     * Set catalog section
     *
     * @param \Connector\Gateway\Entity\CatalogSection $catalogSection
     * @return Product
     */
    public function setCatalogSection(CatalogSection $catalogSection)
    {
        $this->catalogSection = $catalogSection;

        return $this;
    }

    /**
     * Get catalog sections
     *
     * @return \Connector\Gateway\Entity\CatalogSection
     */
    public function getCatalogSection()
    {
        return $this->catalogSection;
    }

    /**
     * Add product identifier
     *
     * @param ProductIdentifiers $productIdentifiers
     * @return Product
     */
    public function addProductIdentifiers(ProductIdentifiers $productIdentifiers)
    {
        $this->productIdentifiers[] = $productIdentifiers;

        return $this;
    }

    /**
     * Remove product identifier
     *
     * @param ProductIdentifiers $productIdentifiers
     */
    public function removeProductIdentifiers(ProductIdentifiers $productIdentifiers)
    {
        $this->productIdentifiers->removeElement($productIdentifiers);
    }

    /**
     * Get product identifiers
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getProductIdentifiers()
    {
        return $this->productIdentifiers;
    }

    /**
     * Add additional field
     *
     * @param ProductAdditionalField $productAdditionalField
     * @return Product
     */
    public function addProductAdditionalField(ProductAdditionalField $productAdditionalField)
    {
        $this->productAdditionalFields[] = $productAdditionalField;

        return $this;
    }

    /**
     * Remove additional field
     *
     * @param ProductAdditionalField $productAdditionalField
     */
    public function removeProductAdditionalFields(ProductAdditionalField $productAdditionalField)
    {
        $this->productAdditionalFields->removeElement($productAdditionalField);
    }

    /**
     * Get additional fields
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getProductAdditionalFields()
    {
        return $this->productAdditionalFields;
    }
}
