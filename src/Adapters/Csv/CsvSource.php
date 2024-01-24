<?php

namespace HighLiuk\Sync\Adapters\Csv;

use HighLiuk\Sync\Interfaces\SyncSource;

/**
 * @extends CsvReadableSource<TModel>
 * @implements SyncSource<string,TModel,array<string,string>>
 * @template TModel of CsvModel
 */
abstract class CsvSource extends CsvReadableSource implements SyncSource
{
    public function put($id, $contents): void
    {
        $idField = $this->idField;

        // Find the model by ID in the data array.
        foreach ($this->data as &$item) {
            if ($item[$idField] === $id) {
                // Replace the model with the new contents.
                $item = $contents;

                // Save the data array to the file.
                $this->save();
                return;
            }
        }

        // If the model was not found, add it to the data array.
        $this->data[] = $contents;
        $this->save();
    }

    public function delete($id): void
    {
        $idField = $this->idField;

        // Find the model by ID in the data array.
        foreach ($this->data as $key => $item) {
            if ($item[$idField] === $id) {
                // Remove the model from the data array.
                unset($this->data[$key]);
                $this->data = array_values($this->data);

                // Save the data array to the file.
                $this->save();
                return;
            }
        }
    }

    /**
     * Save the data to the source.
     */
    protected function save(): void
    {
        $handle = fopen($this->path, 'w');
        assert($handle !== false);

        // Write the header row.
        fputcsv($handle, $this->headers);

        // Write the data rows.
        foreach ($this->data as $item) {
            fputcsv($handle, array_values($item));
        }

        fclose($handle);
    }
}
