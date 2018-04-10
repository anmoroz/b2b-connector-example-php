<?php
/**
 * @copyright Copyright (c) 2011 ООО «ТриДаВинчи»
 * Author: Andrey Morozov
 */

namespace Connector;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Connector\Gateway\EntityDTO\ProductDTO;

class RaecHttpClient
{
    const RANGE_SEPARATOR = '...';

    const LOCALIZATION = 1;
    const CERTIFICATE_TYPE_ID = 2;

    const RAEC_FILTER_FIELDS = [
        'raecId',
        'supplierId',
        'supplierAltId',
        'multyplicity',
        'etmCode',
        'russvetCode',
        'descriptionRu',
        'descriptionAuto',
        'descriptionShort',
        'orderUnit',
        'brand',
        'etimclass',
        'seriesMarketing',
        'featuresSort',
        'country',
        'individualCodes',
        'image',
        'gallery',
        'deliveryTime',
    ];

    /**
     * @var Client
     */
    private $guzzleClient;

    /**
     * Guzzle client options
     *
     * @var array
     */
    private $options = [];

    /**
     * @var int
     */
    private $fromDays;

    /**
     * @var array
     */
    private $etimClasses = [];

    /**
     * RaecHttpClient constructor.
     *
     * @param array $params
     */
    public function __construct(array $params)
    {
        $this->guzzleClient = new Client(['base_uri' => $params['baseUri']]);
        $this->options['headers'] = [
            'Content-Type' => 'application/json',
            'Api-Key' => $params['apiKey'],
        ];
        $this->options['query'] = [
            'filter[rusLocalization]' => self::LOCALIZATION,
            'filter[fields]' => implode(',', self::RAEC_FILTER_FIELDS),
        ];
    }

    /**
     * @param int $id
     * @return array|boolean
     */
    public function findByRaecId($id)
    {
        $options = $this->options;

        $response = $this->guzzleClient->request('GET', 'product/' . $id, $options);
        if ($response->getStatusCode() == 200) {
            $content = $response->getBody()->getContents();
            if ($product = $this->decode($content)) {

                return $this->normalizeProduct($product);
            }
        }

        return false;
    }

    /**
     * @return \Generator
     */
    public function itrateBrands()
    {
        unset($this->options['query']);

        // Для брендов нет постраничной навигации
        $response = $this->guzzleClient->request('GET', 'brand', $this->options);
        if ($response->getStatusCode() == 200) {
            $content = $response->getBody()->getContents();
            if ($brands = $this->decode($content)) {
                foreach($brands as $brand) {
                    unset($brand['description'], $brand['series'], $brand['seriesMarketing']);

                    yield $brand;
                }
            }
        }
    }

    /**
     * @return \Generator
     */
    public function itrateCategories()
    {
        unset($this->options['query']);

        $response = $this->guzzleClient->request('GET', 'category', $this->options);
        if ($response->getStatusCode() == 200) {
            $content = $response->getBody()->getContents();
            if ($categories = $this->decode($content)) {
                foreach($categories as $category) {

                    yield [
                        'id' => $category['id'],
                        'name' => $category['name'],
                        'parentId' => null,
                    ];

                    if (isset($category['subcategory']) && !empty($category['subcategory'])) {
                        foreach ($category['subcategory'] as $item) {

                            yield [
                                'id' => $item['id'],
                                'name' => $item['name'],
                                'parentId' => $category['id'],
                            ];
                        }
                    }
                }
            }
        }
    }

    /**
     * @param int $id
     * @return array|boolean
     */
    public function findEtimClassId($id)
    {
        $options = $this->options;
        $options['query'] = [];

        $response = $this->guzzleClient->request('GET', 'etimclass/' . $id, $options);
        if ($response->getStatusCode() == 200) {
            $content = $response->getBody()->getContents();
            if ($ecimClass = $this->decode($content)) {

                return $ecimClass;
            }
        }

        return false;
    }

    /**
     * @return \Generator
     */
    public function iterate()
    {
        //$this->options['query']['filter[etimclass]'] = 'EC001062';

        $this->initEtimClasses();

        if ($this->fromDays) {
            $defaultTimezone = date_default_timezone_get();
            date_default_timezone_set('UTC');
            $this->options['query']['filter[updatedfrom]'] = strtotime("-{$this->fromDays} days", time());
            date_default_timezone_set($defaultTimezone);
        }

        $pages = $this->getProductPages();

        for ($i = 1; $i <= $pages; $i++) {
            try {
                $response = $this->guzzleClient->request('GET', 'product/page-' . $i, $this->options);
                if ($response->getStatusCode() == 200) {
                    $content = $response->getBody()->getContents();
                    if (($arrayProducts = $this->decode($content)) !== false) {
                        foreach ($arrayProducts as $product) {
                            if (!$product['descriptionRu']) {
                                continue;
                            }
                            $productData = $this->normalizeProduct($product);

                            yield new ProductDTO(
                                $productData['article'],
                                $productData['externalId'],
                                $productData
                            );
                        }
                    }
                }
            } catch (RequestException $e) {
                echo sprintf(
                    'Throw RequestException: "$s" on %s'.PHP_EOL,
                    $e->getMessage(),
                    date("Y.m.d H:i:s")
                );
                sleep(10);
            }
        }
    }

