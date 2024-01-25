<?php

namespace HighLiuk\Sync\Traits;

use HighLiuk\Sync\SyncModel;
use HighLiuk\Sync\Utils;

trait ReadsRecordsFromMemory
{
    /**
     * Load the items from the source.
     *
     * @return array<string,mixed>[]
     */
    abstract public function load(): array;

    /**
     * Get the models with the given ids.
     *
     * @param  string[]  $ids
     * @return SyncModel[]
     */
    public function get(array $ids): array
    {
        $items = $this->loadIndexed();

        return array_map(
            fn (string $id) => new SyncModel($id, $items[$id]),
            $ids
        );
    }

    /**
     * Get all model ids.
     *
     * @return string[]
     */
    public function list(): array
    {
        return array_map($this->getItemId(...), $this->load());
    }

    /**
     * Load the items from the source and return them indexed by ID.
     *
     * @return array<string,array<string,mixed>>
     */
    protected function loadIndexed(): array
    {
        return $this->keyById($this->load());
    }

    /**
     * Index the items by ID.
     *
     * @param  array<string,mixed>[]  $items
     * @return array<string,array<string,mixed>>
     */
    protected function keyById(array $items): array
    {
        $return = [];

        foreach ($items as $item) {
            $return[$this->getItemId($item)] = $item;
        }

        return $return;
    }

    /**
     * Map the item to its ID.
     *
     * @param  array<string,mixed>  $item
     */
    protected function getItemId(array $item): string
    {
        return Utils::toString($item['id'] ?? null);
    }
}
