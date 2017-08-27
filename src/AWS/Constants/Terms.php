<?php

namespace Lavoaster\AWSClientPricing\AWS\Constants;

/**
 * This intent for this class is to document the available OfferTermSku's into something
 * a little more usable, and identifiable, than using the SKU directly.
 *
 * I'm not sure at this point in time if these are subject to change in each version of the dataset.
 * Nor have I had looked through previous versions of the dataset to find out.
 *
 * Also note: This may miss other terms as I have only gone through EC2, RDS and ElastiCache offer terms so far.
 */
class Terms
{
    // Hopefully this applies to all 🤞
    const ON_DEMAND = 'JRTCKXETXF';

    // 1yr Standard Upfront (EC2, RDS)
    const STANDARD_1_YEAR_NO_UPFRONT = '4NA7Y494T4';
    const STANDARD_1_YEAR_PARTIAL_UPFRONT = 'HU7G6KETJZ';
    const STANDARD_1_YEAR_ALL_UPFRONT = '6QCMYABX3D';

    // 1yr Standard Utilisation (ElastiCache)
    const STANDARD_1_YEAR_LIGHT_UTIL = 'DK9W8XRWES';
    const STANDARD_1_YEAR_MEDIUM_UTIL = 'JRBFQ5DASS';
    const STANDARD_1_YEAR_HEAVY_UTIL = 'YTVHEVGPBZ';

    // 3yr Standard Upfront (EC2, RDS)
    const STANDARD_3_YEAR_NO_UPFRONT = 'BPH4J8HBKS';
    const STANDARD_3_YEAR_PARTIAL_UPFRONT = '38NPMPTW36';
    const STANDARD_3_YEAR_ALL_UPFRONT = 'NQ3QZPMQV9';

    // 3yr Standard Utilisation (ElastiCache)
    const STANDARD_3_YEAR_LIGHT_UTIL = 'VHSX6N8RTZ';
    const STANDARD_3_YEAR_MEDIUM_UTIL = 'KGRZ3REEDN';
    const STANDARD_3_YEAR_HEAVY_UTIL = 'VG8YD49WWM';

    // 3yr Convertible Upfront (EC2)
    const CONVERTIBLE_3_YEAR_NO_UPFRONT = 'Z2E3P23VKM';
    const CONVERTIBLE_3_YEAR_PARTIAL_UPFRONT = 'R5XV2EPZQZ';
    const CONVERTIBLE_3_YEAR_ALL_UPFRONT = 'MZU6U2429S';
}
