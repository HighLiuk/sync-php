<?php

namespace HighLiuk\Sync;

/**
 * A model to hold data to sync.
 */
class SyncModel
{
    /**
     * @param string $id The model's id.
     * @param array<string,mixed> $item The model's data.
     */
    public function __construct(
        public readonly string $id,
        public readonly array $item
    ) {
    }
}
