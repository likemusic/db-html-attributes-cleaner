#!/usr/bin/env php
<?php

require __DIR__ . '/vendor/autoload.php';

use Likemusic\DbColumnsUpdater\Config\ConfigProvider;
use Likemusic\DbColumnsUpdater\DbColumnsProcessor;
use Likemusic\DbColumnsUpdater\DbUpdateColumnsCommand;
use Likemusic\DbColumnsUpdater\GeneralProcessor;
use Likemusic\DbColumnsUpdater\Processors\Db\DbUpdateColumnProcessor;
use Likemusic\DbColumnsUpdater\Processors\Html\HtmlRemoveAttributes;
use Likemusic\DbColumnsUpdater\Processors\PhpFunction\HtmlEntitiesProcessor;
use Likemusic\DbColumnsUpdater\Processors\PhpFunction\HtmlEntityDecodeProcessor;
use Symfony\Component\Console\Application;

$application = new Application();

$configProvider = new ConfigProvider();
$generalConverter = new GeneralProcessor();
$dbHtmlAttributesCleaner = new DbColumnsProcessor($generalConverter);

$dbHtmlAttributesCleaner->addConverters([
    'php.htmlentities' => HtmlEntitiesProcessor::class,
    'php.html_entity_decode' => HtmlEntityDecodeProcessor::class,
    'html.remove-attributes' => HtmlRemoveAttributes::class,
    'db.updateColumn' => DbUpdateColumnProcessor::class,
]);

$application->add(new DbUpdateColumnsCommand($configProvider, $dbHtmlAttributesCleaner));

$application->run();
