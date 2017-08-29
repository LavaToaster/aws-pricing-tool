<?php

namespace Lavoaster\AWSClientPricing\Definition;

use Lavoaster\AWSClientPricing\AWS\Constants\Offers;
use Lavoaster\AWSClientPricing\AWS\Constants\Regions;
use Lavoaster\AWSClientPricing\AWS\Constants\Terms;

class AllOnDemand
{
    public static function getAll()
    {
        return [
            'OD' => self::od(),
            'RS1' => self::rs1(),
        ];
    }

    public static function od(): array
    {
        $locationMap = array_flip(Regions::LOCATION_NAME_TO_REGION_CODE);

        return [
            'items' => [
                Offers::AmazonEC2 => [
                    'items' => [
                        [
                            'criteria' => [
                                'location' => $locationMap[Regions::EU_WEST_1],
                                'instanceType' => 't2.micro',
                                'operatingSystem' => 'Linux',
                                'tenancy' => 'Shared',
                            ],
                            'term' => Terms::ON_DEMAND,
                            'units' => 2,
                        ],
                        [
                            'criteria' => [
                                'location' => $locationMap[Regions::EU_WEST_1],
                                'instanceType' => 't2.small',
                                'operatingSystem' => 'Linux',
                                'tenancy' => 'Shared',
                            ],
                            'term' => Terms::ON_DEMAND,
                            'units' => 1,
                        ],
                        [
                            'criteria' => [
                                'location' => $locationMap[Regions::EU_WEST_1],
                                'instanceType' => 't2.medium',
                                'operatingSystem' => 'Linux',
                                'tenancy' => 'Shared',
                            ],
                            'term' => Terms::ON_DEMAND,
                            'units' => 10,
                        ],
                        [
                            'criteria' => [
                                'location' => $locationMap[Regions::EU_WEST_1],
                                'instanceType' => 'm3.medium',
                                'operatingSystem' => 'Linux',
                                'tenancy' => 'Shared',
                            ],
                            'term' => Terms::ON_DEMAND,
                            'units' => 6,
                        ],
                        [
                            'criteria' => [
                                'location' => $locationMap[Regions::EU_WEST_1],
                                'instanceType' => 'c4.large',
                                'operatingSystem' => 'Linux',
                                'tenancy' => 'Shared',
                            ],
                            'term' => Terms::ON_DEMAND,
                            'units' => 1,
                        ],
                        [
                            'criteria' => [
                                'location' => $locationMap[Regions::EU_WEST_1],
                                'instanceType' => 'c4.xlarge',
                                'operatingSystem' => 'Linux',
                                'tenancy' => 'Shared',
                            ],
                            'term' => Terms::ON_DEMAND,
                            'units' => 1,
                        ],
                    ],
                ],
                Offers::AmazonRDS => [
                    'items' => [
                        [
                            'criteria' => [
                                'location' => $locationMap[Regions::EU_WEST_1],
                                'instanceType' => 'db.t2.micro',
                                'databaseEngine' => 'PostgreSQL',
                                'deploymentOption' => 'Single-AZ',
                            ],
                            'term' => Terms::ON_DEMAND,
                            'units' => 7,
                        ],
                        [
                            'criteria' => [
                                'location' => $locationMap[Regions::EU_WEST_1],
                                'instanceType' => 'db.t2.micro',
                                'databaseEngine' => 'PostgreSQL',
                                'deploymentOption' => 'Multi-AZ',
                            ],
                            'term' => Terms::ON_DEMAND,
                            'units' => 1,
                        ],
                        [
                            'criteria' => [
                                'location' => $locationMap[Regions::EU_WEST_1],
                                'instanceType' => 'db.t2.large',
                                'databaseEngine' => 'PostgreSQL',
                                'deploymentOption' => 'Multi-AZ',
                            ],
                            'term' => Terms::ON_DEMAND,
                            'units' => 3,
                        ],
                    ],
                ],
                Offers::AmazonElastiCache => [
                    'items' => [
                        [
                            'criteria' => [
                                'location' => $locationMap[Regions::EU_WEST_1],
                                'instanceType' => 'cache.t2.micro',
                                'cacheEngine' => 'Redis',
                            ],
                            'term' => Terms::ON_DEMAND,
                            'units' => 6,
                        ],
                        [
                            'criteria' => [
                                'location' => $locationMap[Regions::EU_WEST_1],
                                'instanceType' => 'cache.t2.small',
                                'cacheEngine' => 'Redis',
                            ],
                            'term' => Terms::ON_DEMAND,
                            'units' => 2,
                        ],
                        [
                            'criteria' => [
                                'location' => $locationMap[Regions::EU_WEST_1],
                                'instanceType' => 'cache.t2.medium',
                                'cacheEngine' => 'Redis',
                            ],
                            'term' => Terms::ON_DEMAND,
                            'units' => 1,
                        ],
                    ],
                ],
            ],
        ];
    }

