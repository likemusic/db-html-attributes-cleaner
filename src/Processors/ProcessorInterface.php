<?php

namespace Likemusic\DbColumnsUpdater\Processors;

interface ProcessorInterface
{
    public function process(string $text, array $args, array $context = []);
}
