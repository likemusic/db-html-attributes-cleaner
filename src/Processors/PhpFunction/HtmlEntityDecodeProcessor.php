<?php

namespace Likemusic\DbColumnsUpdater\Processors\PhpFunction;

use Likemusic\DbColumnsUpdater\Processors\Base\BasePhpFunctionProcessor;

class HtmlEntityDecodeProcessor extends BasePhpFunctionProcessor
{
    protected function getPhpFunctionName(): string
    {
        return 'html_entity_decode';
    }
}
