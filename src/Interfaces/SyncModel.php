<?php

namespace HighLiuk\Sync\Interfaces;

/**
 * @template ID of string|int
 */
interface SyncModel
{
    /**
     * Get the ID of the model.
     *
     * @return ID
     */
    public function getId();

    /**
     * Check if this model is the same as another.
     *
     * @param SyncModel<ID> $other
     */
    public function isSame(SyncModel $other): bool;
}
