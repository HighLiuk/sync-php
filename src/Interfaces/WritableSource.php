<?php

namespace HighLiuk\Sync\Interfaces;

/**
 * @template ID of string|int
 * @template TModel of SyncModel<ID>
 * @template TContents
 */
interface WritableSource
{
    /**
     * Write the given model to the source.
     *
     * @param ID $id
     * @param TContents $contents
     */
    public function put($id, $contents): void;

    /**
     * Delete the model with the given ID.
     *
     * @param ID $id
     */
    public function delete($id): void;
}
