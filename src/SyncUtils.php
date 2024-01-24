<?php

namespace HighLiuk\Sync;

use HighLiuk\Sync\Interfaces\SyncModel;
use HighLiuk\Sync\Interfaces\ReadableSource;
use HighLiuk\Sync\Interfaces\SyncSource;

/**
 * Helper class for the Sync class. Gets models that need writing, updating, and
 * deleting.
 *
 * @template ID of string|int
 * @template TModel of SyncModel<ID>
 * @template TContents
 */
class SyncUtils
{
    /**
     * Models to update (on SLAVE and MASTER).
     *
     * @var TModel[]
     */
    protected $updates = [];

    /**
     * Models to write (on MASTER but NOT SLAVE).
     *
     * @var TModel[]
     */
    protected $writes = [];

    /**
     * Models to delete (on SLAVE but NOT MASTER).
     *
     * @var TModel[]
     */
    protected $deletes = [];

    /**
     * @param ReadableSource<ID,TModel,TContents> $master
     * @param SyncSource<ID,TModel,TContents> $slave
     */
    public function __construct(ReadableSource $master, SyncSource $slave)
    {
        $master_models = $this->getModels($master);
        $slave_models  = $this->getModels($slave);

        // Get all models.
        $ids = array_merge(
            array_keys($master_models),
            array_keys($slave_models)
        );

        // Find all WRITE, UPDATE, and DELETE models.
        foreach ($ids as $id) {
            $master_model = $master_models[$id] ?? null;
            $slave_model  = $slave_models[$id] ?? null;

            // Update: On both and different properties
            if ($master_model && $slave_model && !$master_model->isSame($slave_model)) {
                $this->updates[$id] = $master_model;
            }
            // Write: on Master, not Slave
            elseif ($master_model && !$slave_model) {
                $this->writes[$id] = $master_model;
            }
            // Delete: not on Master, on Slave
            elseif (!$master_model && $slave_model) {
                $this->deletes[$id] = $slave_model;
            }
        }
    }

    /**
     * Get models to WRITE.
     *
     * @return TModel[]
     */
    public function getWrites()
    {
        return $this->writes;
    }

    /**
     * Get models to DELETE.
     *
     * @return TModel[]
     */
    public function getDeletes()
    {
        return $this->deletes;
    }

    /**
     * Get models to UPDATES.
     *
     * @return TModel[]
     */
    public function getUpdates()
    {
        return $this->updates;
    }

    /**
     * Get models on source.
     *
     * @param ReadableSource<ID,TModel,TContents> $source
     * @return TModel[]
     */
    protected function getModels(ReadableSource $source): array
    {
        $models = [];

        foreach ($source->list() as $content) {
            // Use id as key for comparison between MASTER and SLAVE.
            $models[$content->getId()] = $content;
        }

        // Sort by key (id).
        ksort($models);

        return $models;
    }
}
