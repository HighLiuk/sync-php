<?php

namespace HighLiuk\Sync\Adapters\Csv;

use HighLiuk\Sync\Interfaces\LoaderSource;
use HighLiuk\Sync\Interfaces\ReadableSource;
use HighLiuk\Sync\Traits\ReadsRecordsFromMemory;
use Throwable;

class CsvReadableSource implements LoaderSource, ReadableSource
{
    use ReadsRecordsFromMemory;

    /**
     * The headers of the CSV source.
     *
     * @var string[]
     */
    protected array $headers = [];

    public function __construct(public readonly string $path)
    {
    }

    public function load(): array
    {
        $handle = fopen($this->path, 'r');

        if ($handle === false) {
            return [];
        }

        $headers = fgetcsv($handle);
        assert(is_array($headers));
        $this->headers = $headers;
        $headers = $this->getHeaders();

        $items = [];
        while (is_array($row = fgetcsv($handle))) {
            try {
                $items[] = $this->fieldsToItem($row);
            } catch (Throwable) {
                // Ignore the row.
            }
        }

        fclose($handle);

        return $items;
    }

    /**
     * Get the headers of the CSV file.
     *
     * @return string[]
     */
    protected function getHeaders(): array
    {
        return $this->headers;
    }

    /**
     * Map the fields to the item.
     *
     * @param  string[]  $fields
     * @return array<string,string>
     */
    protected function fieldsToItem(array $fields): array
    {
        $item = array_combine($this->getHeaders(), $fields);

        assert(is_array($item));

        return $item;
    }
}
