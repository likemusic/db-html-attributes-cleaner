<?php

namespace Likemusic\DbColumnsUpdater;

use Likemusic\DbColumnsUpdater\Config\Config;
use Likemusic\DbColumnsUpdater\Config\ConfigProvider;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class DbUpdateColumnsCommand extends Command
{
    protected static $defaultName = 'update';

    /** @var ConfigProvider */
    private $configProvider;

    /** @var DbColumnsProcessor */
    private $dbColumnsUpdater;

    public function __construct(
        ConfigProvider $configProvider,
        DbColumnsProcessor $dbColumnsUpdater,
        string $name = null
    )
    {
        parent::__construct($name);

        $this->dbColumnsUpdater = $dbColumnsUpdater;
        $this->configProvider = $configProvider;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $config = $this->getConfig();

        $this->processTablesByConfig($config);

        return Command::SUCCESS;
    }

    private function getConfig()
    {
        return $this->configProvider->getConfig();
    }

    private function processTablesByConfig(Config $config)
    {
        $connectionConfig = $config->getConnectionConfig();
        $host = $connectionConfig->getHost();
        $database = $connectionConfig->getDatabase();
        $user = $connectionConfig->getUser();
        $password = $connectionConfig->getPassword();
        $charset = $connectionConfig->getCharset();

        $convertersNamesWithArgs = $config->getConvertorsConfigArray();
        $tablesConfigArray = $config->getTablesConfigArray();

        $this->processTables($convertersNamesWithArgs, $host, $database, $user, $password, $charset, $tablesConfigArray);
    }

    private function processTables(
        array $converterKeys,
        string $host,
        string $database,
        string $user,
        string $password,
        ?string $charset,
        array $tablesConfigArray
    )
    {
        $this->dbColumnsUpdater->process($converterKeys, $host, $database, $user, $password, $charset, $tablesConfigArray);
    }
}
