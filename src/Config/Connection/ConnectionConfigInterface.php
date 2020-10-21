<?php

namespace Likemusic\DbColumnsUpdater\Config\Connection;

interface ConnectionConfigInterface
{
    public function getHost(): string;

    public function getDatabase(): string;

    public function getUser(): ?string;

    public function getPassword(): ?string;
}
