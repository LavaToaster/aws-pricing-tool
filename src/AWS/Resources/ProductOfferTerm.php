<?php

namespace Lavoaster\AWSClientPricing\AWS\Resources;

class ProductOfferTerm
{
    /**
     * @var string
     */
    private $offerTermCode;

    /**
     * @var string
     */
    private $sku;

    /**
     * @var string
     */
    private $effectiveDate;

    /**
     * @var PriceDimension[]
     */
    private $priceDimensions;

    /**
     * @var array
     */
    private $termAttributes;

    public function __construct(
        string $offerTermCode,
        string $sku,
        string $effectiveDate,
        array $priceDimensions,
        array $termAttributes
    )
    {
        $this->offerTermCode = $offerTermCode;
        $this->sku = $sku;
        $this->effectiveDate = $effectiveDate;
        $this->priceDimensions = $priceDimensions;
        $this->termAttributes = $termAttributes;
    }

    /**
     * @return string
     */
    public function getOfferTermCode(): string
    {
        return $this->offerTermCode;
    }

    /**
     * @return string
     */
    public function getSku(): string
    {
        return $this->sku;
    }

    /**
     * @return string
     */
    public function getEffectiveDate(): string
    {
        return $this->effectiveDate;
    }

    /**
     * @return PriceDimension[]
     */
    public function getPriceDimensions(): array
    {
        return $this->priceDimensions;
    }

    /**
     * @return array
     */
    public function getTermAttributes(): array
    {
        return $this->termAttributes;
    }
}