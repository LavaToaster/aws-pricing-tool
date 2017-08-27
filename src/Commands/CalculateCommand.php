<?php

namespace Lavoaster\AWSClientPricing\Commands;

use Lavoaster\AWSClientPricing\AWS\Calculator;
use Lavoaster\AWSClientPricing\AWS\Factories\PriceFactory;
use Lavoaster\AWSClientPricing\Definition\AllOnDemand;
use Symfony\Component\Console\Helper\TableSeparator;

class CalculateCommand extends BaseCommand
{
    public function configure()
    {
        $this->setName('calculate');
    }

    public function handle(PriceFactory $priceFactory)
    {
        $this->output->title('Calculator');

        $definitions = [
            'OD' => AllOnDemand::definition(),
        ];

        $this->output->section('Loading Data into Memory');

        foreach ($definitions['OD']['items'] as $service => $resources) {
            $this->output->write(' Loading ' . $service . '...');

            $priceFactory->loadOffering($service);

            $this->output->writeln('Done');
        }

        $this->output->comment('Memory: ' . round(memory_get_usage(true) / 1024 / 1024, 2) . 'MB');

        $this->output->section('Calculation');

        $calculator = new Calculator($priceFactory);

        foreach ($definitions as $key => $definition) {
            $this->calculateDefinition($calculator, $definition);
        }
    }

    /**
     * @param $calculator
     * @param $definition
     */
    private function calculateDefinition(Calculator $calculator, $definition)
    {
        $calculatedDefinition = $calculator->calculate($definition);

        $support = [
            'Support' => [
                'pricing' => $this->calculateSupport($calculatedDefinition['pricing']),
            ],
        ];

        $tableData = array_map(
            [$this, 'formatServices'],
            $calculatedDefinition['items'],
            array_keys($calculatedDefinition['items'])
        );

        $tableData[] = new TableSeparator();
        $tableData[] = $this->formatPricing('Support', $support['Support']['pricing']);
        $tableData[] = new TableSeparator();
        $tableData[] = $this->formatPricing('Total', Calculator::calculateTotal(array_merge($calculatedDefinition['items'], $support)));

        $headers = [
            'Service',
            'One-Time 1yr',
            'One-Time 3yr',
            'Hourly',
            'Daily',
            'Monthly',
            'Yearly',
            'Year One',
            'Year Three',
        ];


        $this->output->note([
            'Calculation Methodology:',
            'Hourly - Raw price',
            'Daily - Hourly * 24',
            'Monthly - Hourly * 730',
            'Yearly - (Hourly * 24 * 365) + One-Time 1yr',
            'Year One - Yearly + One-Time 3yr',
            'Year Three - (Yearly * 3) + One-Time 3yr',
        ]);
        $this->output->note('One Time fees are not spread out into hourly, daily, or monthly costs');

        $this->output->table(
            $headers,
            $tableData
        );
    }

    private function calculateSupport(array $pricing): array
    {
        $monthly = $this->calculateSupportCost($pricing['monthly']);
        $oneTime1yr = $this->calculateSupportCost($pricing['oneTime1yr'] ?? '0.00');
        $oneTime3yr = $this->calculateSupportCost($pricing['oneTime3yr'] ?? '0.00');

        $pricing['oneTime1yr'] = $oneTime1yr;
        $pricing['oneTime3yr'] = $oneTime3yr;
        $pricing['monthly'] = $monthly;

        $pricing['hourly'] = bcdiv($monthly, 730);
        $pricing['daily'] = bcmul($pricing['hourly'], 24);
        $pricing['yearly'] = bcadd(bcmul($monthly, 12), $oneTime1yr);
        $pricing['yearOne'] = bcadd($pricing['yearly'], $oneTime3yr);
        $pricing['yearThree'] = bcadd(bcmul($pricing['yearly'], 3), $oneTime3yr);

        return $pricing;
    }

    private function calculateSupportCost($runningValue): string
    {
        // Note because I'll forget this otherwise:
        //  If support it enabled at a later date, all one-time fees are prorated into the costs.

        $thresholds = [
            '0.10' => ['0', '10000'],
            '0.07' => ['10001', '80000'],
            '0.05' => ['80001', '250000'],
            '0.03' => ['250001', INF],
        ];

        $supportCost = '0.00';

        foreach ($thresholds as $percentage => list($min, $max)) {
            if (bccomp($runningValue, $max) === 1) {
                $supportCost = bcadd($supportCost, bcmul($runningValue, $percentage));
                $runningValue = bcsub($runningValue, $max);

                continue;
            }

            $supportCost = bcmul($runningValue, $percentage);

            // No need to run through any more
            if ($runningValue < $max) {
                break;
            }
        }

        return $supportCost;
    }

    private function formatPricing(string $name, array $pricing, $formatNumber = true): array
    {
        $moneyValues = [
            $pricing['oneTime1yr'] ?? '0.00',
            $pricing['oneTime3yr'] ?? '0.00',
            $pricing['hourly'] ?? '0.00',
            $pricing['daily'] ?? '0.00',
            $pricing['monthly'] ?? '0.00',
            $pricing['yearly'] ?? '0.00',
            $pricing['yearOne'] ?? '0.00',
            $pricing['yearThree'] ?? '0.00',
        ];

        if ($formatNumber) {
            $moneyValues = array_map(function ($value) {
                return '$ ' . number_format($value, 2);
            }, $moneyValues);
        }

        return array_merge([
            $name,
        ], $moneyValues);
    }

    private function formatServices(array $service, $key): array
    {
        return $this->formatPricing($key, $service['pricing']);
    }
}