    public static function rs1(): array
    {
        $locationMap = array_flip(Regions::LOCATION_NAME_TO_REGION_CODE);

        return [
            'items' => [
                Offers::AmazonEC2 => [
                    'items' => [
                        [
                            'criteria' => [
                                'location' => $locationMap[Regions::EU_WEST_1],
                                'instanceType' => 't2.micro',
                                'operatingSystem' => 'Linux',
                                'tenancy' => 'Shared',
                            ],
                            'term' => Terms::STANDARD_1_YEAR_PARTIAL_UPFRONT,
                            'units' => 2,
                        ],
                        [
                            'criteria' => [
                                'location' => $locationMap[Regions::EU_WEST_1],
                                'instanceType' => 't2.small',
                                'operatingSystem' => 'Linux',
                                'tenancy' => 'Shared',
                            ],
                            'term' => Terms::STANDARD_1_YEAR_PARTIAL_UPFRONT,
                            'units' => 1,
                        ],
                        [
                            'criteria' => [
                                'location' => $locationMap[Regions::EU_WEST_1],
                                'instanceType' => 't2.medium',
                                'operatingSystem' => 'Linux',
                                'tenancy' => 'Shared',
                            ],
                            'term' => Terms::STANDARD_1_YEAR_PARTIAL_UPFRONT,
                            'units' => 10,
                        ],
                        [
                            'criteria' => [
                                'location' => $locationMap[Regions::EU_WEST_1],
                                'instanceType' => 'm3.medium',
                                'operatingSystem' => 'Linux',
                                'tenancy' => 'Shared',
                            ],
                            'term' => Terms::STANDARD_1_YEAR_PARTIAL_UPFRONT,
                            'units' => 6,
                        ],
                        [
                            'criteria' => [
                                'location' => $locationMap[Regions::EU_WEST_1],
                                'instanceType' => 'c4.large',
                                'operatingSystem' => 'Linux',
                                'tenancy' => 'Shared',
                            ],
                            'term' => Terms::STANDARD_1_YEAR_PARTIAL_UPFRONT,
                            'units' => 1,
                        ],
                        [
                            'criteria' => [
                                'location' => $locationMap[Regions::EU_WEST_1],
                                'instanceType' => 'c4.xlarge',
                                'operatingSystem' => 'Linux',
                                'tenancy' => 'Shared',
                            ],
                            'term' => Terms::STANDARD_1_YEAR_PARTIAL_UPFRONT,
                            'units' => 1,
                        ],
                    ],
                ],
                Offers::AmazonRDS => [
                    'items' => [
                        [
                            'criteria' => [
                                'location' => $locationMap[Regions::EU_WEST_1],
                                'instanceType' => 'db.t2.micro',
                                'databaseEngine' => 'PostgreSQL',
                                'deploymentOption' => 'Single-AZ',
                            ],
                            'term' => Terms::STANDARD_1_YEAR_PARTIAL_UPFRONT,
                            'units' => 7,
                        ],
                        [
                            'criteria' => [
                                'location' => $locationMap[Regions::EU_WEST_1],
                                'instanceType' => 'db.t2.micro',
                                'databaseEngine' => 'PostgreSQL',
                                'deploymentOption' => 'Multi-AZ',
                            ],
                            'term' => Terms::STANDARD_1_YEAR_PARTIAL_UPFRONT,
                            'units' => 1,
                        ],
                        [
                            'criteria' => [
                                'location' => $locationMap[Regions::EU_WEST_1],
                                'instanceType' => 'db.t2.large',
                                'databaseEngine' => 'PostgreSQL',
                                'deploymentOption' => 'Multi-AZ',
                            ],
                            'term' => Terms::STANDARD_1_YEAR_PARTIAL_UPFRONT,
                            'units' => 3,
                        ],
                    ],
                ],
                Offers::AmazonElastiCache => [
                    'items' => [
                        [
                            'criteria' => [
                                'location' => $locationMap[Regions::EU_WEST_1],
                                'instanceType' => 'cache.t2.micro',
                                'cacheEngine' => 'Redis',
                            ],
                            'term' => Terms::ON_DEMAND,
                            'units' => 6,
                        ],
                        [
                            'criteria' => [
                                'location' => $locationMap[Regions::EU_WEST_1],
                                'instanceType' => 'cache.t2.small',
                                'cacheEngine' => 'Redis',
                            ],
                            'term' => Terms::ON_DEMAND,
                            'units' => 2,
                        ],
                        [
                            'criteria' => [
                                'location' => $locationMap[Regions::EU_WEST_1],
                                'instanceType' => 'cache.t2.medium',
                                'cacheEngine' => 'Redis',
                            ],
                            'term' => Terms::ON_DEMAND,
                            'units' => 1,
                        ],
                    ],
                ],
            ],
        ];
    }
}
