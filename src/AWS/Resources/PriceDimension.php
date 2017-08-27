<?php

namespace Lavoaster\AWSClientPricing\AWS\Resources;

class PriceDimension
{
    /**
     * @var string
     */
    private $rateCode;

    /**
     * @var string
     */
    private $description;

    /**
     * @var float|null
     */
    private $beginRange;

    /**
     * @var float|null
     */
    private $endRange;

    /**
     * @var string
     */
    private $unit;

    /**
     * @var array
     */
    private $pricePerUnit;

    /**
     * @var array
     */
    private $appliesTo;

    public function __construct(
        string $rateCode,
        string $description,
        ?float $beginRange,
        ?float $endRange,
        string $unit,
        array $pricePerUnit,
        array $appliesTo
    )
    {
        $this->rateCode = $rateCode;
        $this->description = $description;
        $this->beginRange = $beginRange;
        $this->endRange = $endRange;
        $this->unit = $unit;
        $this->pricePerUnit = $pricePerUnit;
        $this->appliesTo = $appliesTo;
    }

    /**
     * @return string
     */
    public function getRateCode(): string
    {
        return $this->rateCode;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @return float|null
     */
    public function getBeginRange()
    {
        return $this->beginRange;
    }

    /**
     * @return float|null
     */
    public function getEndRange()
    {
        return $this->endRange;
    }

    /**
     * @return string
     */
    public function getUnit(): string
    {
        return $this->unit;
    }

    /**
     * @return array
     */
    public function getPricePerUnit(): array
    {
        return $this->pricePerUnit;
    }

    /**
     * @return array
     */
    public function getAppliesTo(): array
    {
        return $this->appliesTo;
    }
}