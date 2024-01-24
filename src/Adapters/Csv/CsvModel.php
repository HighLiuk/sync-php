<?php

namespace HighLiuk\Sync\Adapters\Csv;

use HighLiuk\Sync\Interfaces\SyncModel;

/**
 * @implements SyncModel<string>
 */
class CsvModel implements SyncModel
{
    /**
     * The ID of the CSV model.
     */
    public readonly string $id;

    /**
     * Create a new CSV model instance.
     *
     * @param array<string,string> $data
     */
    public function __construct(array $data)
    {
        $idField = static::getIdField();
        $id = $data[$idField] ?? null;
        assert(is_string($id));
        $this->id = $id;
    }

    public static function getIdField(): string
    {
        return 'id';
    }

    public function getId()
    {
        return $this->id;
    }

    /**
     * @param static $other
     */
    public function isSame($other): bool
    {
        return $this->id === $other->id;
    }
}
