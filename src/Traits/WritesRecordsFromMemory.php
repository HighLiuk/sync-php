<?php

namespace HighLiuk\Sync\Traits;

use HighLiuk\Sync\SyncModel;

trait WritesRecordsFromMemory
{
    /**
     * Save the items to the source.
     *
     * @param  array<string,array<string,mixed>>  $items
     */
    abstract public function save(array $items): void;

    /**
     * Add the given models to the source.
     *
     * @param  SyncModel[]  $models
     */
    public function create(array $models): void
    {
        $this->put($models);
    }

    /**
     * Update the given models in the source.
     *
     * @param  SyncModel[]  $models
     */
    public function update(array $models): void
    {
        $this->put($models);
    }

    /**
     * Delete the models with the given ids from the source.
     *
     * @param  string[]  $ids
     */
    public function delete(array $ids): void
    {
        $items = $this->loadIndexed();

        foreach ($ids as $id) {
            unset($items[$id]);
        }

        $this->save($items);
    }

    /**
     * Put the models to the source. Update if exists, create if not.
     *
     * @param  SyncModel[]  $models
     */
    protected function put(array $models): void
    {
        $items = $this->loadIndexed();

        foreach ($models as $model) {
            $items[$model->id] = $model->item;
        }

        $this->save($items);
    }
}
