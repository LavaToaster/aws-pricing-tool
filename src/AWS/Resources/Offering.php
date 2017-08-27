<?php

namespace Lavoaster\AWSClientPricing\AWS\Resources;

class Offering
{
    /**
     * @var string
     */
    private $offerCode;

    /**
     * @var string
     */
    private $version;

    /**
     * @var string
     */
    private $publicationDate;

    /**
     * @var Product[]
     */
    private $products;

    /**
     * @var array[]
     */
    private $terms;

    public function __construct(
        string $offerCode,
        string $version,
        string $publicationDate,
        array $products,
        array $terms
    )
    {
        $this->offerCode = $offerCode;
        $this->version = $version;
        $this->publicationDate = $publicationDate;
        $this->products = $products;
        $this->terms = $terms;
    }

    /**
     * @return string
     */
    public function getOfferCode(): string
    {
        return $this->offerCode;
    }

    /**
     * @return string
     */
    public function getVersion(): string
    {
        return $this->version;
    }

    /**
     * @return string
     */
    public function getPublicationDate(): string
    {
        return $this->publicationDate;
    }

    /**
     * @return Product[]
     */
    public function getProducts(): array
    {
        return $this->products;
    }

    /**
     * @return array[]
     */
    public function getAllTerms(): array
    {
        return $this->terms;
    }

    /**
     * @return ProductOfferTerm[]
     */
    public function getTerms(string $code): array
    {
        return $this->terms[$code];
    }

    public function findProductsByAttribute(string $key, string $value)
    {
        foreach ($this->products as $sku => $product) {
            $attributes = $product->getAttributes();

            if (!isset($attributes[$key]) || $attributes[$key] !== $value) {
                continue;
            }

            yield $product;
        }
    }

    public function findProductsByAttributes(array $findAttributes)
    {
        foreach ($this->products as $sku => $product) {
            $attributes = $product->getAttributes();

            foreach ($findAttributes as $key => $value) {
                if (!isset($attributes[$key]) || $attributes[$key] !== $value) {
                    continue 2;
                }
            }

            yield $product;
        }
    }
}