    /**
     * Кеширование всех ETIM-классов для получения синонимов и привязки к подразделам
     */
    private function initEtimClasses()
    {
        $options = $this->options;
        $options['query'] = [
            'filter[fields]' => implode(',', ['classId', 'subcategoryId', 'synonyms']),
        ];

        $response = $this->guzzleClient->request('GET', 'etimclass', $options);
        if ($response->getStatusCode() == 200) {
            $content = $response->getBody()->getContents();
            if ($etimClasses = $this->decode($content)) {
                foreach ($etimClasses as $item) {
                    $synonyms = [];
                    if ($item && isset($item['synonyms']) && !empty($item['synonyms'])) {
                        foreach ($item['synonyms'] as $synonym) {
                            array_push($synonyms, $synonym['name']);
                        }
                    }
                    $item['synonyms'] = $synonyms ? implode(', ', $synonyms) : null;
                    if (isset($item['features'])) {
                        unset($item['features']);
                    }

                    $this->etimClasses[$item['classId']] = $item;
                }
            }
        }
    }

    /**
     * @param array $data
     * @return array
     */
    private function normalizeProduct(array $data)
    {
        $product = [
            'article' => $data['raecId'],
            'externalId' => $data['raecId'],
            'name' => $data['descriptionRu'],
            'manufacturerCode' => $data['supplierId'],
            'altManufacturerCode' => $data['supplierAltId'],
            'multyplicity' => (int) $data['multyplicity'] > 0 ? (int) $data['multyplicity'] : 1,
            'unitName' => $data['orderUnit']['abbrR'] ?? '',
            'countryCodeA3' => $data['country']['codeA3'] ?? '',
        ];

        // Бренд
        $product['brandId'] = (isset($data['brand']) && isset($data['brand']['id']))
            ? (int) $data['brand']['id'] : null;

        // Свойства товара
        if (isset($data['featuresSort'])) {
            $data['features'] = $data['featuresSort'];
            unset($data['featuresSort']);
        }
        $product['features'] = $this->b2bFeatures($data);

        // Идентификаторы
        $productIdentifiers = [];
        $productIdentifiers['raec_id'] = $data['raecId'];
        if (trim($data['etmCode'])) {
            $productIdentifiers['etm_code'] = trim($data['etmCode']);
        }
        if (trim($data['russvetCode'])) {
            $productIdentifiers['russvet_code'] = trim($data['russvetCode']);
        }
        $product['productIdentifiers'] = $productIdentifiers;

        // Дополнительные поля
        $additionalFields = [];
        if (!empty($data['seriesMarketing']) && $data['seriesMarketing']['name'] != '-') {
            $additionalFields['series'] = trim($data['seriesMarketing']['name']);
        }
        if (!empty($data['etimclass'])) {
            $classData = $this->etimClasses[ $data['etimclass']['id'] ] ?? null;
            $additionalFields['etim'] = [
                'class' => [
                    'id'      => $data['etimclass']['id'],
                    'name'    => $data['etimclass']['descriptionRu'],
                    'name_en' => $data['etimclass']['descriptionEn'],
                    'synonyms' => $classData ? $classData['synonyms'] : '',
                ]
            ];

            // Принадлежность к разделу
            if ($classData) {
                $product['catalogSectionId'] = (int) $classData['subcategoryId'];
            }

            $featuresData = $this->raecFeatures($data);
            if ($featuresData['features']) {
                $additionalFields['etim']['features'] = $featuresData['features'];
            }
            if ($featuresData['features_search']) {
                $additionalFields['etim']['features_search'] = $featuresData['features_search'];
            }
        }
        if (trim($data['descriptionAuto'])) {
            $additionalFields['name_auto'] = trim($data['descriptionAuto']);
        }
        if ((int) $data['deliveryTime'] > 0) {
            $additionalFields['delivery_time'] = (int) $data['deliveryTime'];
        }
        $product['additionalFields'] = $additionalFields;

        // Название от производителя
        if (trim($data['descriptionShort'])) {
            $product['nameOfManufacturer'] = $data['descriptionShort'];
        }

        // Изображение
        if (isset($data['image']) && isset($data['image']['max'])) {
            $product['imageUrl'] = $data['image']['max'];
        }

        // Галерея
        $product['gallery'] = [];
        if (isset($data['gallery']) && !empty($data['gallery'])) {
            foreach ($data['gallery'] as $galleryItem) {
                if (isset($galleryItem['max'])) {
                    array_push($product['gallery'], $galleryItem['max']);
                }
            }
        }

        return $product;
    }

