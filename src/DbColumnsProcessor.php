<?php

namespace Likemusic\DbColumnsUpdater;

use LessQL\Database;
use LessQL\Result;
use LessQL\Row;
use Likemusic\DbColumnsUpdater\Config\Tables\TableConfigKeysEnum;
use PDO;

class DbColumnsProcessor
{
    /** @var GeneralProcessor */
    private $generalConverter;

    public function __construct(GeneralProcessor $generalConverter)
    {
        $this->generalConverter = $generalConverter;
    }

    public function addConverters(array $converters)
    {
        $this->generalConverter->addConverters($converters);
    }

    public function process(
        array $converterKeys,
        string $host,
        string $database,
        string $user,
        string $login,
        ?string $charset,
        array $tablesConfigArray
    )
    {
        $connection = $this->connectToDb($host, $database, $user, $login, $charset);

        $this->processTables($converterKeys, $connection, $tablesConfigArray);
    }

    private function connectToDb(
        string $host,
        string $database,
        string $user = null,
        string $password = null,
        ?string $charset = null
    ): PDO
    {
        $dsn = $this->getDSN($host, $database, $charset);

        return new PDO($dsn, $user, $password);
    }

    private function getDSN(string $host, string $database, ?string $charset = null)
    {
        $dsn = "mysql:host={$host};dbname={$database}";

        if ($charset) {
            $dsn .= ';charset=' . $charset;
        }

        return $dsn;
    }

    private function processTables(array $converterKeys, PDO $PDO, array $tablesConfigArray)
    {
        foreach ($tablesConfigArray as $tableName => $tableConfigArray) {
            $this->processTable($converterKeys, $PDO, $tableName, $tableConfigArray);
        }
    }

    private function processTable(array $converterKeys, PDO $PDO, string $tableName, array $tableConfigArray)
    {
        $primaryKeys = $tableConfigArray[TableConfigKeysEnum::PRIMARY_KEYS];
        $columns = $tableConfigArray[TableConfigKeysEnum::COLUMNS];
        $configuredDb = $this->getConfiguredDb($PDO, $tableName, $primaryKeys);

        foreach ($columns as $columnName) {
            $this->processTableColumn($converterKeys, $configuredDb, $tableName, $columnName);
        }
    }

    private function getConfiguredDb(PDO $PDO, string $tableName, array $primaryKeys): Database
    {
        $db = new Database($PDO);
        $db->setPrimary($tableName, $primaryKeys);

        return $db;
    }

    private function processTableColumn(array $converterKeys, Database $configuredDb, string $tableName, string $columnName)
    {
        $sourceColumnValues = $this->getSourceColumnValues($configuredDb, $tableName, $columnName);

        $this->processTableColumnValues($converterKeys, $columnName, $sourceColumnValues);
    }

    /**
     * @param Database $db
     * @param string $tableName
     * @param string $columnName
     * @return Result|Row|null
     */
    private function getSourceColumnValues(Database $db, string $tableName, string $columnName): Result
    {
        $result = $db->table($tableName);

        $selectedColumnsExpr = $this->getTableSelectedColumnsExpr($db, $tableName, $columnName);

        return $result->select($selectedColumnsExpr);
    }

    private function getTableSelectedColumnsExpr(Database $db, string $tableName, string $columnName)
    {
        $selectedColumns = $this->getTableSelectedColumns($db, $tableName, $columnName);

        return implode(',', $selectedColumns);//todo: escape column names
    }

    private function getTableSelectedColumns(Database $db, string $tableName, string $columnName)
    {
        $primaryKeys = $db->getPrimary($tableName);

        return array_merge($primaryKeys, [$columnName]);
    }

    private function processTableColumnValues(
        array $converterKeys,
        string $columnName,
        Result $sourceColumnValues
    )
    {
        /** @var Row $row */
        foreach ($sourceColumnValues as $row) {
            $this->processTableColumnValue($converterKeys, $columnName, $row);
        }
    }

    private function processTableColumnValue(
        array $converterKeys,
        string $columnName,
        Row $row
    )
    {
        $sourceColumnValue = $row[$columnName];
        $context = [
            ContextKeysEnum::ROW => $row,
            ContextKeysEnum::COLUMN_NAME => $columnName,
        ];

        $this->processValue($sourceColumnValue, $converterKeys, $context);
    }

    private function processValue(string $sourceColumnValue, $converterKeys, array $context)
    {
        return $this->generalConverter->process($sourceColumnValue, $converterKeys, $context);
    }
}
