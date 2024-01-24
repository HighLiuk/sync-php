<?php

namespace HighLiuk\Sync\Examples\Json\Src;

use HighLiuk\Sync\Adapters\Json\JsonSource;

/**
 * @extends JsonSource<int,User>
 */
class UsersSlaveSource extends JsonSource
{
    public function __construct()
    {
        parent::__construct(dirname(__DIR__) . '/data/slave.json');
    }

    protected function model(): string
    {
        return User::class;
    }

    protected function &selectData(array &$content): array
    {
        return $content['data']['users'];
    }

    protected function save(): void
    {
        $this->content['count'] = count($this->data);

        parent::save();
    }
}
