<?php

namespace Lavoaster\AWSClientPricing;

use Illuminate\Container\Container;
use Illuminate\Contracts\Console\Application as ApplicationContract;
use Lavoaster\AWSClientPricing\Commands\BaseCommand;
use Symfony\Component\Console\Application as SymfonyApplication;
use Symfony\Component\Console\Command\Command as SymfonyCommand;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\BufferedOutput;
use Symfony\Component\Console\Output\OutputInterface;

class Application extends SymfonyApplication implements ApplicationContract
{
    /**
     * The console application bootstrappers.
     *
     * @var array
     */
    protected static $bootstrappers = [];
    /**
     * The Laravel application instance.
     *
     * @var Container
     */
    protected $container;
    /**
     * The output from the previous command.
     *
     * @var \Symfony\Component\Console\Output\BufferedOutput
     */
    protected $lastOutput;

    /**
     * Create a new Artisan console application.
     *
     * @param  Container $container
     */
    public function __construct(Container $container)
    {
        parent::__construct('AWS Pricing Tool');

        $this->container = $container;
    }

    /**
     * Run an Artisan console command by name.
     *
     * @param  string $command
     * @param  array $parameters
     * @param  OutputInterface $outputBuffer
     * @return int
     */
    public function call($command, array $parameters = [], $outputBuffer = null)
    {
        $parameters = collect($parameters)->prepend($command);

        $this->lastOutput = $outputBuffer ?: new BufferedOutput;

        $this->setCatchExceptions(false);

        $result = $this->run(new ArrayInput($parameters->toArray()), $this->lastOutput);

        $this->setCatchExceptions(true);

        return $result;
    }

    /**
     * Get the output for the last run command.
     *
     * @return string
     */
    public function output()
    {
        return $this->lastOutput ? $this->lastOutput->fetch() : '';
    }

    /**
     * Resolve an array of commands through the application.
     *
     * @param  array|mixed $commands
     * @return $this
     */
    public function resolveCommands($commands)
    {
        $commands = is_array($commands) ? $commands : func_get_args();

        foreach ($commands as $command) {
            $this->resolve($command);
        }

        return $this;
    }

    /**
     * Add a command, resolving through the application.
     *
     * @param  string $command
     * @return \Symfony\Component\Console\Command\Command
     */
    public function resolve($command)
    {
        return $this->add($this->container->make($command));
    }

    /**
     * Add a command to the console.
     *
     * @param  \Symfony\Component\Console\Command\Command $command
     * @return \Symfony\Component\Console\Command\Command
     */
    public function add(SymfonyCommand $command)
    {
        if ($command instanceof BaseCommand) {
            $command->setContainer($this->container);
        }

        return parent::add($command);
    }

    /**
     * Get the Laravel Container instance.
     *
     * @return Container
     */
    public function getContainer()
    {
        return $this->container;
    }
}
