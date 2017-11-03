<?php

namespace Lavoaster\AWSClientPricing\AWS;

use Lavoaster\AWSClientPricing\AWS\Constants\Rate;
use Lavoaster\AWSClientPricing\AWS\Factories\PriceFactory;
use Lavoaster\AWSClientPricing\AWS\Resources\Product;

class Calculator
{
    /**
     * @var PriceFactory
     */
    private $priceFactory;

    public function __construct(PriceFactory $priceFactory)
    {
        $this->priceFactory = $priceFactory;

        bcscale(10);
    }

    /**
     * @param array $data
     * @return array
     * @throws \Exception
     */
    public function calculate(array $data): array
    {
        foreach ($data['items'] as $service => &$resources) {
            $offering = $this->priceFactory->getOffering($service);

            foreach ($resources['items'] as $type => &$resource) {
                $products = iterator_to_array($offering->findProductsByAttributes($resource['criteria']));

                if (count($products) > 1) {
                    dump($products);

                    throw new \Exception('More than one product matched the criteria provided, please modify your filters so only one product is returned.');
                }

                if (count($products) === 0) {
                    throw new \Exception('No products matched the criteria provided');
                }

                /** @var Product $product */
                $product = $products[0];

                $terms = $offering->getTerms($product->getSku());
                $term = $terms[$resource['term']];

                $prices = $term->getPriceDimensions();

                $itemPricing = [];

                if (isset($prices[Rate::RATE_UPFRONT])) {
                    $pricing = $prices[Rate::RATE_UPFRONT];

                    $itemPricing['oneTime' . $term->getTermAttributes()['LeaseContractLength']] = $pricing->getPricePerUnit()['USD'];
                }

                if (isset($prices[Rate::RATE_HOURLY])) {
                    $pricing = $prices[Rate::RATE_HOURLY];

                    $itemPricing['hourly'] = $pricing->getPricePerUnit()['USD'];
                }

                array_walk($itemPricing, function (&$value) use ($resource) {
                    $value = bcmul($value, $resource['units']);
                });

                $itemPricing['term'] = null;

                if (isset($term->getTermAttributes()['LeaseContractLength'])) {
                    $itemPricing['term'] = $term->getTermAttributes()['LeaseContractLength'];
                }

                $resource['pricing'] = self::extrapolatePricing($itemPricing);
            }
            unset($resource);

            $resources['pricing'] = self::calculateTotal($resources['items']);
        }
        unset($resources);

        $data['pricing'] = self::calculateTotal($data['items']);

        return $data;
    }

    /**
     * @param array $pricing
     * @return array
     */
    public static function extrapolatePricing(array $pricing): array
    {
        $hoursInADay = 24;
        $hoursInAYear = $hoursInADay * 365;
        $averageHoursInAMonth = $hoursInAYear / 12;

        if (isset($pricing['hourly'])) {
            $pricing['daily'] = bcmul($pricing['hourly'], $hoursInADay);
            $pricing['monthly'] = bcmul($pricing['hourly'], $averageHoursInAMonth);
            $pricing['yearly'] = bcmul($pricing['hourly'], $hoursInAYear);
            $pricing['yearOne'] = $pricing['yearly'];

            if (isset($pricing['oneTime1yr'])) {
                $pricing['yearly'] = bcadd($pricing['yearly'], $pricing['oneTime1yr']);
                $pricing['yearOne'] = bcadd($pricing['yearOne'], $pricing['oneTime1yr']);
            }

            $pricing['yearThree'] = bcmul($pricing['yearly'], 3);

            if (isset($pricing['oneTime3yr'])) {
                $pricing['yearOne'] = bcadd($pricing['yearOne'], $pricing['oneTime3yr']);
                $pricing['yearThree'] = bcadd($pricing['yearThree'], $pricing['oneTime3yr']);
            }
        }

        return $pricing;
    }

    /**
     * @param array $resources
     * @return array
     */
    public static function calculateTotal(array $resources): array
    {
        $pricing = [];

        foreach ($resources as $resource) {
            foreach ($resource['pricing'] as $key => $value) {
                if ($key === 'term') {
                    continue;
                }

                if (!isset($pricing[$key])) {
                    $pricing[$key] = '0.00';
                }

                $pricing[$key] = bcadd($pricing[$key], $value);
            }
        }

        return $pricing;
    }
}
