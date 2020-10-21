<?php

namespace Likemusic\DbColumnsUpdater\Processors\Base;

abstract class BasePhpFunctionProcessor extends BaseProcessor
{
    public function process(string $text, array $args, array $context = [])
    {
        $phpFunctionName = $this->getPhpFunctionName();

        $functionArgs = array_merge([$text], $args);

        return $this->callPhpFunc($phpFunctionName, $functionArgs);
    }

    abstract protected function getPhpFunctionName(): string;

    protected function callPhpFunc(string $phpFunctionName, array $args): string
    {
        return call_user_func_array($phpFunctionName, $args);
    }
}
