<?php

namespace HighLiuk\Sync\Adapters\Json;

use HighLiuk\Sync\Interfaces\SyncSource;
use HighLiuk\Sync\SyncModel;

class JsonSource extends JsonReadableSource implements SyncSource
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
     * @param array<string,array<string,mixed>> $items
     */
    protected function save(array $items): void
    {
        $json = $this->itemsToJson(array_values($items));
        $contents = json_encode($json);

        file_put_contents($this->path, $contents);
    }

    /**
     * Put the models to the source. Update if exists, create if not.
     *
     * @param SyncModel[] $models
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
     * Map the items to the json content.
     *
     * @param array<string,mixed>[] $items
     * @return array<array-key,mixed>
     */
    protected function itemsToJson(array $items): array
    {
        return $items;
    }
}
