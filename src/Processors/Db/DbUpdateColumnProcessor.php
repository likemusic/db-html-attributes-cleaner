<?php

namespace Likemusic\DbColumnsUpdater\Processors\Db;

use LessQL\Row;
use Likemusic\DbColumnsUpdater\ContextKeysEnum;
use Likemusic\DbColumnsUpdater\Processors\Base\BaseProcessor;

class DbUpdateColumnProcessor extends BaseProcessor
{
    public function process(string $text, array $args, array $context = [])
    {
        $row = $context[ContextKeysEnum::ROW];
        $columnName = $context[ContextKeysEnum::COLUMN_NAME];

        $this->updateRowColumn($columnName, $text, $row);
    }

    private function updateRowColumn(
        string $columnName,
        string $clearedColumnValue,
        Row $row
    )
    {
        $row->update([$columnName => $clearedColumnValue]);
    }
}
