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
     * @param static<ID> $other
     */
    public function isSame($other): bool;
}
