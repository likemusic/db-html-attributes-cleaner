<?php

namespace Likemusic\DbHtmlAttributesCleaner\Config;

class ConfigProvider
{
    private const CONFIG_FILENAME = 'config.json';

    public function getConfig(): Config
    {
        $configArray = $this->getConfigArray();

        return $this->createConfigByArray($configArray);
    }

    private function getConfigArray(): array
    {
        $configJson = $this->getConfigJson();

        return $this->decodeJson($configJson);
    }

    private function getConfigJson(): string
    {
        return file_get_contents(self::CONFIG_FILENAME);
    }

    private function decodeJson(string $jsonString): array
    {
        return json_decode($jsonString, true);
    }

    private function createConfigByArray(array $configArray)
    {
        return new Config($configArray);
    }
}
