<?php

namespace HighLiuk\Sync;

use HighLiuk\Sync\Exceptions\ModelNotFoundException;
use HighLiuk\Sync\Interfaces\SyncModel;
use HighLiuk\Sync\Interfaces\ReadableSource;
use HighLiuk\Sync\Interfaces\SyncSource;

/**
 * Syncs two SyncSources.
 *
 * @template ID of string|int
 * @template TModel of SyncModel<ID>
 * @template TContents
 */
class Sync
{
    /**
     * Master source.
     *
     * @var ReadableSource<ID,TModel,TContents>
     */
    protected $master;

    /**
     * Slave source.
     *
     * @var SyncSource<ID,TModel,TContents>
     */
    protected $slave;

    /**
     * Util object for getting WRITE, UPDATE, and DELETE models.
     *
     * @var SyncUtils<ID,TModel,TContents>
     */
    protected $utils;

    /**
     * @param ReadableSource<ID,TModel,TContents> $master
     * @param SyncSource<ID,TModel,TContents> $slave
     */
    public function __construct(ReadableSource $master, SyncSource $slave)
    {
        $this->master = $master;
        $this->slave  = $slave;
        $this->utils  = new SyncUtils($master, $slave);
    }

    /**
     * Get Utils helper object used for getting WRITE, UPDATE, and DELETE models.
     *
     * @return SyncUtils<ID,TModel,TContents>
     */
    public function getUtils(): SyncUtils
    {
        return $this->utils;
    }

    /**
     * Sync any writes.
     *
     * @return $this
     */
    public function syncWrites(): Sync
    {
        foreach ($this->utils->getWrites() as $model) {
            $this->put($model);
        }

        return $this;
    }

    /**
     * Sync any updates.
     *
     * @return $this
     */
    public function syncUpdates(): Sync
    {
        foreach ($this->utils->getUpdates() as $model) {
            $this->put($model);
        }

        return $this;
    }

    /**
     * Sync any deletes.
     *
     * @return $this
     */
    public function syncDeletes(): Sync
    {
        foreach ($this->utils->getDeletes() as $model) {
            $this->slave->delete($model->getId());
        }

        return $this;
    }

    /**
     * Call $this->syncWrites(), $this->syncUpdates(), and $this->syncDeletes()
     *
     * @return $this
     */
    public function sync(): Sync
    {
        return $this
            ->syncWrites()
            ->syncUpdates()
            ->syncDeletes();
    }

    /**
     * Write the given model to the slave.
     *
     * @param TModel $model
     * @throws ModelNotFoundException
     */
    protected function put(SyncModel $model): void
    {
        $contents = $this->master->get($model->getId());

        if ($contents === null) {
            throw new ModelNotFoundException($model);
        }

        $this->slave->put($model->getId(), $contents);
    }
}
