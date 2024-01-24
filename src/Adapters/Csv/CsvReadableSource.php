<?php

namespace HighLiuk\Sync\Adapters\Csv;

use HighLiuk\Sync\Interfaces\ReadableSource;
use HighLiuk\Sync\SyncModel;
use Throwable;

class CsvReadableSource implements ReadableSource
{
    /**
     * The headers of the CSV source.
     *
     * @var string[]
     */
    protected array $headers = [];

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
     * @return array<string,array<string,string>>
     */
    protected function load(): array
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

        return $this->keyById($items);
    }

    /**
     * Index the items by ID.
     *
     * @param array<string,string>[] $items
     * @return array<string,array<string,string>>
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
     * @param array<string,string> $item
     */
    protected function getItemId(array $item): string
    {
        return (string) ($item['id'] ?? null);
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
     * @param string[] $fields
     * @return array<string,string>
     */
    protected function fieldsToItem(array $fields): array
    {
        $item = array_combine($this->getHeaders(), $fields);

        assert(is_array($item));

        return $item;
    }
}
