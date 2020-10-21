<?php

namespace Likemusic\DbColumnsUpdater;

use Likemusic\DbColumnsUpdater\Processors\ProcessorInterface;

class GeneralProcessor
{
    /** @var ProcessorInterface[] */
    private $converters;

    /** @var string[] */
    private $converterClassNames;

    public function addConverters(array $converters)
    {
        foreach ($converters as $converterKey => $converterClassName) {
            $this->addConverter($converterKey, $converterClassName);
        }
    }

    public function addConverter(string $converterKey, string $converterClassName)
    {
        $this->converterClassNames[$converterKey] = $converterClassName;
    }

    /**
     * @param string $text
     * @param array|string[] $convertersKeysWithArgs
     * @param array $context
     * @return string|void
     */
    public function process(string $text, array $convertersKeysWithArgs, array $context = [])
    {
        $result = $text;

        foreach ($convertersKeysWithArgs as $converterKey => $converterArgs) {
            $result = $this->convertByConverterKey($converterKey, $converterArgs, $context, $result);
        }

        return $result;
    }

    private function convertByConverterKey(string $converterKey, array $args, array $context, string $text)
    {
        $converter = $this->getConverterByKey($converterKey);

        return $converter->process($text, $args, $context);
    }

    private function getConverterByKey(string $converterKey): ProcessorInterface
    {
        if (!$this->converters[$converterKey]) {
            $this->converters[$converterKey] = $this->createConverterByKey($converterKey);
        }

        return $this->converters[$converterKey];
    }

    private function createConverterByKey(string $converterKey): ProcessorInterface
    {
        $converterClassName = $this->getConverterClassNameByKey($converterKey);

        return $this->createInstanceByClassName($converterClassName);
    }

    private function getConverterClassNameByKey(string $converterKey): string
    {
        return $this->converterClassNames[$converterKey];
    }

    private function createInstanceByClassName(string $className): ProcessorInterface
    {
        return new $className();
    }
}
