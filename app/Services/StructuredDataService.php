<?php

namespace App\Services;

use Brick\StructuredData\Reader\JsonLdReader;
use Brick\StructuredData\HTMLReader;

class StructuredDataService
{
    private const SKU_FIELD_NAME = 'https://schema.org/sku';
    private const OFFER_FIELD_NAME = 'https://schema.org/offers';
    private const PRICE_FIELD_NAME = 'https://schema.org/price';
    public function readDataFromJsonLd($url): array
    {
        $jsonLdReader = new JsonLdReader();
        $htmlReader = new HTMLReader($jsonLdReader);

        $html = file_get_contents($url);
        $items = $htmlReader->read($html, $url);

        $sku = $price = null;
        foreach ($items as $item) {
            foreach ($item->getProperties() as $name => $values) {
                if ($name == self::SKU_FIELD_NAME) {
                    $sku = $values[0];
                }
                if ($name == self::OFFER_FIELD_NAME) {
                    foreach ($values[0]->getProperties() as $offerField => $value) {
                        if ($offerField == self::PRICE_FIELD_NAME) {
                            $price = $value[0];
                        }
                    }
                }

            }
        }

        return [$sku, $price];
    }
}
