<?php

namespace Lavoaster\AWSClientPricing\AWS\Factories;

use Lavoaster\AWSClientPricing\AWS\Resources\Product;

class ProductFactory
{
    public function fromArrayData(array $data)
    {
        $products = [];

        foreach ($data as $sku => $product) {
            $products[$sku] = new Product($product);
        }

        return $products;
    }
}
