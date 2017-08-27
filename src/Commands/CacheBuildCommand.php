<?php

namespace Lavoaster\AWSClientPricing\Commands;

use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;
use Lavoaster\AWSClientPricing\Config;
use League\Flysystem\Filesystem;
use Symfony\Component\Console\Input\InputOption;
use function GuzzleHttp\Psr7\stream_for;

class CacheBuildCommand extends BaseCommand
{
    const BASE_URL = 'https://pricing.us-east-1.amazonaws.com';

    /**
     * @var Filesystem
     */
    private $filesystem;

    public function __construct(Filesystem $filesystem)
    {
        $this->filesystem = $filesystem;

        parent::__construct();
    }

    public function configure()
    {
        $this->setName('cache:build')
            ->addOption('force', 'f', InputOption::VALUE_NONE, 'Forces the download, and overwrites existing file.');
    }

    public function handle(Client $client): void
    {
        $this->output->title('AWS: Build Price Cache');

        // There are versions that we need to be aware of
        $services = Config::get('aws.services');

        $this->output->text('💵 Getting price data for: ');
        $this->output->text(
            array_map(function ($service) {
                return " <info>$service</info>";
            }, $services)
        );
        $this->output->newLine(2);

        foreach ($services as $service) {
            $file = 'cache/prices/' . $service . '.json';

            $this->output->note('Service: ' . $service);

            if ($this->filesystem->has($file)) {
                if ($this->input->getOption('force')) {
                    $this->filesystem->delete($file);
                } else {
                    $this->output->text('Already Downloaded...');

                    continue;
                }
            }

            $bar = $this->output->createProgressBar(100);
            $bar->setFormat('  %message% (%percent%%) [%bar%] %elapsed:6s%');

            // Temporary Resource File to prevent storing downloads entirely in memory
            $responseBody = tmpfile();

            if ($responseBody === false) {
                $this->output->error('Unable to create temporary file at ' . sys_get_temp_dir());

                die(1);
            }

            // Init stream here because passing through the resource directly ends up
            // closing it somehow.
            $stream = stream_for($responseBody);

            $client->get(
                self::BASE_URL . "/offers/v1.0/aws/$service/current/index.json",
                [
                    RequestOptions::PROGRESS => function (
                        $downloadTotal,
                        $downloadedBytes
                    ) use ($bar) {
                        if (!$downloadTotal) {
                            return;
                        }

                        $progress = ($downloadedBytes / $downloadTotal) * 100;

                        $bar->setProgress(round($progress));
                        $bar->setMessage($this->inMb($downloadedBytes) . 'MB / ' . $this->inMb($downloadTotal) . 'MB');
                    },
                    RequestOptions::SINK => $stream,
                ]
            );

            $bar->finish();
            $bar->clear();

            $this->output->text('Storing on disk...');

            // TODO: Versioned prices
            $this->filesystem->writeStream($file, $responseBody);

            $this->output->write(str_repeat("\x1B[1A\x1B[2K", 5));
        }

        $this->output->success('Finished Downloading. 🍻');
    }

    private function inMb(float $bytes): float
    {
        $mb = $bytes / 1024 / 1024;

        return round($mb, 2);
    }
}