    /**
     * Find and set $additionalFields features in the raec format
     *
     * @param array $data
     * @return array
     */
    private function raecFeatures(array $data)
    {
        $featuresData = ['features' => [], 'features_search' => []];
        if (empty($data['features'])) {

            return $featuresData;
        }
        $features = [];
        $featuresSearchArray = [];

        foreach ($data['features'] as $featureItem) {
            $featureItem['value'] = trim($featureItem['value']);

            if (false === $this->isFeatureAllowed($featureItem['id'], $featureItem['type'], $featureItem['value'])) {
                continue;
            }

            if ($featureItem['type'] !== 'L' || ($featureItem['type'] === 'L' && $featureItem['value'] === 'true')) {
                array_push(
                    $featuresSearchArray,
                    $featureItem['id'],
                    $featureItem['descriptionRu'] ? $featureItem['descriptionRu'] : $featureItem['descriptionEn']
                );
            }

            switch($featureItem['type']) {
                case 'L':
                    $value = [
                        'boolean' => $featureItem['value'] === 'true' ? true : false
                    ];
                    break;
                case 'A':
                    if (!$featureItem['value']) {

                        $value = null;
                        break;
                    }
                    $value = [
                        'id' => $featureItem['value'],
                        'string' => $featureItem['valueDescriptionRu'] ? $featureItem['valueDescriptionRu'] : $featureItem['valueDescriptionEn']
                    ];
                    array_push($featuresSearchArray, $value['string'], $value['id']);
                    break;
                case 'R':
                    $range = explode(self::RANGE_SEPARATOR, $featureItem['value']);
                    $value = [
                        'range_min' => (float) $range[0],
                        'range_max' => isset($range[0]) ? (float) $range[0] : (float) $range[1],
                    ];
                    break;
                case 'N':
                    $value = [
                        'number' => (float) $featureItem['value']
                    ];
                    break;
                default:
                    $value = null;
            }
            if (is_null($value)) {

                continue;
            }

            $feature = [
                'id' => $featureItem['id'],
                'name' => $featureItem['descriptionRu'] ? $featureItem['descriptionRu'] : $featureItem['descriptionEn'],
                'type' => $featureItem['type'],
                'value' => $value,
            ];

            if ($featureItem['unit'] && isset($featureItem['unit']['descriptionRu'])) {
                $feature['unit'] = [
                    'id'   => $featureItem['unit']['id'],
                    'name' => $featureItem['unit']['descriptionRu'],
                ];
            }

            array_push($features, $feature);
        }

        $featuresData['features'] = $features;

        if (!empty($featuresSearchArray)) {
            $featuresData['features_search'] = implode(' ', $featuresSearchArray);
        }

        return $featuresData;
    }

    /**
     * Find and set product features in the b2b format
     *
     * @param array $data
     * @return array
     */
    private function b2bFeatures(array $data)
    {
        if (empty($data['features'])) {

            return [];
        }
        $features = [];
        foreach ($data['features'] as $featureItem) {
            $featureItem['value'] = trim($featureItem['value']);

            if (false === $this->isFeatureAllowed($featureItem['id'], $featureItem['type'], $featureItem['value'])) {
                continue;
            }

            switch($featureItem['type']) {
                case 'L':
                    $value = $featureItem['value'] === 'true' ? 'Да' : 'Нет';
                    break;
                case 'A':
                    $value = $featureItem['valueDescriptionRu'] ? $featureItem['valueDescriptionRu'] : $featureItem['valueDescriptionEn'];
                    break;
                case 'R':
                    $value = $featureItem['value'];
                    break;
                case 'N':
                    $value = (string) (float) $featureItem['value'];
                    break;
                default:
                    $value = '';
            }
            $features[] = [
                'name' => $featureItem['descriptionRu'] ? $featureItem['descriptionRu'] : $featureItem['descriptionEn'],
                'value' => $value,
                'unit' => ($featureItem['unit'] && isset($featureItem['unit']['descriptionRu']))
                    ? $featureItem['unit']['descriptionRu'] : ''
            ];
        }

        return $features;
    }

    /**
     * @param string $featureId
     * @param string $featureType
     * @param string $value
     * @return bool
     */
    private function isFeatureAllowed($featureId, $featureType, $value)
    {
        if (strtoupper(substr($featureId, 0, 2)) == 'AF') {

            return false;
        }

        if (empty($value) || in_array($value, ['-', '_', '*', 'Прочее'])) {

            return false;
        }

        if (!in_array($featureType, ['L', 'A', 'R', 'N'])) {

            return false;
        }

        return true;
    }

    /**
     * @param int $fromDays
     */
    public function setFromDays($fromDays)
    {
        $this->fromDays = (int) $fromDays;
    }

    /**
     * @return int
     */
    private function getProductPages()
    {
        $response = $this->guzzleClient->request('GET', 'product/pages', $this->options);

        return (int) $response->getBody()->getContents();
    }

    /**
     * Decodes the given JSON string into a PHP data structure.
     *
     * @param string $json
     * @param bool $asArray
     * @return mixed
     */
    private function decode($json, $asArray = true)
    {
        return json_decode((string) $json, $asArray);
    }
}