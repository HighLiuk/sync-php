<?php

namespace HighLiuk\Sync\Examples\Json\Src;

use HighLiuk\Sync\Adapters\Json\JsonReadableSource;

class UsersMasterSource extends JsonReadableSource
{
    public function __construct()
    {
        parent::__construct(dirname(__DIR__) . '/data/master.json');
    }
}
