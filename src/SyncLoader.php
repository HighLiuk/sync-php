<?php

namespace HighLiuk\Sync;

use HighLiuk\Sync\Interfaces\ReadableSource;

/**
 * Sync utility used to load data from the sources.
 */
class SyncLoader
{
    /**
     * The loaded IDs (master, slave).
     *
     * @var ?array{string[],string[]}
     */
    protected ?array $ids = null;

    public function __construct(
        public readonly ReadableSource $master,
        public readonly ReadableSource $slave
    ) {
    }

    /**
     * Loads the data from the master and slave sources.
     *
     * @return array{string[],string[]}
     */
    protected function load(): array
    {
        if ($this->ids !== null) {
            return $this->ids;
        }

        return $this->ids = [
            $this->master->list(),
            $this->slave->list(),
        ];
    }

    /**
     * Returns the list of models to write (on MASTER but NOT SLAVE).
     *
     * @return SyncModel[]
     */
    public function getWrites(): array
    {
        [$master_ids, $slave_ids] = $this->load();

        $ids = array_values(array_diff($master_ids, $slave_ids));

        return $this->master->get($ids);
    }

    /**
     * Returns the list of models to update (on SLAVE and MASTER).
     *
     * @return SyncModel[]
     */
    public function getUpdates(): array
    {
        [$master_ids, $slave_ids] = $this->load();

        $ids = array_values(array_intersect($master_ids, $slave_ids));

        return $this->master->get($ids);
    }

    /**
     * Returns the list of model IDs to delete (on SLAVE but NOT MASTER).
     *
     * @return string[]
     */
    public function getDeletes(): array
    {
        [$master_ids, $slave_ids] = $this->load();

        return array_values(array_diff($slave_ids, $master_ids));
    }
}
