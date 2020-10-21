<?php

namespace Likemusic\DbColumnsUpdater\Processors\PhpFunction;

use Likemusic\DbColumnsUpdater\Processors\Base\BasePhpFunctionProcessor;

class HtmlEntitiesProcessor extends BasePhpFunctionProcessor
{
    protected function getPhpFunctionName(): string
    {
        return 'htmlentities';
    }
}
