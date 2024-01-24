<?php

namespace HighLiuk\Sync\Adapters\Json;

use HighLiuk\Sync\Interfaces\SyncModel;

/**
 * @implements SyncModel<ID>
 * @template ID of string|int
 */
class JsonModel implements SyncModel
{
    /**
     * The ID of the JSON model.
     *
     * @var ID
     */
    public readonly string|int $id;

    /**
     * Create a new User instance.
     *
     * @param array<string,mixed> $data
     */
    public function __construct(array $data)
    {
        $idField = static::getIdField();
        $this->id = $data[$idField] ?? null;
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
        return $this->id == $other->id;
    }
}
