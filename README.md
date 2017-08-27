AWS Pricing Tool
================

## This is not complete

This is a WIP project whose main purpose is to represent AWS infrastructure costs as configuration, so that you can
play around with the configuration. Such as asking the question if you put this resource on reserved instances 
for a year, is it much more different over the three year one?

You might be constrained on how much you can upfront, but hopefully this tool will help you get the most out of your
resources in AWS.

## Outstanding Items

The _only_ things I have tested on here are compute resources. Specifically, EC2, RDS and ElastiCache.

I have yet to try out the following, which may require additional code:

- Unit based pricing, such as SQS, SES, Bandwidth, Storage.
    - In addition to this I haven't implemented the threshold based pricing that provides discounts the 
      more you use. 
- Support costs are hardcoded at business rates right now.
- At some point I want to store in a queryable datastore to avoid in memory lookups.
- I'd also like to investigate a way of streaming the json files in so that it doesn't use as much memory.

And of course Other things I haven't thought of.

## Setup

Install [composer](https://getcomposer.org) in a global location.

Then run:
```bash
composer install
```

Download the pricing data required for this tool:

```bash
php console.php cache:build
```


Then calculate the costs based on the given definition:

__WARNING:__ This uses _a lot_ of memory, ensure you have at least 1G configured in `php.ini`.
 
```bash
php console.php calculate
```

NOTE: You'll find there is only one definition for now, which is in `src/Definition/AllOnDemand.php`. You should try to
understand the data provided by the [AWS Pricing API](http://docs.aws.amazon.com/awsaccountbilling/latest/aboutv2/reading-an-offer.html).

It'll also give you an idea of how to filter out products for the tool to calculate on.
