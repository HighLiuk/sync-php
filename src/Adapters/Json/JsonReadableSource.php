<?php

namespace HighLiuk\Sync\Adapters\Json;

use HighLiuk\Sync\Interfaces\ReadableSource;
use HighLiuk\Sync\SyncModel;

class JsonReadableSource implements ReadableSource
{
    public function __construct(public readonly string $path)
    {
    }

    public function get(array $ids): array
    {
        $items = $this->load();

        return array_map(
            fn (string $id) => new SyncModel($id, $items[$id]),
            $ids
        );
    }

    public function list(): array
    {
        return array_keys($this->load());
    }

    /**
     * Load the items from the source and return them indexed by ID.
     *
     * @return array<string,array<string,mixed>>
     */
    protected function load(): array
    {
        $contents = file_get_contents($this->path) ?: '';
        $json = json_decode($contents, true);

        if (! is_array($json)) {
            return [];
        }

        $items = $this->jsonToItems($json);

        return $this->keyById($items);
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
        return (string) ($item['id'] ?? null);
    }

    /**
     * Map the json content to the items.
     *
     * @param  array<array-key,mixed>  $json
     * @return array<string,mixed>[]
     */
    protected function jsonToItems(array $json): array
    {
        assert(array_is_list($json));

        return $json;
    }
}
