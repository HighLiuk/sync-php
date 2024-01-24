<?php

namespace HighLiuk\Sync\Adapters\Csv;

use HighLiuk\Sync\Interfaces\ReadableSource;

/**
 * @implements ReadableSource<string,TModel,array<string,string>>>
 * @template TModel of CsvModel
 */
abstract class CsvReadableSource implements ReadableSource
{
    /**
     * The data of the CSV source.
     *
     * @var array<string,string>[]
     */
    protected array $data;

    /**
     * The headers of the CSV source.
     *
     * @var string[]
     */
    protected array $headers;

    /**
     * The ID field of the CSV source.
     */
    protected readonly string $idField;

    public function __construct(public readonly string $path)
    {
        $handle = fopen($path, 'r');
        assert($handle !== false);

        $model = $this->model();
        $idField = $model::getIdField();
        $this->idField = $idField;

        $headers = fgetcsv($handle);
        assert(is_array($headers));
        assert(in_array($idField, $headers));
        $this->headers = $headers;

        $data = [];
        while (is_array($row = fgetcsv($handle))) {
            $item = array_combine($headers, $row);
            assert(is_array($item));

            $data[] = $item;
        }

        fclose($handle);

        $this->data = $data;
    }

    public function get($id)
    {
        $idField = $this->idField;

        foreach ($this->data as $item) {
            if ($item[$idField] == $id) {
                return $item;
            }
        }

        return null;
    }

    public function list(): iterable
    {
        $model = $this->model();

        return array_map(
            fn (array $item) => new $model($item),
            $this->data
        );
    }

    /**
     * Get the class name of the model.
     *
     * @return class-string<TModel>
     */
    abstract protected function model(): string;
}
