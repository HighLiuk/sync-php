<?php

namespace HighLiuk\Sync\Interfaces;

use HighLiuk\Sync\SyncModel;

interface WritableSource
{
    /**
     * Add the given models to the source.
     *
     * @param SyncModel[] $models
     */
    public function create(array $models): void;

    /**
     * Update the given models in the source.
     *
     * @param SyncModel[] $models
     */
    public function update(array $models): void;

    /**
     * Delete the models with the given ids from the source.
     *
     * @param string[] $ids
     */
    public function delete(array $ids): void;
}
