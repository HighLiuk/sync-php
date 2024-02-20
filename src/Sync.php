<?php

namespace HighLiuk\Sync;

use HighLiuk\Sync\Interfaces\ReadableSource;
use HighLiuk\Sync\Interfaces\SyncNotifier;
use HighLiuk\Sync\Interfaces\WritableSource;
use Throwable;

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
     * The notifiers to call during the sync.
     *
     * @var SyncNotifier[]
     */
    protected array $notifiers = [];

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
     * Add a notifier to the sync.
     *
     * @return $this
     */
    public function addNotifier(SyncNotifier $notifier): static
    {
        $this->notifiers[] = $notifier;

        return $this;
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
            foreach ($this->notifiers as $notifier) {
                $notifier->beforeCreate($writes);
            }

            try {
                $this->slave->create($writes);

                foreach ($this->notifiers as $notifier) {
                    $notifier->afterCreate($writes);
                }
            } catch (Throwable $e) {
                foreach ($this->notifiers as $notifier) {
                    $notifier->onCreateError($writes, $e);
                }
            }
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
            foreach ($this->notifiers as $notifier) {
                $notifier->beforeUpdate($updates);
            }

            try {
                $this->slave->update($updates);

                foreach ($this->notifiers as $notifier) {
                    $notifier->afterUpdate($updates);
                }
            } catch (Throwable $e) {
                foreach ($this->notifiers as $notifier) {
                    $notifier->onUpdateError($updates, $e);
                }
            }
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
            foreach ($this->notifiers as $notifier) {
                $notifier->beforeDelete($deletes);
            }

            try {
                $this->slave->delete($deletes);

                foreach ($this->notifiers as $notifier) {
                    $notifier->afterDelete($deletes);
                }
            } catch (Throwable $e) {
                foreach ($this->notifiers as $notifier) {
                    $notifier->onDeleteError($deletes, $e);
                }
            }
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
