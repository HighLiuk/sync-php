<?php

namespace HighLiuk\Sync;

use HighLiuk\Sync\Interfaces\ReadableSource;
use HighLiuk\Sync\Interfaces\WritableSource;

/**
 * Describes a flow of data from one source to one (or multiple) destination(s).
 */
class Flow
{
    /**
     * The list of syncs to perform.
     *
     * @var Sync[]
     */
    protected array $syncs = [];

    final protected function __construct(protected ReadableSource $source)
    {
    }

    /**
     * Defines the source of the flow.
     */
    public static function from(ReadableSource $source): static
    {
        return new static($source);
    }

    /**
     * Adds a destination to the flow.
     *
     * @return $this
     */
    public function to(ReadableSource&WritableSource $destination): static
    {
        $this->syncs[] = new Sync($this->source, $destination);

        return $this;
    }

    /**
     * Sync any writes.
     *
     * @return $this
     */
    public function syncWrites(): static
    {
        foreach ($this->syncs as $sync) {
            $sync->syncWrites();
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
        foreach ($this->syncs as $sync) {
            $sync->syncUpdates();
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
        foreach ($this->syncs as $sync) {
            $sync->syncDeletes();
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
