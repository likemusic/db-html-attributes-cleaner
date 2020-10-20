<?php

namespace Likemusic\DbHtmlAttributesCleaner\Config\Connection;

interface ConnectionConfigInterface
{
    public function getHost();

    public function getUser();

    public function getPassword();
}
