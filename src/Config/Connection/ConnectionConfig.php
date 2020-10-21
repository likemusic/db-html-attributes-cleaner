<?php

namespace Likemusic\DbColumnsUpdater\Config\Connection;

class ConnectionConfig implements ConnectionConfigInterface
{
    /** @var array */
    private $configArray;

    public function __construct($connectionConfigArray)
    {
        $this->configArray = $connectionConfigArray;
    }

    public function getHost(): string
    {
        return $this->getValueByKey(ConnectionConfigKeysEnum::HOST);
    }

    private function getValueByKey(string $key)
    {
        return $this->configArray[$key];
    }

    public function getDatabase(): string
    {
        return $this->getValueByKey(ConnectionConfigKeysEnum::DATABASE);
    }

    public function getUser(): ?string
    {
        return $this->getValueByKey(ConnectionConfigKeysEnum::USER);
    }

    public function getPassword(): ?string
    {
        return $this->getValueByKey(ConnectionConfigKeysEnum::PASSWORD);
    }

    public function getCharset(): ?string
    {
        return $this->getValueByKey(ConnectionConfigKeysEnum::CHARSET);
    }
}
