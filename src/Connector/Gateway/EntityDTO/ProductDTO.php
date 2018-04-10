<?php
/**
 * @copyright Copyright (c) 2011 ООО «ТриДаВинчи»
 * Author: Andrey Morozov
 */

namespace Connector\Gateway\EntityDTO;

/**
 * Class ProductDTO
 * @package Connector\Gateway\EntityDTO
 */
class ProductDTO
{
    public $article;
    public $externalId;
    public $name;
    public $manufacturerCode;
    public $altManufacturerCode;
    public $multyplicity;
    public $unitName;
    public $countryCodeA3;
    public $nameOfManufacturer;
    public $imageUrl;

    public $brandId;
    public $catalogSectionId;

    public $gallery = [];
    public $features = [];
    public $productIdentifiers = [];
    public $additionalFields = [];

    /**
     * ProductDTO constructor.
     * @param string $article
     * @param string $externalId
     * @param array $data
     */
    public function __construct(string $article, string $externalId, $data = [])
    {
        foreach ($data as $key => $item) {
            if(property_exists($this, $key)) {
                $this->$key = $item;
            }
        }

        $this->article = $article;
        $this->externalId = $externalId;
    }
}