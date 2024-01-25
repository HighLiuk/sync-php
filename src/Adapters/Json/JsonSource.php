<?php

namespace HighLiuk\Sync\Adapters\Json;

use HighLiuk\Sync\Interfaces\SaverSource;
use HighLiuk\Sync\Interfaces\WritableSource;
use HighLiuk\Sync\Traits\WritesRecordsFromMemory;

class JsonSource extends JsonReadableSource implements SaverSource, WritableSource
{
    use WritesRecordsFromMemory;

    public function save(array $items): void
    {
        $json = $this->itemsToJson(array_values($items));
        $contents = json_encode($json);

        file_put_contents($this->path, $contents);
    }

    /**
     * Map the items to the json content.
     *
     * @param  array<string,mixed>[]  $items
     * @return array<array-key,mixed>
     */
    protected function itemsToJson(array $items): array
    {
        return $items;
    }
}
