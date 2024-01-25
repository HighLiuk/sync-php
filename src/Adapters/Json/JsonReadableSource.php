<?php

namespace HighLiuk\Sync\Adapters\Json;

use HighLiuk\Sync\Interfaces\ReadableSource;
use HighLiuk\Sync\Traits\ReadsRecordsFromMemory;

class JsonReadableSource implements ReadableSource
{
    use ReadsRecordsFromMemory;

    public function __construct(public readonly string $path)
    {
    }

    /**
     * Load the items from the source.
     *
     * @return array<string,mixed>[]
     */
    public function load(): array
    {
        $contents = file_get_contents($this->path) ?: '';
        $json = json_decode($contents, true);

        if (! is_array($json)) {
            return [];
        }

        return $this->jsonToItems($json);
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
