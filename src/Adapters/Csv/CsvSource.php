<?php

namespace HighLiuk\Sync\Adapters\Csv;

use HighLiuk\Sync\Interfaces\SyncSource;
use HighLiuk\Sync\SyncModel;

class CsvSource extends CsvReadableSource implements SyncSource
{
    public function create(array $models): void
    {
        $this->put($models);
    }

    public function update(array $models): void
    {
        $this->put($models);
    }

    public function delete(array $ids): void
    {
        $items = $this->load();

        foreach ($ids as $id) {
            unset($items[$id]);
        }

        $this->save($items);
    }

    /**
     * Save the items to the source.
     *
     * @param  array<string,array<string,string>>  $items
     */
    protected function save(array $items): void
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
     * Put the models to the source. Update if exists, create if not.
     *
     * @param  SyncModel[]  $models
     */
    protected function put(array $models): void
    {
        $items = $this->load();

        foreach ($models as $model) {
            $items[$model->id] = $model->item;
        }

        $this->save($items);
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
