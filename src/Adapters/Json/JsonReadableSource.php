<?php

namespace HighLiuk\Sync\Adapters\Json;

use HighLiuk\Sync\Interfaces\ReadableSource;

/**
 * @implements ReadableSource<ID,TModel,array<string,mixed>>
 * @template ID of string|int
 * @template TModel of JsonModel<ID>
 */
abstract class JsonReadableSource implements ReadableSource
{
    /**
     * The content of the JSON source.
     *
     * @var array<array-key,mixed>
     */
    protected array $content;

    /**
     * The data of the JSON source.
     *
     * @var array<string,mixed>[]
     */
    protected array $data;

    /**
     * The ID field of the JSON source.
     */
    protected readonly string $idField;

    public function __construct(public readonly string $path)
    {
        $contents = file_get_contents($path);
        assert($contents);

        $content = json_decode($contents, true);
        assert(is_array($content));
        $this->content = $content;

        $model = $this->model();
        $idField = $model::getIdField();
        $this->idField = $idField;

        $data = &$this->selectData($this->content);
        assert(array_is_list($data));
        foreach ($data as $item) {
            assert(is_array($item));
            assert(array_key_exists($idField, $item));
        }

        $this->data = &$data;
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

    /**
     * Select the data from the source.
     *
     * @param array<array-key,mixed> $content
     * @return array<string,mixed>[]
     */
    protected function &selectData(array &$content): array
    {
        return $content;
    }
}
