<?php

namespace Lavoaster\AWSClientPricing\AWS\Factories;

use Lavoaster\AWSClientPricing\AWS\Resources\Offering;
use League\Flysystem\Filesystem;

class PriceFactory
{
    protected $offerings = [];
    protected $instances = [];
    /**
     * @var Filesystem
     */
    private $filesystem;

    public function __construct(Filesystem $filesystem)
    {
        $this->filesystem = $filesystem;
    }

    /**
     * @return Offering
     */
    public function getOffering($key): Offering
    {
        if (!isset($this->offerings[$key])) {
            $this->loadOffering($key);
        }

        return $this->offerings[$key];
    }

    public function loadOffering($key)
    {
        $data = json_decode($this->filesystem->read('cache/prices/' . $key . '.json'), true);

        if ($data === null) {
            throw new \Exception('File not found or there was invalid json in it');
        }

//        $terms = [];
//
//        foreach ($data['terms']['Reserved'] as $reservedTerms) {
//            foreach ($reservedTerms as $sku => $term) {
//                $terms[$term['offerTermCode']] = $term['termAttributes'];
//            }
//        }
//
//        dd($terms, array_keys($data['terms']));

        $products = (new ProductFactory())->fromArrayData($data['products']);
        $terms = (new TermFactory())->fromArrayData($data['terms']);

        $offering = new Offering(
            $data['offerCode'],
            $data['version'],
            $data['publicationDate'],
            $products,
            $terms
        );

        $this->addOffering($key, $offering);
    }

    public function addOffering($key, $value)
    {
        $this->offerings[$key] = $value;
    }

    public function getDefaultRegion()
    {
        return 'eu-west-1';
    }
}
