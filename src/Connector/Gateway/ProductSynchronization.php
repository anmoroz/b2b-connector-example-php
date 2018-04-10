<?php
/**
 * @copyright Copyright (c) 2011 ООО «ТриДаВинчи»
 * Author: Andrey Morozov
 */

namespace Connector\Gateway;

use Doctrine\DBAL\Connection;
use Connector\Gateway\Mappers\ {ProductMapper, FeatureMapper, GalleryMapper, CertificateMapper};
use Connector\Gateway\Entity\ {
    Product,
    CatalogSection,
    Brand,
    ProductIdentifiers,
    ProductAdditionalField,
    Feature,
    Gallery,
    Certificate
};
use Connector\Gateway\EntityDTO\ProductDTO;

class ProductSynchronization
{
    /**
     * @var Connection
     */
    private $gatewayConnection;

    /**
     * @var ProductMapper
     */
    private $productMapper;

    /**
     * @var FeatureMapper
     */
    private $featureMapper;

    /**
     * @var GalleryMapper
     */
    private $galleryMapper;

    /**
     * @var CertificateMapper
     */
    private $certificateMapper;

    /**
     * @var string
     */
    private $error;

    public function __construct(Connection $gatewayConnection)
    {
        $this->gatewayConnection = $gatewayConnection;
        $this->productMapper = new ProductMapper($gatewayConnection);
        $this->featureMapper = new FeatureMapper($gatewayConnection);
        $this->galleryMapper = new GalleryMapper($gatewayConnection);
        $this->certificateMapper = new CertificateMapper($gatewayConnection);
    }

    /**
     * @param ProductDTO $productDTO
     * @param Product $product
     * @return bool
     */
    public function process(ProductDTO $productDTO, Product $product)
    {




        $fields = [
            'name',
            'manufacturerCode',
            'altManufacturerCode',
            'multyplicity',
            'unitName',
            'countryCodeA3',
            'nameOfManufacturer',
            'imageUrl',
            'brandId',
        ];
        $attributes = [];
        foreach ($fields as $field) {
            $attributes[$field] = $productDTO->$field;
        }
        $product->setAttributes($attributes);

        // Раздел каталога
        if ($productDTO->catalogSectionId) {
            $catalogSection = new CatalogSection();
            $catalogSection->setId($productDTO->catalogSectionId);
            $product->setCatalogSection($catalogSection);
        }

        // Бренд
        if ($productDTO->brandId) {
            $brand = new Brand();
            $brand->setId($productDTO->brandId);
            $product->setBrand($brand);
        }

        // Идентификаторф
        if ($productDTO->productIdentifiers) {
            foreach ($productDTO->productIdentifiers as $name => $value) {
                $productIdentifier = new ProductIdentifiers();
                $productIdentifier->setName($name);
                $productIdentifier->setValue($value);
                $product->addProductIdentifiers($productIdentifier);
            }
        }

        // Доп. поля (ETIM)
        if ($productDTO->additionalFields) {
            foreach ($productDTO->additionalFields as $name => $value) {
                $additionalField = new ProductAdditionalField();
                $additionalField->setName($name);
                $additionalField->setValue($value);
                $product->addProductAdditionalField($additionalField);
            }
        }

        try {
            $saved = $this->productMapper->save($product);
            if ($saved) {
                if ($productDTO->features) {
                    $this->updateFeatures($product, $productDTO->features);
                }
                if ($productDTO->gallery) {
                    $this->updateGallery($product, $productDTO->gallery);
                }
                if ($productDTO->certificates) {
                    $this->updateCertificates($product, $productDTO->certificates);
                }
            } else {

                return false;
            }
        } catch (\Exception $e) {
            $this->error = 'Exception: '.$e->getMessage();
            
            return false;
        }

        return true;
    }

    /**
     * @param Product $product
     * @param array $certificates
     */
    private function updateCertificates(Product $product, array $certificates)
    {
        $this->certificateMapper->deleteAllByProduct($product);

        foreach ($certificates as $certificateItem) {
            $certificate = new Certificate();
            $certificate->setProduct($product);
            $certificate->setAttributes($certificateItem);

            $this->certificateMapper->save($certificate);
        }
    }

    /**
     * @param Product $product
     * @param array $features
     */
    private function updateFeatures(Product $product, array $features)
    {
        // Очистить все старые свойства
        $this->featureMapper->deleteAllByProduct($product);

        foreach ($features as $key => $feature) {
            $gatewayFeature = new Feature();
            $gatewayFeature
                ->setName($feature['name'])
                ->setValue($feature['value'])
                ->setUnit($feature['unit'])
                ->setSort($key)
                ->setProduct($product);

            $this->featureMapper->save($gatewayFeature);
        }
    }

    /**
     * @param Product $product
     * @param array $galleryLinks
     */
    private function updateGallery(Product $product, array $galleryLinks)
    {
        $this->galleryMapper->deleteAllByProduct($product);

        foreach ($galleryLinks as $galleryLink) {
            $gallery = new Gallery();
            $gallery->setProduct($product);
            $gallery->setImageUrl($galleryLink);

            $this->galleryMapper->save($gallery);
        }
    }

    /**
     * @return string
     */
    public function getError()
    {
        return $this->error;
    }
}