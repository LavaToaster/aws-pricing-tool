<?php

namespace Lavoaster\AWSClientPricing\AWS\Factories;

use Lavoaster\AWSClientPricing\AWS\Resources\ProductOfferTerm;

class TermFactory
{
    public function fromArrayData(array $data)
    {
        $offeringTerms = [];

        foreach ($data as $type => $terms) {
            $offeringTerms[] = $this->processTerms($terms);
        }

        $offeringTerms = array_merge_recursive(...$offeringTerms);

        return $offeringTerms;
    }

    private function processTerms(array $terms)
    {
        $offeringTerms = [];

        foreach ($terms as $sku => $productTerms) {
            foreach ($productTerms as $productTermSku => $productTerm) {
                $offerTermCode = $productTerm['offerTermCode'];

                $offeringTerms[$sku][$offerTermCode] = new ProductOfferTerm(
                    $offerTermCode,
                    $sku,
                    $productTerm['effectiveDate'],
                    (new PriceDimensionFactory())->fromArrayData($productTerm['priceDimensions']),
                    $productTerm['termAttributes']
                );
            }
        }

        return $offeringTerms;
    }

    public function humanRegionToCode(string $region): string
    {
        return $this->regionMap[$region] ?? dd($region);
    }
}
