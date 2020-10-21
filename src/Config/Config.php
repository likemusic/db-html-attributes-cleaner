<?php

namespace Likemusic\DbColumnsUpdater\Config;

use Likemusic\DbColumnsUpdater\Config\Connection\ConnectionConfig;

class Config
{
    /** @var array */
    private $configArray;

    /** @var ConnectionConfig */
    private $connectionConfig;

    public function __construct(array $configArray)
    {
        $this->configArray = $configArray;
    }

    public function getConnectionConfig(): ConnectionConfig
    {
        if (!$this->connectionConfig) {
            $this->connectionConfig = $this->createConnectionConfig();
        }

        return $this->connectionConfig;
    }

    private function createConnectionConfig(): ConnectionConfig
    {
        $connectionConfigArray = $this->getConnectionConfigArray();

        return new ConnectionConfig($connectionConfigArray);
    }

    private function getConnectionConfigArray(): array
    {
        return $this->configArray[ConfigKeysEnum::CONNECTION];
    }

    public function getTablesConfigArray(): array
    {
        return $this->configArray[ConfigKeysEnum::TABLES];
    }

    public function getConvertorsConfigArray(): array
    {
        return $this->configArray[ConfigKeysEnum::CONVERTERS];
    }
}
