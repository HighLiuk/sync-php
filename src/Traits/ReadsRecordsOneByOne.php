<?php

namespace HighLiuk\Sync\Traits;

use HighLiuk\Sync\SyncModel;

trait ReadsRecordsOneByOne
{
    /**
     * Get the item with the given id.
     *
     * @return ?array<string,mixed>
     */
    abstract public function getOne(string $id): ?array;

    /**
     * Get the models with the given ids.
     *
     * @param  string[]  $ids
     * @return SyncModel[]
     */
    public function get(array $ids): array
    {
        $models = [];

        foreach ($ids as $id) {
            if ($item = $this->getOne($id)) {
                $models[] = new SyncModel($id, $item);
            }
        }

        return $models;
    }
}
