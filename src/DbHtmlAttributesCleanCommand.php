<?php

namespace Likemusic\DbHtmlAttributesCleaner;

use Likemusic\DbHtmlAttributesCleaner\Config\ConfigProvider;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class DbHtmlAttributesCleanCommand extends Command
{
    protected static $defaultName = 'clear';

    /** @var ConfigProvider */
    private $configProvider;

    public function __construct(ConfigProvider $configProvider, string $name = null)
    {
        parent::__construct($name);

        $this->configProvider = $configProvider;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $config = $this->getConfig();

//        $this->connectToDb($config->getConnectionConfig());

//        $this->clearTables($config->getDatabasesConfigArray());

        // ... put here the code to run in your command

        // this method must return an integer number with the "exit status code"
        // of the command. You can also use these constants to make code more readable

        // return this if there was no problem running the command
        // (it's equivalent to returning int(0))
        return Command::SUCCESS;

        // or return this if some error happened during the execution
        // (it's equivalent to returning int(1))
        // return Command::FAILURE;
    }

    private function getConfig()
    {
        return $this->configProvider->getConfig();
    }
}
