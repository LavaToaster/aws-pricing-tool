<?php

namespace Lavoaster\AWSClientPricing\Commands;

use Illuminate\Container\Container;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class BaseCommand extends Command
{
    /**
     * The laravel container
     *
     * @var \Illuminate\Container\Container
     */
    protected $container = null;

    /**
     * The input interface implementation.
     *
     * @var InputInterface
     */
    protected $input;

    /**
     * The output interface implementation.
     *
     * @var SymfonyStyle
     */
    protected $output;

    /**
     * Run the console command.
     *
     * @param  InputInterface $input
     * @param  OutputInterface $output
     * @return int
     */
    public function run(InputInterface $input, OutputInterface $output)
    {
        return parent::run(
            $this->input = $input, $this->output = new SymfonyStyle($input, $output)
        );
    }

    public function setContainer(Container $container)
    {
        $this->container = $container;
    }

    /**
     * Execute the console command.
     *
     * @param  InputInterface $input
     * @param  OutputInterface $output
     * @return mixed
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        return $this->container->call([$this, 'handle']);
    }
}
