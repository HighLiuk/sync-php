<?php

namespace HighLiuk\Sync\Examples\Json\Src;

use HighLiuk\Sync\Adapters\Json\JsonReadableSource;

/**
 * @extends JsonReadableSource<int,User>
 */
class UsersMasterSource extends JsonReadableSource
{
    public function __construct()
    {
        parent::__construct(dirname(__DIR__) . '/data/master.json');
    }

    protected function model(): string
    {
        return User::class;
    }
}
