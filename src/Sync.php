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
     * Models to write (on MASTER but NOT SLAVE).
     *
     * @var SyncModel[]
     */
    public readonly array $writes;

    /**
     * Models to update (on SLAVE and MASTER).
     *
     * @var SyncModel[]
     */
    public readonly array $updates;

    /**
     * Model ids to delete (on SLAVE but NOT MASTER).
     *
     * @var string[]
     */
    public readonly array $deletes;

    /**
     * Create a new Sync object.
     */
    public function __construct(
        protected ReadableSource $master,
        protected ReadableSource&WritableSource $slave
    ) {
        $master_ids = $master->list();
        $slave_ids = $slave->list();

        // Write: on Master, not Slave
        $this->writes = $master->get(array_diff($master_ids, $slave_ids));

        // Update: On both and different properties
        $this->updates = $master->get(array_intersect($master_ids, $slave_ids));

        // Delete: not on Master, on Slave
        $this->deletes = array_diff($slave_ids, $master_ids);
    }

    /**
     * Sync any writes.
     *
     * @return $this
     */
    public function syncWrites(): static
    {
        if (! empty($this->writes)) {
            $this->slave->create($this->writes);
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
        if (! empty($this->updates)) {
            $this->slave->update($this->updates);
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
        if (! empty($this->deletes)) {
            $this->slave->delete($this->deletes);
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
