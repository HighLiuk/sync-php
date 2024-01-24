<?php

namespace HighLiuk\Sync\Interfaces;

/**
 * @template ID of string|int
 * @template TModel of SyncModel<ID>
 * @template TContents
 */
interface ReadableSource
{
    /**
     * Read the model with the given ID.
     *
     * @param ID $id
     * @return ?TContents
     */
    public function get($id);

    /**
     * List all models.
     *
     * @return iterable<int,TModel>
     */
    public function list(): iterable;
}
