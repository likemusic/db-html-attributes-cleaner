<?php

namespace Likemusic\DbHtmlAttributesCleaner\Config\Connection;

class ConnectionConfig implements ConnectionConfigInterface
{
    /** @var array */
    private $configArray;

    public function __construct($connectionConfigArray)
    {
        $this->configArray = $connectionConfigArray;
    }

    public function getHost()
    {
        return $this->getValueByKey(ConnectionConfigKeysEnum::HOST);
    }

    private function getValueByKey(string $key)
    {
        return $this->configArray[$key];
    }

    public function getUser()
    {
        return $this->getValueByKey(ConnectionConfigKeysEnum::USER);
    }

    public function getPassword()
    {
        return $this->getValueByKey(ConnectionConfigKeysEnum::PASSWORD);
    }
}
