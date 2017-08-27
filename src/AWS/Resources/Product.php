<?php

namespace Lavoaster\AWSClientPricing\AWS\Resources;

class Product
{
    /**
     * @var string
     */

    protected $sku;

    /**
     * @var string
     */
    protected $productFamily;

    /**
     * @var array
     */
    protected $attributes;

    public function __construct(array $data)
    {
        $this->sku = $data['sku'];
        $this->productFamily = $data['productFamily'];
        $this->attributes = $data['attributes'] ?? [];
    }

    public function getSku(): string
    {
        return $this->sku;
    }

    public function getProductFamily(): string
    {
        return $this->productFamily;
    }

    public function getAttributes(): array
    {
        return $this->attributes;
    }
}