<?php

namespace Examples\Json;

use HighLiuk\Sync\Adapters\Json\JsonSource;

class UsersSlaveSource extends JsonSource
{
    public function __construct()
    {
        parent::__construct(dirname(__DIR__).'/data/slave.json');
    }

    protected function jsonToItems(array $json): array
    {
        $data = $json['data'] ?? [];
        assert(is_array($data));

        $items = $data['users'] ?? [];

        assert(is_array($items));
        assert(array_is_list($items));

        return $items;
    }

    protected function itemsToJson(array $items): array
    {
        return [
            'data' => [
                'users' => $items,
            ],
            'count' => count($items),
        ];
    }
}
