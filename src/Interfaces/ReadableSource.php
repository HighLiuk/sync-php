<?php

namespace HighLiuk\Sync\Interfaces;

use HighLiuk\Sync\SyncModel;

interface ReadableSource
{
    /**
     * Get the models with the given ids.
     *
     * @param  string[]  $ids
     * @return SyncModel[]
     */
    public function get(array $ids): array;

    /**
     * Get all model ids.
     *
     * @return string[]
     */
    public function list(): array;
}
