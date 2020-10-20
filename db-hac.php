#!/usr/bin/env php
<?php

require __DIR__ . '/vendor/autoload.php';

use Likemusic\DbHtmlAttributesCleaner\Config\ConfigProvider;
use Likemusic\DbHtmlAttributesCleaner\DbHtmlAttributesCleanCommand;
use Symfony\Component\Console\Application;

$application = new Application();
$configProvider = new ConfigProvider();

$application->add(new DbHtmlAttributesCleanCommand($configProvider));

$application->run();
