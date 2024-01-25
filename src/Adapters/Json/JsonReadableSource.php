<?php

namespace HighLiuk\Sync\Adapters\Json;

use HighLiuk\Sync\Interfaces\LoaderSource;
use HighLiuk\Sync\Interfaces\ReadableSource;
use HighLiuk\Sync\Traits\ReadsRecordsFromMemory;

class JsonReadableSource implements LoaderSource, ReadableSource
{
    use ReadsRecordsFromMemory;

    public function __construct(public readonly string $path)
    {
    }

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
