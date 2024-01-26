<?php

namespace HighLiuk\Sync;

use HighLiuk\Sync\Interfaces\ReadableSource;
use HighLiuk\Sync\Interfaces\WritableSource;

/**
 * Syncs two sources.
 */
class Sync
{
    /**
     * The loader utility used to load data from the sources.
     */
    public readonly SyncLoader $loader;

    /**
     * Create a new Sync object.
     */
    public function __construct(
        protected ReadableSource $master,
        protected ReadableSource&WritableSource $slave
    ) {
        $this->loader = new SyncLoader($master, $slave);
    }

    /**
     * Sync any writes.
     *
     * @return $this
     */
    public function syncWrites(): static
    {
        $writes = $this->loader->getWrites();

        if (! empty($writes)) {
            $this->slave->create($writes);
        }

        return $this;
    }

    /**
     * Sync any updates.
     *
     * @return $this
     */
    public function syncUpdates(): static
    {
        $updates = $this->loader->getUpdates();

        if (! empty($updates)) {
            $this->slave->update($updates);
        }

        return $this;
    }

    /**
     * Sync any deletes.
     *
     * @return $this
     */
    public function syncDeletes(): static
    {
        $deletes = $this->loader->getDeletes();

        if (! empty($deletes)) {
            $this->slave->delete($deletes);
        }

        return $this;
    }

    /**
     * Sync any writes, updates, and deletes.
     *
     * @return $this
     */
    public function sync(): static
    {
        return $this
            ->syncWrites()
            ->syncUpdates()
            ->syncDeletes();
    }
}
