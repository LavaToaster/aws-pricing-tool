<?php

namespace Lavoaster\AWSClientPricing;

use Illuminate\Container\Container;
use Lavoaster\AWSClientPricing\Commands\CacheBuildCommand;
use Lavoaster\AWSClientPricing\Commands\CalculateCommand;
use League\Flysystem\Adapter\Local;
use League\Flysystem\Filesystem;
use Symfony\Component\Yaml\Yaml;

class Bootstrap
{
    /**
     * @var array
     */
    protected $commands = [
        CalculateCommand::class,
        CacheBuildCommand::class,
    ];

    /**
     * @var Container
     */
    protected $container;

    /**
     * @var Application
     */
    protected $application;

    /**
     * @var string
     */
    protected $rootPath;

    public function __construct(string $rootPath)
    {
        $this->rootPath = $rootPath;
    }

    public function run()
    {
        $this->init();
        $this->registerContainerBindings();
        $this->registerCommands();

        $this->application->run();
    }

    protected function init()
    {
        $config = Yaml::parse(file_get_contents($this->rootPath . '/config.yml'));

        Config::setConfig($config);

        $this->container = new Container();
        $this->application = new Application($this->container);
    }

    protected function registerContainerBindings()
    {
        // Storage Driver

        $this->container->bind(Filesystem::class, function () {
            return new Filesystem(new Local($this->rootPath . '/storage'));
        });
    }

    protected function registerCommands()
    {
        $this->application->addCommands(array_map([$this->container, 'make'], $this->commands));
    }
}
