<?php

namespace Lavoaster\AWSClientPricing\AWS\Constants;

class Regions
{
    const GLOBAL = 'global';

    const US_EAST_1 = 'us-east-1';
    const US_EAST_2 = 'us-east-2';
    const US_WEST_1 = 'us-west-1';
    const US_WEST_2 = 'us-west-2';

    const US_GOV_WEST_1 = 'us-gov-west-1';

    const CA_CENTRAl_1 = 'ca-central-1';
    const EU_WEST_1 = 'eu-west-1';
    const EU_WEST_2 = 'eu-west-2';

    const EU_CENTRAL_1 = 'eu-central-1';
    const AP_NORTHEAST_1 = 'ap-northeast-1';
    const AP_NORTHEAST_2 = 'ap-northeast-2';
    const AP_SOUTHEAST_1 = 'ap-southeast-1';
    const AP_SOUTHEAST_2 = 'ap-southeast-2';

    const AP_SOUTH_1 = 'ap-south-1';

    const SA_EAST_1 = 'sa-east-1';

    const LOCATION_NAME_TO_REGION_CODE = [
        'Any' => self::GLOBAL,

        'US East (N. Virginia)' => self::US_EAST_1,
        'US East (Ohio)' => self::US_EAST_2,
        'US West (N. California)' => self::US_WEST_1,
        'US West (Oregon)' => self::US_WEST_2,
        'AWS GovCloud (US)' => self::US_GOV_WEST_1,

        'Canada (Central)' => self::CA_CENTRAl_1,

        'EU (Ireland)' => self::EU_WEST_1,
        'EU (London)' => self::EU_WEST_2,
        'EU (Frankfurt)' => self::EU_CENTRAL_1,

        'Asia Pacific (Tokyo)' => self::AP_NORTHEAST_1,
        'Asia Pacific (Seoul)' => self::AP_NORTHEAST_2,
        'Asia Pacific (Singapore)' => self::AP_SOUTHEAST_1,
        'Asia Pacific (Sydney)' => self::AP_SOUTHEAST_2,

        'Asia Pacific (Mumbai)' => self::AP_SOUTH_1,

        'South America (Sao Paulo)' => self::SA_EAST_1,
    ];
}
