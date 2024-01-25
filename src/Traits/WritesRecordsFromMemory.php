<?php

namespace HighLiuk\Sync\Traits;

use HighLiuk\Sync\SyncModel;

trait WritesRecordsFromMemory
{
    public function create(array $models): void
    {
        $this->put($models);
    }

    public function update(array $models): void
    {
        $this->put($models);
    }

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
