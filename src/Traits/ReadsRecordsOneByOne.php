<?php

namespace HighLiuk\Sync\Traits;

use HighLiuk\Sync\SyncModel;

trait ReadsRecordsOneByOne
{
    /**
     * Get the model with the given id.
     */
    abstract public function getOne(string $id): ?SyncModel;

    /**
     * Get the models with the given ids.
     *
     * @param  string[]  $ids
     * @return SyncModel[]
     */
    public function get(array $ids): array
    {
        $models = array_map($this->getOne(...), $ids);

        return array_values(array_filter($models));
    }
}
