<?php

namespace Lavoaster\AWSClientPricing\AWS\Factories;

use Lavoaster\AWSClientPricing\AWS\Resources\PriceDimension;

class PriceDimensionFactory
{
    public function fromArrayData(array $data)
    {
        $priceDimensions = [];

        foreach ($data as $rateCode => $priceDimension) {
            $actualRateCode = explode('.', $rateCode)[2];
            $endRange = $priceDimension['endRange'] ?? null;

            if ($endRange === 'Inf') {
                $endRange = INF;
            }


            // I was going to use a money library like moneyphp/money, but it
            // and some others don't really want to deal with a unit lower
            // than cents. Which makes them useless for storing AWS
            // pricing.
            //
            // TODO: Use bcmath at some point in the future.

            $priceDimensions[$actualRateCode] = new PriceDimension(
                $priceDimension['rateCode'],
                $priceDimension['description'],
                $priceDimension['beginRange'] ?? null,
                $endRange,
                $priceDimension['unit'],
                $priceDimension['pricePerUnit'],
                $priceDimension['appliesTo']
            );
        }

        return $priceDimensions;
    }
}