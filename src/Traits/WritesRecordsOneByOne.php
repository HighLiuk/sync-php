<?php

namespace HighLiuk\Sync\Traits;

use HighLiuk\Sync\SyncModel;

trait WritesRecordsOneByOne
{
    /**
     * Add the given item to the source.
     *
     * @param  array<string,mixed>  $item
     */
    abstract public function createOne(string $id, array $item): void;

    /**
     * Update the given item in the source.
     *
     * @param  array<string,mixed>  $item
     */
    abstract public function updateOne(string $id, array $item): void;

    /**
     * Delete the item with the given id from the source.
     */
    abstract public function deleteOne(string $id): void;

    /**
     * Add the given models to the source.
     *
     * @param  SyncModel[]  $models
     */
    public function create(array $models): void
    {
        foreach ($models as $model) {
            $this->createOne($model->id, $model->item);
        }
    }

    /**
     * Update the given models in the source.
     *
     * @param  SyncModel[]  $models
     */
    public function update(array $models): void
    {
        foreach ($models as $model) {
            $this->updateOne($model->id, $model->item);
        }
    }

    /**
     * Delete the models with the given ids from the source.
     *
     * @param  string[]  $ids
     */
    public function delete(array $ids): void
    {
        foreach ($ids as $id) {
            $this->deleteOne($id);
        }
    }
}
