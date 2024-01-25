<?php

namespace HighLiuk\Sync\Adapters\Csv;

use HighLiuk\Sync\Interfaces\SaverSource;
use HighLiuk\Sync\Interfaces\WritableSource;
use HighLiuk\Sync\Traits\WritesRecordsFromMemory;

class CsvSource extends CsvReadableSource implements SaverSource, WritableSource
{
    use WritesRecordsFromMemory;

    public function save(array $items): void
    {
        $handle = fopen($this->path, 'w');
        assert($handle !== false);

        // Write the header.
        $headers = $this->getHeaders();
        $headers_count = count($headers);
        fputcsv($handle, $headers);

        // Write the rows.
        foreach ($items as $item) {
            if (count($item) === $headers_count) {
                fputcsv($handle, $this->itemToFields($item));
            }
        }

        fclose($handle);
    }

    /**
     * Map the item to the fields.
     *
     * @param  array<string,string>  $item
     * @return string[]
     */
    protected function itemToFields(array $item): array
    {
        return array_values($item);
    }
}
